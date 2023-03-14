<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="../CSS/buttons.css?v=1">
    <html lang="cs">
  </head>
  <body>
    <header>
    
      <?php
      session_start();
      // Připojení k databázi
      $dbhost = "localhost";
      $dbname = "social";
      $dbuser = "root";
      $dbpass = "root";
      $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

      // Zkontrolujeme připojení k databázi
      if (!$conn) {
        die("Připojení k databázi selhalo: " . mysqli_connect_error());
      }

      // Získání nickname uživatele z URL
      if (isset($_GET['nickname'])) {
        $nickname = mysqli_real_escape_string($conn, $_GET['nickname']);
      }

      // Získání ID uživatele z databáze player podle nickname
      $sql = "SELECT id FROM player WHERE nickname = '$nickname'";
      $result = mysqli_query($conn, $sql);
      if (!$result) {
        die("Chyba v SQL dotazu: " . mysqli_error($conn));
      }
      $row = mysqli_fetch_assoc($result);
      $player_id = $row['id'];

      // Získání informací o uživateli z databáze wall podle player_id
      $sql = "SELECT wall.name, player.nickname AS player_nickname FROM wall INNER JOIN player ON wall.player_id = player.id WHERE wall.player_id = $player_id";
      $result = mysqli_query($conn, $sql);
      if (!$result) {
        die("Chyba v SQL dotazu: " . mysqli_error($conn));
      }
      $row = mysqli_fetch_assoc($result);
      $name = $row['name'];

      // Vypsání názvu stránky, jména uživatele a jeho informací
      echo "<head><title>$nickname</title></head>";
      echo "<h1>$name</h1>";
      echo "<h4>ID: $player_id</h4>";

      mysqli_close($conn);
      ?>


    </header>
    <div class="buttons">
      <?php
      // Připojení k databázi
      $dbhost = "localhost";
      $dbname = "social";
      $dbuser = "root";
      $dbpass = "root";
      $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

      // Zkontrolujeme připojení k databázi
      if (!$conn) {
        die("Připojení k databázi selhalo: " . mysqli_connect_error());
      }
      // Button pro přesměrování na index.php podle user_id z URL
      if (isset($_GET['user_id'])) {
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        echo "<button class='button button1' onclick=\"window.location.href='../PHP/index.php?user_id=$user_id'\">Profil</button>";
      }

      // Button pro odhlášení
      echo "<button class='button button2' onclick=\"window.location.href='../PHP/logout.php'\">Odhlásit se</button>";

      ?>
      </div>
      <?php
  // Připojení k databázi
  $dbhost = "localhost";
  $dbname = "social";
  $dbuser = "root";
  $dbpass = "root";
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Zkontrolujeme připojení k databázi
if (!$conn) {
echo "<p class='error'>Připojení k databázi selhalo: " . mysqli_connect_error() . "</p>";
}

// Získání hráčova ID podle nickname v URL
if (isset($_GET['nickname'])) {
$nickname = $_GET['nickname'];
$query = "SELECT player_id FROM player WHERE nickname = '$nickname'";
$result = mysqli_query($conn, $query);
if ($result) {
$row = mysqli_fetch_assoc($result);
$player_id = $row['player_id'];
}
}

// Získání informací o hráčových příspěvcích ze sloupce 'info' ve wall tabulce
if (isset($player_id)) {
$query = "SELECT info FROM wall WHERE player_id = '$player_id'";
$result = mysqli_query($conn, $query);
if ($result) {
// Vypsání příspěvků
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
echo "<li>" . $row['info'] . "</li>";
}
echo "</ul>";
} else {
echo "<p>Uživatel nemá žádné příspěvky.</p>";
}
}
?>

</body>
<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 16px;
    color: #333;
  }

  h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  p {
    margin-bottom: 10px;
  }

  ul {
    list-style-type: none;
    padding-left: 0;
  }

  li {
    margin-bottom: 10px;
  }

  .error {
    color: red;
    font-weight: bold;
  }
</style>
</body>
</html>


