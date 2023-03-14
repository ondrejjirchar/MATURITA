<!DOCTYPE html>
<head>
    <form method="post">
    <link rel="stylesheet" type="text/css" href="../CSS/tables2.css?v=1">
    </head>
    <div class="tables2">
    <table>
  <tr>
    <th>Název hry</th>
    <th>Oblíbená</th>
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

      // Získání seznamu her z databáze
      $sql = "SELECT * FROM game";
      $result = mysqli_query($conn, $sql);

      // Získání ID uživatele z funkce
      $player_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

      // Získání seznamu oblíbených her uživatele z databáze
      $sql_favorite_games = "SELECT game_id FROM player_has_game WHERE player_id = '$player_id'";
      $result_favorite_games = mysqli_query($conn, $sql_favorite_games);
      $favorite_games = array();

      while ($row = mysqli_fetch_assoc($result_favorite_games)) {
        $favorite_games[] = $row['game_id'];
      }

      // Vypsání seznamu her do tabulky
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td><input type='checkbox' name='game[]' value='" . htmlspecialchars($row["id"]) . "'";
        if (in_array($row['id'], $favorite_games)) {
          echo " checked";
        }
        echo "></td>";
        echo "</tr>";
      
      }
      

      // Získání oblíbených her z odeslaných dat formuláře
      if (isset($_POST["game"])) {
        $selected_games = $_POST["game"];

        // Přidání nových oblíbených her hráče do databáze
        $new_games = array_diff($selected_games, $favorite_games);
        foreach ($new_games as $game_id) {
          $sql_add = "INSERT INTO player_has_game (player_id, game_id) VALUES ('$player_id', '$game_id')";
          mysqli_query($conn, $sql_add);
        }

        // Odstranění her, které byly odškrtnuty
        $removed_games = array_diff($favorite_games, $selected_games);
        foreach ($removed_games as $game_id) {
          $sql_remove = "DELETE FROM player_has_game WHERE player_id = '$player_id' AND game_id = '$game_id'";
          mysqli_query($conn, $sql_remove);
        }

        // Přesměrování na aktualizovanou stránku se seznamem her
        header("Refresh:0");
      }
      
    ?>
    <script>
function checkAll() {
  var checkboxes = document.getElementsByName("game[]");
  for(var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = true;
  }
}

function uncheckAll() {
  var checkboxes = document.getElementsByName("game[]");
  for(var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = false;
  }
}
</script>
  </tr>
  <tr>
  <td colspan="2" style="text-align: center;">
    <button type="button" onclick="checkAll()">Označit vše</button>
    <button type="button" onclick="uncheckAll()">Odznačit vše</button>
  </td>
</tr>

  <tr>
      <td colspan="2" style="text-align: center;">
        <button type="submit" name="submit" style="width: 100%;">Uložit změny</button>
      </td>
    </tr>
</table>
</form>
</div>
</html>