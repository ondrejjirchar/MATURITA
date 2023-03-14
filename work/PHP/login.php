<!DOCTYPE html>
<html>
<head>
    <title>Přihlášení</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../CSS/table.css?v=1">
    <link rel="stylesheet" type="text/css" href="../CSS/buttons.css?v=1">
    <link rel="stylesheet" type="text/css" href="../CSS/alert.css?v=1">
    <html lang="cs">
</head>
<body>
    <div class="table">
    <h2>Přihlášení</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Jméno: <input type="text" name="nickname"><br><br>
        Heslo: <input type="password" name="password"><br><br>
        <input type="submit" name="submit" value="Přihlásit se">
    </form>
    </div>
    <div class="buttons">
		<button onclick="location.href='../PHP/register.php'">Registrovat</button>
		<button onclick="location.href='../PHP/login.php'">Přihlásit se</button>

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

if(isset($_POST['submit'])) {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    // Kontrola, zda přezdívka a heslo jsou správné v databázi
    $sql = "SELECT * FROM player WHERE nickname='$nickname' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        // Přihlašovací formulář odeslán
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Pokud jsou správné, nastavíme session a přesměrujeme na homepage
            session_start();
            $_SESSION['loggedin'] = true;

            // Získání ID uživatele
            $sql = "SELECT id FROM player WHERE nickname='$nickname'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['id'];

            // Přesměrování na homepage s ID uživatele v URL
            header("Location: ../PHP/index.php?user_id=$user_id");
            exit;
        }
    } else {
        echo "<div class='alert'>Přihlášení selhalo. Zkontrolujte své údaje a zkuste to znovu.</div>";
    }

}

mysqli_close($conn);
?>