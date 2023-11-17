<?php
// Start a new session
global $mysqli;
session_start();

// Include database connection settings
require 'conectare.php';

// Check if the form data (email and password) have been sent
if (!isset($_POST['email'], $_POST['password'])) {
    // If the required data is not present, exit and prompt the user to fill in
    exit('Completati email si password!');
}

// Prepare a SQL statement to prevent SQL injection
if ($stmt = $mysqli->prepare('SELECT ID_Administrator, Parola FROM administrator WHERE Email = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc.); in our case, email is a string
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();

    // Store the result to check if the account exists in the database
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Account exists, now we verify the password
        if (password_verify($_POST['password'], $hashed_password)) {
            // Verification successful! User has logged in
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['id'] = $id;
            // Redirect to home page
            header('Location: profil.php');
            exit();
        } else {
            // Incorrect password
            echo 'Incorrect email or password!';
        }
    } else {
        // Incorrect email
        echo 'Incorrect email or password!';
    }
    // Close the prepared statement
    $stmt->close();
} else {
    // Handle SQL preparation error
    // It's a good practice to handle errors like this
    exit('Could not prepare the statement!');
}

$mysqli->close();