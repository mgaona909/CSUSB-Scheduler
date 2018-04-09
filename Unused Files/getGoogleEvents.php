<?php
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    $currentUser = $_SESSION['googleID'];
    
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=csusb", root, NULL);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    $stmt = $dbh->prepare("SELECT id, title, eventType, description, color, start, end FROM events WHERE id = :currentUser");
    $stmt->bindParam(':currentUser', $currentUser);
    $stmt->execute();
    
    $eventList = array();
    
    for($i=1; $i<=($stmt->rowCount()); $i++){
        $result = $stmt->fetch();
        array_push($eventList, $result);
    }

    $response = array($eventList);
    
    print json_encode($response)
?>