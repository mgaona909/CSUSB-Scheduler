<?php
    // This file adds a new class for the student
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    // Grabs the ID of the class to add
    $classID = $_POST['add'];
    $studentid = $_SESSION['googleID'];
    
    // Connects with database
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=b18_20197884_csusb", root, NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    // Searches the database if this user already is enrolled in this class
    $stmt = $dbh->prepare("SELECT * FROM enrollment WHERE classID = :classID AND studentid = :studentid");
    $stmt->bindParam(':classID', $classID);
    $stmt->bindParam(':studentid', $studentid);
    $stmt->execute();
    
    if ($stmt->rowCount() != 0) {
        $_SESSION['msg'] = "Already enrolled in this class.";
        
        header('Location: classesStudent.php');
        exit();
    }
    
    $stmt = $dbh->prepare("INSERT INTO enrollment (studentid, classID) VALUES (:studentid, :classID)");
    $stmt->bindParam(':studentid', $studentid);
    $stmt->bindParam(':classID', $classID);

    $stmt->execute();
    
    
    // Class add, send back to class page
    $_SESSION['msg'] = "Class Enrolled";
    header('Location: classesStudent.php');
?>