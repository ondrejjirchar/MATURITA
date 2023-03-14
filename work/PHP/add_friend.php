<?php
// Připojení k databázi (stejně jako v původním souboru)
$dbhost = "localhost";
$dbname = "social";
$dbuser = "root";
$dbpass = "root";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Zkontrolujeme připojení k databázi
if (!$conn) {
  die("Připojení k databázi selhalo: " . mysqli_connect_error());
}

// Získání hodnot z POST proměnných
$player_id = $_POST["player_id"];
$player_id_friend = $_POST["player_id_friend"];

// Dotaz na zjištění, zda řádek již neexistuje
$check_query = "SELECT * FROM player_has_player WHERE player_id = $player_id AND player_id_friend = $player_id_friend";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
  // Pokud již řádek existuje, neprovádíme vkládání a vypíšeme chybu
  echo "Tento uživatel už se nachází v seznamu přátel.";
} else {
  // Pokud řádek neexistuje, provedeme vkládání nového řádku
  $insert_query = "INSERT INTO player_has_player (player_id, player_id_friend) VALUES ($player_id, $player_id_friend)";
  if (mysqli_query($conn, $insert_query)) {
    // Pokud se dotaz podaří, přesměrujeme uživatele zpět na stránku s výsledky
    header("Location: ../PHP/index.php?user_id=$player_id");
    exit;
     // přidána funkce pro okamžité přesměrování
  } else {
    echo "Chyba při vkládání do databáze: " . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>