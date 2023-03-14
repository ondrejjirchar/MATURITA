<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>Registrace</title>
    <link rel="stylesheet" type="text/css" href="../CSS/alert.css?v=1">
    <link rel="stylesheet" type="text/css" href="../CSS/table.css?v=1">
    <link rel="stylesheet" type="text/css" href="../CSS/buttons.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <html lang="cs">
</head>
<body>
<div class="buttons">
        <button onclick="location.href='../PHP/register.php'">Registrovat</button>
        <button onclick="location.href='../PHP/login.php'">Přihlásit se</button>
</div>
<div class="table">
    <h2>Registrace</h2>
    <form method="POST" action="">
    <label for="nickname">Jméno:</label>
    <input type="text" name="nickname" required>

    <label for="password">Heslo:</label>
    <input type="password" name="password" required>

    <input type="submit" name="submit" value="Registrovat se">
</form>
</div>
</body>
</html>
<?php
// Připojení k databázi
$dbhost = "localhost";
$dbname = "social";
$dbuser = "root";
$dbpass = "root";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Připojení k databázi selhalo: " . mysqli_connect_error());
}

// Zpracování formuláře pro registraci uživatele
if (isset($_POST['submit'])) {
    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Kontrola, zda uživatel se zadaným nickname již neexistuje v databázi
    $check_query = "SELECT * FROM player WHERE nickname = '$nickname'";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='alert'>Uživatel se zadaným uživatelským jménem již existuje.</div>";
    } else {
        // Vytvoření uživatele v databázi
        $sql = "INSERT INTO player (nickname, password) VALUES ('$nickname', '$password')";
        if (mysqli_query($conn, $sql)) {
            // přesměrování na stránku pro přihlášení
            header("Location: ../PHP/login.php");
            exit();
        } else {
            echo "Chyba při registraci: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn); // Uzavření spojení s databází
?>


