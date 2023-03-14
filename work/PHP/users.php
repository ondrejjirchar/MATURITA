<link rel="stylesheet" type="text/css" href="../CSS/tables2.css?v=1">
  <div class="game_table2">
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

// Získání ID přihlášeného uživatele
if(isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}

// Dotaz na získání uživatelů s alespoň jednou stejnou oblíbenou hrou
$sql = "SELECT DISTINCT p.id, p.nickname FROM player_has_game pg1
      INNER JOIN player_has_game pg2 ON pg1.game_id = pg2.game_id
      INNER JOIN player p ON pg2.player_id = p.id
      WHERE pg1.player_id = $user_id AND pg2.player_id != $user_id";

$result = mysqli_query($conn, $sql);

// Vytvoření tabulky pro výstup
echo "<table><tr><th>Uživatel</th><th>Akce</th></tr>";

if (mysqli_num_rows($result) > 0) {
  // Vypsání výsledků do tabulky
  while($row = mysqli_fetch_assoc($result)) {
      $nickname = $row["nickname"];
      $query_params = "user_id=$user_id&nickname=".urlencode($nickname);

      // Dotaz na zjištění, zda řádek již neexistuje
      $check_query = "SELECT * FROM player_has_player WHERE player_id = $user_id AND player_id_friend = ".$row["id"];
      $check_result = mysqli_query($conn, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
        // Pokud již řádek existuje, vypíšeme informaci a zobrazíme odkaz na profil uživatele
        echo "<tr><td><a href='../PHP/user_profile.php?$query_params'>$nickname</a></td><td>Přítel</td></tr>";
      } else {
        // Pokud řádek neexistuje, vytvoříme tlačítko "Přidat" a odkaz na přidání kamaráda
        echo "<tr><td><a href='../PHP/user_profile.php?$query_params'>$nickname</a></td>";
        echo "<td><form method='post' action='../PHP/add_friend.php'>";
        echo "<input type='hidden' name='player_id' value='$user_id'>";
        echo "<input type='hidden' name='player_id_friend' value='".$row["id"]."'>";
        echo "<input type='submit' value='Přidat'>";
        echo "</form></td></tr>";
      }
  }
} else {
  echo "<tr><td>Nebyli nalezeni žádní uživatelé.</td></tr>";
}

echo "</table>";


mysqli_close($conn);

?>
</div>