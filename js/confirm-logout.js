function confirmLogout() {
    var userConfirmation = confirm("Are you sure you want to log out?");
    if (userConfirmation) {
        // User clicked "OK"
        alert("Logging out...");  
    } else {
        // User clicked "Cancel"
        alert("Logout canceled."); 
    }
}

// Add an event listener to the button in the navbar
document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById("logout-button");
    if (logoutButton) {
        logoutButton.addEventListener("click", confirmLogout);
    }
});
