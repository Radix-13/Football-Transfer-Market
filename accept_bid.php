<?php
session_start();
require_once('DBconnect.php'); // Ensure this file contains your database connection code

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$player_id = $_SESSION['user_id']; // Assuming player ID is passed via the URL

// Handle bid acceptance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_bid'])) {
    $accepted_club_id = $_POST['club_id'];
    $bid_amount = $_POST['bid_amount']; // Get the bid amount from the form

    // Fetch the club name and budget
    $club_query =  mysqli_query($conn, "SELECT club, budget FROM club WHERE id = '$accepted_club_id'");
    $club_result = mysqli_fetch_assoc($club_query);
    $club_name = $club_result['club'] ?? 'Unknown Club'; 
    $current_budget = $club_result['budget'] ?? 0;

    // Check if the club has enough budget
    if ($current_budget >= $bid_amount) {
        $new_budget = $current_budget - $bid_amount;
        
        // Update the club's budget
        $update_budget_query = "UPDATE club SET budget = '$new_budget' WHERE id = '$accepted_club_id'";
        if (mysqli_query($conn, $update_budget_query)) {
            // Update the player's row to set club_id, is_sold, and bid_amount
            $update_player_query = "UPDATE players SET club_id = '$accepted_club_id', is_sold = 1, bid_amount = '$bid_amount' WHERE id = '$player_id'";
            
            if (mysqli_query($conn, $update_player_query)) {
                // Delete all bids for the accepted player
                $delete_bids_query = "DELETE FROM bids WHERE player_id = '$player_id'";
                mysqli_query($conn, $delete_bids_query); // You may want to check for errors here as well
                
                header("Location: player_dashboard.php?msg=Bid accepted! Player has been sold to club : $club_name for an amount of $ $bid_amount.");
                exit();
            } else {
                header("Location: player_dashboard.php?error=Error updating player: " . mysqli_error($conn));
                exit();
            }
        } else {
            header("Location: player_dashboard.php?error=Error updating budget: " . mysqli_error($conn));
            exit();
        }
    } else {
        header("Location: player_dashboard.php?error=Club does not have enough budget to accept the bid.");
        exit();
    }
} else {
    header("Location: player_dashboard.php");
    exit();
}
