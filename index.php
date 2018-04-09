<?php
    //This checks to see if someone is already logged in,
    // If so, it redirects straight to their home page
    session_start();
       
    if (isset($_SESSION['googleID'])) {
        header('Location: schedulePage.php');
        exit();
    }
    
?>
<html>    
<head>
    <title>CSUSB Student Scheduler</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--Google Sign-In-->
	<script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="/scripts/googleSignin.js"></script>
	
	<!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Bevan|Lato|Oswald" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- Custom CSS -->
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Custom JS-->
	<script src="/scripts/ajax.js"></script>
	
    <!--FAVICONS -->  
	<link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="mask-icon" href="images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
</head>
            
<body id="main">

    <!-- Navigation -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">CSUSB Scheduler</a>
            </div>
        </div>
    </nav>
        
    <!-- Header -->
    <div id="home">
        <div class="hero-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-text">
                            <div class="imgcontainer">
                                <img src="images/csusb_logo.png" alt="Logo" class="logo">
                            </div>
                            <h2>CSUSB Scheduler</h2>
                            <h3>Please Sign-In With Your Student Email</h3>
                            <hr class="hero-divider">
                            <div class="g-signin2 google" data-onSuccess="onSignIn" data-longtitle="true"></div>
                        </div><!-- hero-text -->
                    </div><!-- col-lg-12 -->
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- hero-image -->
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright text-muted small">Website By: CSUSB Schedulers. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
    
</body>
    <script type="text/javascript">
        appStart();
    </script>
</html>