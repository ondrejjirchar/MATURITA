<link rel="stylesheet" type="text/css" href="../CSS/tables2.css?v=1">
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

if(isset($_GET['user_id']) && isset($_GET['nickname'])) {
    $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
    $nickname = mysqli_real_escape_string($connection, $_GET['nickname']);

    $query = "SELECT player_id FROM player WHERE user_id = '$user_id'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $player_id = $row['player_id'];

    $query = "SELECT player_id FROM player WHERE nickname = '$nickname'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $player_id_friend = $row['player_id'];

    $query = "INSERT INTO player_has_player (player_id, player_id_friend) VALUES ('$player_id', '$player_id_friend')";
    mysqli_query($connection, $query);
}

if(isset($_GET['user_id_remove']) && isset($_GET['nickname_remove'])) {
    $user_id_remove = mysqli_real_escape_string($connection, $_GET['user_id_remove']);
    $nickname_remove = mysqli_real_escape_string($connection, $_GET['nickname_remove']);

    $query = "SELECT player_id FROM player WHERE user_id = '$user_id_remove'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $player_id_remove = $row['player_id'];

    $query = "SELECT player_id FROM player WHERE nickname = '$nickname_remove'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $player_id_friend_remove = $row['player_id'];

    $query = "DELETE FROM player_has_player WHERE player_id = '$player_id_remove' AND player_id_friend = '$player_id_friend_remove'";
    mysqli_query($connection, $query);
}
?>
<div class="tables2">
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

// Získání ID přihlášeného uživatele z URL adresy
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    // Pokud v URL adrese není user_id, skript končí
    die("Chybí parametr user_id v URL adrese.");
}

// Pokud bylo kliknuto na tlačítko pro odebrání uživatele z přátel
if(isset($_POST['remove_friend'])) {
    $friend_id = $_POST['friend_id'];
    
    // SQL dotaz na odstranění uživatele z přátel
    $sql_remove = "DELETE FROM player_has_player
                   WHERE player_id = $user_id AND player_id_friend = $friend_id";
    
    if ($conn->query($sql_remove) === TRUE) {
    } else {
        echo "Chyba při odebírání uživatele z přátel: " . $conn->error;
    }
}

// SQL dotaz na výběr přátel daného uživatele
$sql = "SELECT player.id, player.nickname
FROM player_has_player
JOIN player ON player_has_player.player_id_friend = player.id
WHERE player_has_player.player_id = $user_id";

$result = $conn->query($sql);

// Výpis seznamu přátel
if ($result->num_rows > 0) {
echo "<table>
        <tr>
            <th>Přítel</th>
            <th>Akce</th>
        </tr>";
while($row = $result->fetch_assoc()) {
$friend_id = $row["id"];
$friend_nickname = $row["nickname"];

    // Odkaz na profil uživatele podle jeho nickname
    // Přidání hodnoty user_id do URL adresy
    $query_params = http_build_query(array('nickname' => $friend_nickname, 'user_id' => $user_id));
    $profile_url = "../PHP/user_profile.php?" . $query_params;
    
    // Vytvoření tlačítka pro odebrání uživatele z přátel a odkazu na profil
    echo "<tr>
              <td><a href='$profile_url'>$friend_nickname</a></td>
              <td>
                  <form method='post'>
                      <input type='hidden' name='friend_id' value='$friend_id'>
                      <input type='submit' name='remove_friend' value='Odebrat'>
                  </form>
              </td>
          </tr>";
          
}
echo "</table>";
} else {
echo "Tento uživatel nemá žádné přátele.";
}

mysqli_close($conn);
?> 
</div>