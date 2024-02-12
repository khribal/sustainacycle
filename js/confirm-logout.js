function confirmLogout() {
    var userConfirmation = confirm("Are you sure you want to log out?");
    if (userConfirmation) {
        // User clicked "OK"
        alert("Logging out...");  
        return true;  // Continue with the default behavior (logging out)
    } else {
        // User clicked "Cancel"
        alert("Logout canceled.");
        return false;  // Prevent the default behavior (not logging out)
    }
}

// Add an event listener to the button in the navbar
document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById("logout-button");
    if (logoutButton) {
        logoutButton.addEventListener("click", function (event) {
            // Check the result of confirmLogout and proceed accordingly
            if (!confirmLogout()) {
                event.preventDefault();  // Prevent the default behavior (not logging out)
            }
        });
    }
});
