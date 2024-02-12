<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
</head>
<body>
<div class="form-container">
        <h1>Create an account</h1>
        <form id="register-form" action="register.php" method="post">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name">
            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                title="Enter a valid email address" required><br><br>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" title="Choose your username" required><br><br>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required><br><br>
            <label for="tele">Phone:</label>
            <input type="text" id="tele" name="tele">
            <p>Please specify what type of user you are:</p>
                <input type="radio" id="recycler" name="user_type" value="recycler">
                <label for="recycler">Recycling Company</label><br>
                <input type="radio" id="manu" name="user_type" value="manu">
                <label for="manu">Manufacturer</label><br>
                <input type="radio" id="individual" name="user_type" value="individual">
                <label for="individual">Individual User</label>

            <input type="submit" value="Submit">
        </form>
    </div>

</body>
</html>