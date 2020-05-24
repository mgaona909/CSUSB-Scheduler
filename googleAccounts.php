<?php
    // This file creates a new user account
    session_start();
    require_once 'vendor/autoload.php';
    require 'dbcredentials.php';
    
    
    $request = json_decode(file_get_contents("php://input"), true);
    
    // Get $id_token via HTTPS POST.
    $fname = $request['fname'];
    $lname = $request['lname'];
    $email = $request['email'];
    $image = $request['image'];
    $id_token = $request['id_token'];
    
    if(!$id_token){
        $userid = 0;
    } 
    else {
        $client = new Google_Client();
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
          $userid = $payload['sub'];
        } else {
          // Invalid ID token
          echo "<script>console.log('Invalid google ID token');</script>";
        }
    }
        
    $dbh = connectDB();
    
    // Searches the database for a username that matches the typed in username
    $stmt = $dbh->prepare("SELECT * FROM googleUsers WHERE googleID = :googleID");
    $stmt->bindParam(':googleID', $userid);
    $stmt->execute();
    
    //If username is found, get googleID from the database
    $row = $stmt->fetch();
    $_SESSION['googleID'] = $userid;
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['email'] = $email;
    $_SESSION['image'] = $image;
    $_SESSION['image'] = $image;
    
    if (strpos($email, '@csusb.edu') !== false || $email == "codemonkey552@gmail.com" || $email == "mgaona909@gmail.com") {
        $account = "Faculty";
    } else {
        $account = "Student";
    }
    
    $_SESSION['account'] = $account;
    
    // If there is no such user, add to db
    if ($stmt->rowCount() == 0) {
        $stmt = $dbh->prepare("INSERT INTO googleUsers (googleID, fname, lname, email, account) VALUES (:googleID, :fname, :lname, :email, :account)");
        $stmt->bindParam(':googleID', $userid);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':account', $account);
        $stmt->execute();
    }
    
    // Account created, send to login page
    $response = array('result'=>'success');
    print(json_encode($response));
    exit();

?>