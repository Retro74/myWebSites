<?php
// ============================================
// save_consent.php
// Tar imot samtykkedata og lagrer i databasen
// ============================================

session_start();

// --- Databasetilkobling ---
$host = 'localhost';
$db   = 'skole_db';
$user = 'root';
$pass = 'passord';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Databasefeil']);
    exit;
}

// --- Kun POST-forespørsler er tillatt ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Kun POST er tillatt']);
    exit;
}

// --- Hent JSON-data fra JavaScript fetch() ---
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Ugyldig data']);
    exit;
}

// --- Hjelpefunction: rens og valider method ---
function validerMethod(string $method): string {
    $gyldige = ['accept_all', 'deny_all', 'custom'];
    return in_array($method, $gyldige) ? $method : 'custom';
}

// --- Bygg samtykke-array ---
$method = validerMethod($data['method'] ?? 'custom');

// Ved accept_all → sett alt til true
// Ved deny_all   → sett alt til false
// Ved custom     → bruk det brukeren valgte
$necessary   = 1; // Alltid på!
$statistics  = 0;
$marketing   = 0;
$preferences = 0;

if ($method === 'accept_all') {
    $statistics = $marketing = $preferences = 1;
} elseif ($method === 'custom') {
    $statistics  = isset($data['statistics'])  && $data['statistics']  ? 1 : 0;
    $marketing   = isset($data['marketing'])   && $data['marketing']   ? 1 : 0;
    $preferences = isset($data['preferences']) && $data['preferences'] ? 1 : 0;
}
// deny_all: alle forblir 0 (standard over)

// --- Hent bruker-ID hvis innlogget ---
$user_id = $_SESSION['user_id'] ?? null;

// --- Lagre i databasen ---
$sql = "INSERT INTO cookie_consent
            (user_id, session_id, necessary, statistics, marketing, preferences,
             method, consent_version, ip_address, user_agent)
        VALUES
            (:user_id, :session_id, :necessary, :statistics, :marketing, :preferences,
             :method, :consent_version, :ip_address, :user_agent)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':user_id'         => $user_id,
    ':session_id'      => session_id(),
    ':necessary'       => $necessary,
    ':statistics'      => $statistics,
    ':marketing'       => $marketing,
    ':preferences'     => $preferences,
    ':method'          => $method,
    ':consent_version' => 'v1.0',
    ':ip_address'      => $_SERVER['REMOTE_ADDR'] ?? null,
    ':user_agent'      => $_SERVER['HTTP_USER_AGENT'] ?? null,
]);

// --- Lagre samtykket i en cookie (30 dager) ---
// Slik slipper vi å vise popup igjen neste besøk
$cookieData = json_encode([
    'necessary'   => $necessary,
    'statistics'  => $statistics,
    'marketing'   => $marketing,
    'preferences' => $preferences,
    'version'     => 'v1.0'
]);

setcookie(
    'cookie_consent',           // Navn
    $cookieData,                // Verdi (JSON)
    time() + (30 * 24 * 3600), // Utløper om 30 dager
    '/',                        // Gjelder hele nettstedet
    '',                         // Domain
    true,                       // Secure (kun HTTPS)
    true                        // HttpOnly (ikke tilgjengelig for JS)
);

// --- Send svar tilbake til JavaScript ---
header('Content-Type: application/json');
echo json_encode([
    'status'  => 'ok',
    'message' => 'Samtykke lagret',
    'consent' => [
        'statistics'  => (bool)$statistics,
        'marketing'   => (bool)$marketing,
        'preferences' => (bool)$preferences,
    ]
]);
