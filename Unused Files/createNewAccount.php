<?php
    // This file creates a new user account
    
    session_start();
    
    // Grabs the entered information
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conPassword = $_POST['conPassword'];
    
    
    // If nothing was typed in go back
    if (!$fname || !$lname || !$username || !$password || !$conPassword || $email) {
        header('Location: accountCreation.php?error=1');
        exit();
    }
    
    // Connects with database
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=csusb", root, NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    // Searches the database for a username that matches the typed in username
    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    // If the username exists go back to account creation
    if ($stmt->rowCount() != 0) {
        header('Location: accountCreation.php?error=3');
        exit();
    }
    
    // If the two entered passwords do not match, go back
    if ($password != $conPassword) {
        header('Location: accountCreation.php?error=2');
        exit();
    }
    
    $stmt = $dbh->prepare("INSERT INTO users (username, password, fname, lname, email) VALUES (:username, :password, :fname, :lname, :email)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT));
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    
    // Account created, send to login page
    $_SESSION['msg'] = "New Account Created";
    header('Location: index.php');
?>