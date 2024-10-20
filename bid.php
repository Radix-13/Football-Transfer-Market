<?php
session_start();
require_once('DBconnect.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$club_id = $_SESSION['user_id']; // Assuming club ID is stored in the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player_id = $_POST['player_id'];
    $bid_amount = $_POST['bid_amount'];

    // Check if the player is available for bidding
    $query = mysqli_query($conn, "SELECT * FROM players WHERE id = '$player_id'");
    $player = mysqli_fetch_assoc($query);

    if ($player && !$player['is_sold']) {
        // Insert the bid into the database
        $insert_query = "INSERT INTO bids (player_id, club_id, bid_amount) VALUES ('$player_id', '$club_id', '$bid_amount')";
        mysqli_query($conn, $insert_query);

        // Update the player status if necessary
        // For example, if the bid amount is the highest, you might want to update the player's status or record
        // Here, you'd need logic to check if this bid is the highest and update accordingly.

        // Redirect back to the dashboard
        header("Location: manager_dashboard.php");
        exit();
    } else {
        // Handle the case where the player is sold or doesn't exist
        echo "Player is either sold or does not exist.";
    }
}
?>
