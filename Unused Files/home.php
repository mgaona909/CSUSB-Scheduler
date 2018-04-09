<?php
    session_start();
    // Checks to see if a user is logged in, if not redirect to index.php
    if (!isset($_SESSION['googleID'])) {
        header('Location: index.php');
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
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">CSUSB Scheduler</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="homework.php">Homework</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="schedulePage.php">Schedule</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="profilePage.php">
                            <span class="glyphicon glyphicon-user"></span>
                                Welcome, 
                                <?php $name = $_SESSION['fname'];
                                    echo $name; ?>
                            </a>
                    </li>
                    <li><a href='#' onclick="signOut();"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
        <h2>Home Page</h2>
    <div class="container"></div>
    
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="homework.php">Homework</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="projects.php">Projects</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="schedulePage.php">Schedule</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Website By: Scott Raymond, Using Bootstrap. All Rights Reserved</p>
                </div><!-- col-lg-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </footer>
                
</body>
    <script type="text/javascript">
        appStart();
    </script>
</html>