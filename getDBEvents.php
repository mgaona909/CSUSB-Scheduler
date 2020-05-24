<?php

    require 'dbcredentials.php';

    session_start();
    
    // Checks to see if a user is logged in, if not redirect to index.php
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    $currentUser = $_SESSION['googleID'];
    $eventType = $_SESSION['eventType'];
    $callingPage = $_SERVER['HTTP_REFERER'];
    
    if(isset($_SESSION['classID'])) {
        $classID = $_SESSION['classID'];
    }
    
    function contains_substr($mainStr, $str, $loc = false) {
        if ($loc === false) return (strpos($mainStr, $str) !== false);
        if (strlen($mainStr) < strlen($str)) return false;
        if (($loc + strlen($str)) > strlen($mainStr)) return false;
        return (strcmp(substr($mainStr, $loc, strlen($str)), $str) == 0);
    }
    
    $dbh = connectDB();
    
    if (contains_substr($callingPage, "schedulePage.php")){
        $stmt = $dbh->prepare("SELECT eventID, id, title, eventType, description, color, date_format(start, '%Y-%m-%dT%H:%i:%s') as start, date_format(end, '%Y-%m-%dT%H:%i:%s') as end FROM events WHERE id = :currentUser AND class IS NULL");
        $stmt->bindParam(':currentUser', $currentUser);
    } else if(contains_substr($callingPage, "events.php")) {
        $stmt = $dbh->prepare("SELECT eventID, id, title, eventType, description, color, date_format(start, '%Y-%m-%dT%H:%i:%s') as start, date_format(end, '%Y-%m-%dT%H:%i:%s') as end FROM events WHERE id = :currentUser AND eventType = :eventType AND class IS NULL");
        $stmt->bindParam(':currentUser', $currentUser);
        $stmt->bindParam(':eventType', $eventType);
    } else if(contains_substr($callingPage, "classesFaculty.php") || contains_substr($callingPage, "classesStudent.php")){
        $stmt = $dbh->prepare("SELECT eventID, title, eventType, description, color, date_format(start, '%Y-%m-%dT%H:%i:%s') as start, date_format(end, '%Y-%m-%dT%H:%i:%s') as end FROM events WHERE class = :classID");
        $stmt->bindParam(':classID', $classID);
    }
    
    $stmt->execute();

    $events = array();
    
    for ($i=0; $i<$stmt->rowCount(); $i++){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(contains_substr($row['start'], "T00:00:00")){
            $row['allDay'] = true;
        }
        array_push($events, $row);
    }
    
    $response = $events;
    
    print json_encode($response);
    
?>