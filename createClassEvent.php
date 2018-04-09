<?php
    // This file creates a new event
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    // Grabs the entered information
    $id = $_SESSION['googleID'];
    $classID = $_SESSION['classID'];
    $title = $_POST['title'];
    $eventType = $_POST['eventType'];
    $description = $_POST['description'];
    $color = $_POST['color'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    if (!$title || !$description) {
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
    
    $stmt = $dbh->prepare("INSERT INTO events (id, title, eventType, description, color, class, start, end) VALUES (:id, :title, :eventType, :description, :color, :class, :start, :end)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':eventType', $eventType);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':class', $classID);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);

    $stmt->execute();
    
    
    // Event created, send back to schedule page
    $_SESSION['msg'] = "New Class Event Created";
    header('Location: classesFaculty.php');
?>