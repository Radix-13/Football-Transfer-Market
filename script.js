// Show account creation section and hide login
function showAccountCreation() {
    document.getElementById("login-section").classList.add("hidden");
    document.getElementById("account-creation-section").classList.remove("hidden");
}


// Toggle between manager and player forms based on selection
function toggleAccountForm() {
    const role = document.getElementById("new-role").value;
    if (role === "manager") {
        document.getElementById("manager-form").classList.remove("hidden");
        document.getElementById("player-form").classList.add("hidden");
    } else if (role === "player") {
        document.getElementById("player-form").classList.remove("hidden");
        document.getElementById("manager-form").classList.add("hidden");
    }
}

