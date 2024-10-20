<?php
require_once('DBconnect.php');

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role === 'manager') {
        // For Manager login
        $query = mysqli_query($conn, "SELECT * FROM club WHERE email='$email'");
    } else if ($role === 'player') {
        // For Player login
        $query = mysqli_query($conn, "SELECT * FROM players WHERE email='$email'");
    }

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role;
            
            // Redirect based on role
            if ($role === 'manager') {
                header("Location: manager_dashboard.php");
            } else if ($role === 'player') {
                header("Location: player_dashboard.php");
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>
