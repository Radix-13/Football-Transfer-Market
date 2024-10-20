<?php
session_start();
require_once('DBconnect.php'); 

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$player_id = $_SESSION['user_id']; 
$player =  mysqli_query($conn, "SELECT name from players where email = '$email' ");
$player_result = mysqli_fetch_assoc($player);
$player_name = $player_result['name'] ?? 'Unknown Club'; 
$bids_query = mysqli_query($conn, "
    SELECT b.club_id, MAX(b.bid_amount) AS highest_bid
    FROM bids b
    WHERE b.player_id = '$player_id'
    GROUP BY b.club_id
");
$bids = mysqli_fetch_all($bids_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard</title>
    <link rel="stylesheet" href="players.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="player_dashboard.php">Bids</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li>
                <form action="logout.php" method="POST"><button  class="logout" type="submit">Logout</button></form>
            </li>
        </ul>
    </nav>
    <section>
    <p>Welcome, <strong><?php echo htmlspecialchars($email); ?></strong>!</p>
    <h2>Bids for <?php echo htmlspecialchars($player_name); ?></h2>
    <?php if (isset($_GET['msg'])): ?>
        <p><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php elseif (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <table>
    <?php if (!empty($bids)): ?>
        <tr>
            <th>Club ID</th>
            <th>Club Name</th>
            <th>Highest Bid Amount</th>
            <th>Action</th>
        </tr>
            <?php foreach ($bids as $bid):
                $club_id = $bid['club_id'];
                $club_query = mysqli_query($conn, "SELECT * FROM club WHERE id = '$club_id'");
                $club = mysqli_fetch_assoc($club_query); // Use fetch_assoc for a single result
                ?>

            <tr>
                <td><?php echo htmlspecialchars($bid['club_id']); ?></td>
                <td><?php echo htmlspecialchars($club['club']); ?></td> <!-- Use single club result -->
                <td><?php echo htmlspecialchars($bid['highest_bid']); ?></td>
                <td>
                    <form action="accept_bid.php" method="POST">
                        <input type="hidden" name="club_id" value="<?php echo htmlspecialchars($bid['club_id']); ?>">
                        <input type="hidden" name="bid_amount" value="<?php echo htmlspecialchars($bid['highest_bid']); ?>">
                        <button type="submit" name="accept_bid">Accept Bid</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No bids yet for this player.</td>
            </tr>
        <?php endif; ?>
    </table>
    </section>

</body>
</html>
