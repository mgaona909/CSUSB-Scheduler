<?php
    // This file creates a new class
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    // Grabs the entered information
    $facultyid = $_SESSION['googleID'];
    $department = $_POST['department'];
    $course = $_POST['course'];
    $instructor = $_POST['instructor'];
    $session = $_POST['session'];
    
    if (!$department || !$course || !$session) {
        header('Location: classesFaculty.php?error=1');
        exit();
    }
    
    // Connects with database
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=b18_20197884_csusb", root, NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    // Searches the database if this user made a duplicate class
    $stmt = $dbh->prepare("SELECT * FROM classes WHERE course = :course AND facultyid = :facultyid");
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':facultyid', $facultyid);
    $stmt->execute();
    
    if ($stmt->rowCount() != 0) {
        $_SESSION['msg'] = "Class already exists, please name with specific Section number.";
        
        header('Location: classesFaculty.php');
        exit();
    }
    
    $stmt = $dbh->prepare("INSERT INTO classes (facultyid, department, course, instructor, session) VALUES (:facultyid, :department, :course, :instructor, :session)");
    $stmt->bindParam(':facultyid', $facultyid);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':instructor', $instructor);
    $stmt->bindParam(':session', $session);

    $stmt->execute();
    
    // Class created, send back to class faculty page
    $_SESSION['msg'] = "New Class Created";
    header('Location: classesFaculty.php');
?>