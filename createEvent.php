<?php
    // This file creates a new event

    require 'dbcredentials.php';
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    // Grabs the entered information
    $id = $_SESSION['googleID'];
    $title = $_POST['title'];
    $eventType = $_POST['eventType'];
    $description = $_POST['description'];
    $color = $_POST['color'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    if (!$title || !$description) {
        header('Location: schedulePage.php?error=1');
        exit();
    }
    
    // Connects with database
    $dbh = connectDB();
    
    $stmt = $dbh->prepare("INSERT INTO events (id, title, eventType, description, color, start, end) VALUES (:id, :title, :eventType, :description, :color, :start, :end)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':eventType', $eventType);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);

    $stmt->execute();
    
    
    // Event created, send back to schedule page
    $_SESSION['msg'] = "New Event Created";
    header('Location: schedulePage.php');
?>