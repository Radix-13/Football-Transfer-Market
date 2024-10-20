<?php
require_once('DBconnect.php');


if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['club']) && isset($_POST['budget']) && isset($_POST['league'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$club = $_POST['club'];
	$league = $_POST['league'];
	$budget = $_POST['budget'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
	$query= mysqli_query($conn, "select *from club where email='$email'");
	if (mysqli_num_rows($query)>0){
		echo "email already exist";}
	else{
        $sql = "INSERT INTO club (email, password, club, league, budget) VALUES ('$email', '$hashedPassword', '$club', '$league', '$budget' )";
		
		$result = mysqli_query($conn, $sql);
		
		if(mysqli_affected_rows($conn)){
	
			
			header("Location: index.php");
		}
		else{
            echo "Failed to register";
			// header("Location: regi.php");
		}
	}

	
}
?>