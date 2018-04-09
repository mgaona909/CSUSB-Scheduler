<?php
    // This file creates a new event
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    $callingPage = $_SERVER['HTTP_REFERER'];
    
    function contains_substr($mainStr, $str, $loc = false) {
        if ($loc === false) return (strpos($mainStr, $str) !== false);
        if (strlen($mainStr) < strlen($str)) return false;
        if (($loc + strlen($str)) > strlen($mainStr)) return false;
        return (strcmp(substr($mainStr, $loc, strlen($str)), $str) == 0);
    }
    
    // Grabs the entered information
    $id = $_SESSION['googleID'];
    $classID = NULL;
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
    
    
    $_SESSION['msg'] = "Event Added";
    
    if (contains_substr($callingPage, "classesFaculty.php")){
        header('Location: classesFaculty.php');
    } else if(contains_substr($callingPage, "classesStudent.php")) {
        header('Location: classesStudent.php');
    }
    
?>