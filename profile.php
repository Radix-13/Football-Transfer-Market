<?php
require_once('DBconnect.php');
session_start();
$player_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM players WHERE id = '$player_id' ");
$player = mysqli_fetch_all($query, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $new_name = $_POST['name'];
    $new_injury = $_POST['injury'];

    mysqli_query($conn, "UPDATE players SET name = '$new_name', health_injury = '$new_injury' WHERE id = '$player_id'");

    $query = mysqli_query($conn, "SELECT * FROM players WHERE id = '$player_id' ");
    $player = mysqli_fetch_all($query, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="player_dashboard.php">Bids</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li>
            <form action="logout.php" method="POST"><button class="logout" type="submit">Logout</button></form>
        </li>
    </ul>
</nav>
<div class="player-info-container">
    <h1>Player Information</h1>
    <?php if (!empty($player)): ?>
        <ul class="player-info-list">
            <?php foreach ($player as $p): ?>
                <li><strong>Name:</strong> <?= htmlspecialchars($p['name']); ?></li>
                <li><strong>Position:</strong> <?= htmlspecialchars($p['position']); ?></li>
                <?php
                $club_id = $p['club_id'];
                $club_query = mysqli_query($conn, "SELECT club FROM club WHERE id = '$club_id'");
                $club = mysqli_fetch_assoc($club_query);
                ?>
                <li><strong>Club:</strong> <?= htmlspecialchars($club['club'] ?? ''); ?></li>
                <li><strong>Wage:</strong> <?= htmlspecialchars($p['wage']); ?></li>
                <li><strong>Market Value:</strong> <?= htmlspecialchars($p['market_value']); ?> USD</li>
                <li><strong>Sold For:</strong> <?= htmlspecialchars($p['bid_amount']); ?> USD</li>
                <li><strong>Injury:</strong> <?= htmlspecialchars($p['health_injury']); ?></li>
                <li><strong>Date of Birth:</strong> <?= htmlspecialchars($p['date_of_birth']); ?></li>
                <li><strong>Preferred foot:</strong> <?= htmlspecialchars($p['preferred_feet']); ?></li>
                <li>
                <form action="" method="POST">
                    <label for="">Name</label>
                    <input type="text" name="name" placeholder="Update name" value="<?= htmlspecialchars($p['name']); ?>" required>
                    
                    <label for="">Injury Status</label>
                    <select name="injury" required>
                        <option value="Yes" <?= ($p['health_injury'] === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="No" <?= ($p['health_injury'] === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                    
                    <button class="update" type="submit" name="update_info">Update Info</button>
                </form>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No player information available.</p>
    <?php endif; ?>
</div>
</body>
</html>
