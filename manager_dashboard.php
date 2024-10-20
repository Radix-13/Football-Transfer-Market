<?php
session_start();
require_once('DBconnect.php');
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$club_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM players WHERE is_sold = 0");
$players = mysqli_fetch_all($query, MYSQLI_ASSOC);


$bids_query = mysqli_query($conn, "SELECT player_id, MAX(bid_amount) as highest_bid FROM bids GROUP BY player_id");
$club =  mysqli_query($conn, "SELECT club, budget from club where email = '$email' ");
$club_result = mysqli_fetch_assoc($club);

$budget = $club_result['budget'] ?? 'Unknown Budget'; 

$club_name = $club_result['club'] ?? 'Unknown Club'; 
$highest_bids = [];
while ($row = mysqli_fetch_assoc($bids_query)) {
    $highest_bids[$row['player_id']] = $row['highest_bid'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="manager.css">
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
    <section>
    <h1><?php echo $club_name; ?></h1>
    <p>Welcome, <strong><?php echo $email; ?></strong>!</p>
    <h2>Remaining Budget</h2>
    <p><strong>$<?php echo $budget; ?></strong></p>

    <h2>Available Players</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Highest Bid</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($players as $player): ?>
        <tr>
            <td><?php echo $player['name']; ?></td>
            <td>
                <?php 
                // Display the highest bid if it exists
                echo isset($highest_bids[$player['id']]) ? $highest_bids[$player['id']] : 'No bids yet'; 
                ?>
            </td>
            <td><?php echo $player['is_sold'] ? 'Sold' : 'Available'; ?></td>
            <td>
                <form action="bid.php" method="POST">
                    <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                    <input type="number" name="bid_amount" required step="0.01" placeholder="Enter your bid">
                    <button type="submit" <?php echo $player['is_sold'] ? 'disabled' : ''; ?>>Bid</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </section>
   
</body>
</html>
