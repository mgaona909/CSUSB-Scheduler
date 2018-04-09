<?php
    // This file selects a new class
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    $classID = $_POST['select'];
    
    // Connects with database
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=b18_20197884_csusb", root, NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    $stmt = $dbh->prepare("SELECT * FROM classes WHERE classID = :classID");
    $stmt->bindParam(':classID', $classID);
    $stmt->execute();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $department = $row['department'];
        $course = $row['course'];
    }
    
    $_SESSION['class'] = $department . ' ' . $course;
    $_SESSION['classID'] = $classID;
    
    // Class selected, send back to class page
    if($_SESSION['account'] == "Faculty") {
        header('Location: classesFaculty.php');
    }
    else {
        header('Location: classesStudent.php');
    }
?>