<?php
    // This file creates a new class
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    $classID = $_POST['delete'];
    
    // Connects with database
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=b18_20197884_csusb", root, NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    unset($_SESSION['class']);
    unset($_SESSION['classID']);
    
    
    if($_SESSION['account'] == "Faculty") {
        
        $stmt = $dbh->prepare("DELETE FROM enrollment WHERE classID = :classID");
        $stmt->bindParam(':classID', $classID);
        $stmt->execute();
        
        $stmt = $dbh->prepare("DELETE FROM classes WHERE classID = :classID");
        $stmt->bindParam(':classID', $classID);
        $stmt->execute();
        
        $stmt = $dbh->prepare("DELETE FROM events WHERE class = :classID");
        $stmt->bindParam(':classID', $classID);
        $stmt->execute();
        
        $_SESSION['msg'] = "Class Deleted";
        header('Location: classesFaculty.php');
    }
    else {
        
        $studentid = $_SESSION['googleID'];
        
        $stmt = $dbh->prepare("DELETE FROM enrollment WHERE classID = :classID AND studentid = :studentid");
        $stmt->bindParam(':studentid', $studentid);
        $stmt->bindParam(':classID', $classID);
        $stmt->execute();
        
        $_SESSION['msg'] = "Class Removed";
        header('Location: classesStudent.php');
    }
?>