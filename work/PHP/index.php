<!DOCTYPE html>
<html>
  <head>
    <title>Můj profil</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="../CSS/buttons.css?v=1">
    <link rel="stylesheet" type="text/css" href="../CSS/buttons2.css?v=1">
    <link rel="stylesheet" type="text/css" href="../CSS/form.css?v=1">
    <html lang="cs">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      // skryjeme všechny tabulky při načtení stránky
      $('.table-container').hide();

      // zobrazíme nebo skryjeme tabulky patřící k třídě po kliknutí na tlačítko
      $('.button').click(function() {
        var tableClass = $(this).data('table');
        $('.' + tableClass).toggle();
      });
    });
  </script>
  </head>
  <body>
    <header>
    <div class="buttons">
        <ul>
        <button onclick="location.reload();" class="button">Profil</button>

        <button onclick="location.href='../PHP/logout.php'" class="button">Odhlásit se</button>
        </ul>
        </div>
      <h1>Moje stránka</h1>
      <?php if(isset($_GET['user_id'])) { echo "<h3>ID: " . $_GET['user_id'] . "</h3>"; } ?>
      
    </header>
    <div class="buttons2">
    <button class="button" data-table="games-table">Hry</button>
  <button class="button" data-table="users-table">Uživatelé</button>
  <button class="button" data-table="friends-table">Přátelé</button>
  </div>
  <div class="table-container games-table">
    <?php include '../PHP/games.php'; ?>
  </div>


  <div class="table-container users-table">
    <?php include '../PHP/users.php'; ?>
  </div>

  <div class="table-container friends-table">
    <?php include '../PHP/friends.php'; ?>
  </div>
 

  </body>
  <div class="form">
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

// Získání hodnoty player_id z URL adresy
$player_id = $_GET["user_id"];

// Zkontrolujeme, zda uživatel již má svoji wall v databázi
$sql = "SELECT * FROM wall WHERE player_id = '$player_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  // Pokud uživatel nemá svoji wall v databázi, vytvoříme novou wall
  $sql = "INSERT INTO wall (player_id) VALUES ('$player_id')";
  if ($conn->query($sql) === FALSE) {
    echo "Chyba při vkládání dat: " . $conn->error;
    $conn->close();
    exit();
  }
}

// Zkontrolujeme, zda byl odeslán formulář
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Získání hodnoty info z formuláře
  $info = $_POST["info"];
  
  // Vložení dat do databáze
  $sql = "INSERT INTO info (info, wall_id) SELECT '$info', id FROM wall WHERE player_id = '$player_id'";
  
  }


// Zobrazení formuláře pro přidání příspěvku
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label for="info">Napsat příspěvek:</label>
  <input type="text" id="info" name="info"><br><br>
  <input type="submit" value="Přidat">
</form>
<?php
// Zobrazení seznamu všech příspěvků pro daného hráče
$sql = "SELECT * FROM info WHERE wall_id = (SELECT id FROM wall WHERE player_id = '$player_id')";
$result = $conn->query($sql);
if ($result) {
  // Vypsání příspěvků
  while ($row = mysqli_fetch_assoc($result)) {
echo "Textový příspěvek: " . $row["info"]. "<br>";
}
} else {
echo "Žádné příspěvky.";
}

mysqli_close($conn);
?>
</div>
</html>
