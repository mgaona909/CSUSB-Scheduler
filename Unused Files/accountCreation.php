<?php
    //This checks to see if someone is already logged in,
    // If so, it redirects straight to their home page
    session_start();
    if (isset($_SESSION['googleID'])) {
        header('Location: home.php');
        exit();
    }
?>

<html>
<head>
    <title>CSUSB Student Scheduler</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="/css/login.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="mask-icon" href="images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

</head>

<body id="container">
    
    <div id="main">
        
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">CSUSB Scheduler</a>
                </div>
            </div>
        </nav>
        
        <!-- This is the account creation form.-->
        <div id="accountWindow">
            <form action="createNewAccount.php" method="post">
                
                <div class="container">
                    <label><b>First Name</b></label>
                    <input type="text" name="fname" placeholder="First Name" required>
                
                    <label><b>Last Name</b></label>
                    <input type="text" name="lname" placeholder="Last Name" required>
                    
                    <label><b>Email</b></label>
                    <input type="text" name="email" placeholder="Email" required>
                    
                    <label><b>New Username</b></label>
                    <input type="text" name="username" size="36" placeholder="New Username" required/>
                    
                    <label><b>Password</b></label>
                    <input type="password" name="password" size="36" placeholder="Password" required/>
                    
                    <label><b>Confirm Password</b></label>
                    <input type="password" name="conPassword" size="36" placeholder="Confirm Password" required/>
                
                    <button class="button" type="submit">Create</button>
                </div>
                
                <div class="container" style="background-color:#f1f1f1">
                    <p>Already registered? <a href="index.php">login here</a></p>
                    
                    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                        <h4 style="color:red" >Missing fields</h4>
        
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 2): ?>
                        <h4 style="color:red" >Passwords do not match</h4>
        
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 3): ?>
                        <h4 style="color:red" >Username already exists</h4>
        
                    <?php endif; ?>
    
                    <?php 
                        unset($_GET['error']);
                    ?>
                </div>
            </form>
            

        </div>
    </div>
    
</body>
</html>