<?php
require_once('DBconnect.php');

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['wage']) && isset($_POST['market-value']) && isset($_POST['preferred-feet']) && isset($_POST['nationality']) && isset($_POST['position']) && isset($_POST['date-of-birth'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $wage = $_POST['wage'];
    $marketValue = $_POST['market-value'];
    $healthInjury = isset($_POST['health-injury']) ? $_POST['health-injury'] : null;
    $healthHeight = isset($_POST['health-height']) ? $_POST['health-height'] : null;
    $healthWeight = isset($_POST['health-weight']) ? $_POST['health-weight'] : null;
    $preferredFeet = $_POST['preferred-feet'];
    $nationality = $_POST['nationality'];
    $position = $_POST['position'];
    $dateOfBirth = $_POST['date-of-birth'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Check if the email already exists
    $query = mysqli_query($conn, "SELECT * FROM players WHERE email='$email'");
    
    if (mysqli_num_rows($query) > 0) {
        echo "Email already exists";
    } else {
        $sql = "INSERT INTO players (email, password, name, wage, market_value, health_injury, health_height, health_weight, preferred_feet, nationality, position, date_of_birth) 
                VALUES ('$email', '$hashedPassword', '$name', '$wage', '$marketValue', '$healthInjury', '$healthHeight', '$healthWeight', '$preferredFeet', '$nationality', '$position', '$dateOfBirth')";
        
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_affected_rows($conn)) {
            header("Location: index.php"); // Redirect to the main page upon success
        } else {
            echo "Failed to register player";
        }
    }
}
?>
