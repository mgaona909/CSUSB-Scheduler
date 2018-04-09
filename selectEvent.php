<?php
    // This file selects an event type
    
    session_start();
    
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
        exit();
    }
    
    
    $_SESSION['eventType'] = $_POST['select'];
    
    header('Location: events.php');
?>