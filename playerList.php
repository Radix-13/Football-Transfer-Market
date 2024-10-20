<?php
require_once('DBconnect.php');
session_start();
$club_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM players WHERE club_id = '$club_id' ");
$players = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Players</title>
    <link rel="stylesheet" href="playerList.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="manager_dashboard.php">Bids</a></li>
            <li><a href="playerList.php">Players</a></li>
            <li>
                <form action="logout.php" method="POST"><button  class="logout" type="submit">Logout</button></form>
            </li>
        </ul>
    </nav>
    <h1>Players of Your Club</h1>

    <?php if (!empty($players)): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Market Value ($)</th>
                    <th>Injury</th>
                    <th>Nationality</th>
                    <th>Height</th>
                    <th>Weight (kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?= htmlspecialchars($player['name']); ?></td>
                        <td><?= htmlspecialchars($player['position']); ?></td>
                        <td><?= htmlspecialchars($player['market_value']); ?></td>
                        <td><?= htmlspecialchars($player['health_injury']); ?></td>
                        <td><?= htmlspecialchars($player['nationality']); ?></td>
                        <td><?= htmlspecialchars($player['health_height']); ?></td>
                        <td><?= htmlspecialchars($player['health_weight']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No players found in your club.</p>
    <?php endif; ?>
</body>
</html>
