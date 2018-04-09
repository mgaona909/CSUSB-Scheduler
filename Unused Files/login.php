<?php
    // This file logs the selected user in
    
    session_start();
    
    // Grabs the typed in user and typed in password from index.php
    $username = $_POST['username'];
    $submitted_password = $_POST['password'];
    
    // If nothing was typed in, it redirects back to index.php
    if (!$username || !$submitted_password) {
        header('Location: index.php?error=1');
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
    
    // If the username is not found, go back to index.php
    if ($stmt->rowCount() == 0) {
        header('Location: index.php?error=2');
        exit();
    }
    
    // Compares the password of the username in the database,
    // with the typed in password
    $row = $stmt->fetch();
    $actual_password = $row["password"];
    $fname = $row["fname"];
    
    // If the two passwords are not the same, go back to index.php
    if (password_verify($submitted_password, $actual_password)){
        // Logs the user into the session user
        $_SESSION['username'] = $username;
        $_SESSION['fname'] = $fname;
        // Logs in, sends back to home page
        header('Location: home.php');   
    }else{    
        header('Location: index.php?error=2');
        exit;
    }

?>