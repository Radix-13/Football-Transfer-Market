<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Transfer Market</title>
    <link rel="stylesheet" href="styles.css">
</head>




<body>
    <div class="background">
        <div class="overlay"></div>
    </div>




    <header>
        <h1>Football Transfer Market</h1>
        <p>Welcome to the ultimate football transfer bidding platform!</p>
    </header>




    <!-- Login Section -->
    <section id="login-section">
        <h2>Login</h2>
        <form id="login-form"  action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>


            <label for="role">Login as:</label>
            <select id="role" name="role" required>
                <option value="manager">Manager</option>
                <option value="player">Player</option>
            </select>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href=# onclick="showAccountCreation()">Click here to create one.</a></p>
    </section>




    <!-- Account Creation Section -->
    <section id="account-creation-section" class="hidden">
        <h2>Create an Account</h2>
        <label for="new-role">Create Account as:</label>
        <select id="new-role" name="new-role" required onchange="toggleAccountForm()">
            <option value="manager">Manager</option>
            <option value="player">Player</option>
        </select>




        <!-- Manager Form -->
        <form id="manager-form" class="hidden" action="managerReg.php" method="POST">
            <h3>Manager Sign-Up</h3>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="club">Club Name:</label>
            <input type="text" id="club" name="club" required>

            <label for="league">League:</label>
            <input type="text" id="league" name="league" required>

            
            <label for="budget">Budget:</label>
            <input type="number" id="budget" name="budget" required>


            <button type="submit">Create Account</button>
        </form>




        <!-- Player Form -->
        <form id="player-form" class="hidden"  action="playerReg.php" method="POST" >
            <h3>Player Sign-Up</h3>

            <label for="email">Email:</label>
            <input type="email" id="email-" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="wage">Wage:</label>
            <input type="number" id="wage" name="wage" required step="0.01">

            <label for="market-value">Market Value:</label>
            <input type="number" id="market-value" name="market-value" required step="0.01">

            <label for="health-injury">Health Injury:</label>
            <input type="text" id="health-injury" name="health-injury">

            <label for="health-height">Height (cm):</label>
            <input type="number" id="health-height" name="health-height" step="0.01">

            <label for="health-weight">Weight (kg):</label>
            <input type="number" id="health-weight" name="health-weight" step="0.01">

            <label for="preferred-feet">Preferred Feet:</label>
            <select id="preferred-feet" name="preferred-feet" required>
                <option value="left">Left</option>
                <option value="right">Right</option>
                <option value="both">Both</option>
            </select>

            <label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality" required>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required>

            <label for="date-of-birth">Date of Birth:</label>
            <input type="date" id="date-of-birth" name="date-of-birth" required>

            <button type="submit">Create Account</button>
        </form>
    </section>




    <script src="script.js"></script>
</body>




</html>