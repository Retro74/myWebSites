<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Legg til nytt fag</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 500px;
      margin: 40px auto;
      padding: 0 16px;
    }

    h1 {
      font-size: 1.4rem;
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 4px;
      font-weight: bold;
      font-size: 0.9rem;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 6px 8px;
      font-size: 1rem;
      border: 1px solid #aaa;
      border-radius: 3px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    small {
      display: block;
      color: #666;
      margin-top: -12px;
      margin-bottom: 16px;
      font-size: 0.8rem;
    }

    button[type="submit"] {
      padding: 8px 20px;
      font-size: 1rem;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h1>Legg til nytt fag</h1>

  <form action="insert_new_subject.php" method="POST">

    <label for="subject_code">Fagkode</label>
    <input type="text" id="subject_code" name="subject_code"
           maxlength="20" required placeholder="f.eks. MATH101" />

    <label for="subject_name">Fagnavn</label>
    <input type="text" id="subject_name" name="subject_name"
           maxlength="255" required placeholder="f.eks. Matematikk 1" />

    <label for="credits">Studiepoeng</label>
    <input type="number" id="credits" name="credits"
           min="0" max="30" value="5" required />
    <small>Antall studiepoeng (0–30)</small>

    <button type="submit">Lagre fag</button>

  </form>

</body>
</html>