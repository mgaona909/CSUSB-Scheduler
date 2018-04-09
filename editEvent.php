<?php
    // Allows editing of existing events
    
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
    
    // Connects with database
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=b18_20197884_csusb", root, NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    if (isset($_POST['delete']) && isset($_POST['eventID'])){
    	
    	$eventID = $_POST['eventID'];

    	$stmt = $dbh->prepare("DELETE FROM events WHERE eventID = :eventID");
    	$stmt->bindParam(':eventID', $eventID);
    	$stmt->execute();
    	
    	$_SESSION['msg'] = "Event Deleted";
    	
    } elseif (isset($_POST['title']) || isset($_POST['eventType']) || isset($_POST['color']) || isset($_POST['description']) && isset($_POST['eventID'])){
    	
    	$eventID = $_POST['eventID'];
    	$title = $_POST['title'];
    	$eventType = $_POST['eventType'];
    	$color = $_POST['color'];
    	$description = $_POST['description'];

    	$stmt = $dbh->prepare("UPDATE events SET title = :title , eventType = :eventType , color = :color , description = :description WHERE eventID = :eventID");
    	$stmt->bindParam(':title', $title);
    	$stmt->bindParam(':eventType', $eventType);
    	$stmt->bindParam(':color', $color);
    	$stmt->bindParam(':description', $description);
    	$stmt->bindParam(':eventID', $eventID);
    	$stmt->execute();
    	
    	$_SESSION['msg'] = "Event Edited";
    }
    
    if (contains_substr($callingPage, "schedulePage.php")){
        header('Location: schedulePage.php');
    } else if(contains_substr($callingPage, "classesFaculty.php")) {
        header('Location: classesFaculty.php');
    } else if(contains_substr($callingPage, "events.php")) {
        header('Location: events.php');
    }
    
?>