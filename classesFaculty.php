<?php
	session_start();
	
	// Checks to see if a user is logged in, if not redirect to index.php
	if (!isset($_SESSION['googleID'])) {
		header('Location: index.php');
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
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
		
	<!-- Custom JS-->
	<script src="/scripts/ajax.js"></script>
		
	<!--FAVICONS -->  
	<link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="mask-icon" href="images/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">
	
	<!--FULLCALENDAR-->
	<link rel='stylesheet' href='/fullcalendar-3.4.0/lib/cupertino/jquery-ui.min.css' />
	<link href='/fullcalendar-3.4.0/fullcalendar.min.css' type='text/css' rel='stylesheet' />
	<link href='/fullcalendar-3.4.0/fullcalendar.print.min.css' type='text/css' rel='stylesheet' media='print' />
	<script src='/fullcalendar-3.4.0/lib/moment.min.js'></script>
	<script src='/fullcalendar-3.4.0/fullcalendar.min.js'></script>
		
	<!-- Custom CSS -->
	<link href="css/normalize.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body id="main">

	<!-- Nav Bar -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="schedulePage.php">CSUSB Scheduler</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a href="schedulePage.php">Schedule</a></li>
					<li><a href="events.php">Events</a></li>
					<?php if ($_SESSION['account'] == "Faculty"): ?>
					    <li class="active"><a href="classesFaculty.php">Classes</a></li>
					<?php else: ?>
					    <li><a href="classesStudent.php">Classes</a></li>
					<?php endif; ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="profilePage.php">
							<span class="glyphicon glyphicon-user"></span>
							Welcome, <?php $name = $_SESSION['fname']; echo $name; ?>
						</a>
					</li>
					<li><a href='#' onclick="signOut();"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
		
	<!-- Main Content Body -->
    <div class='container'>
    	
		<div class='col-md-4' id='instructions'>
	        <button type="button" class="btn btn-info" onclick="openNav()"><span class="glyphicon glyphicon-menu-hamburger"></span> Faculty Options</button>
 			<button data-parent="#accordion" class="btn btn-primary visible-xs" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
				<span class="glyphicon glyphicon-option-vertical"></span>Instructions
			</button>
		        
	        <?php if (isset($_SESSION['class'])): ?>
	        
	        	<h1>Calendar for: <?php echo $_SESSION['class'] ?> </h1>
	        	
	        <?php else : ?>
	        	
	        	<h1>No Class Selected</h1>
	        
	        <?php endif; ?>
	        
	        <div class="container marketing">
				<div class="row">
	                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		                <div class="panel">
							<div id="collapse1" class="div-collapse collapse col-md-4">
								<h2>The Faculty Class Page</h2>
								<p>This is where faculty members can create class pages, and events for those classes.</p>
								<br/>
								<h4>To create, select, or delete a class:</h4>
								<ul>
									<li>Create New Class
										<ul>
											<li>On sidebar, select Create New Class</li>
											<li>Select Department, type in a course number and section number, and session</li>
											<li>Click create to confirm the new class</li>
										</ul>
									</li>
									<li>Select Class
										<ul>
											<li>On sidebar, look under My Classes</li>
											<li>If no classes are available, create a new class</li>
											<li>Click the class you wish to view to enter that class page</li>
										</ul>
									</li>
									<li>Remove Class
										<ul>
											<li>On sidebar, look under Class Options</li>
											<li>If no class is selected, select the class to be deleted</li>
											<li>Click Delete Class to remove the selected class</li>
											<li>Deleting a class will delete the class, and all events on the class page</li>
										</ul>
									</li>
								</ul>
								<h4>All class event creating and editing is identical to the Schedule page</h4>
								<h5>See Schedule page for more assistance</h5>
							</div>
						</div>
	                </div>
	            </div>
			</div>
		</div>
		<div id='faculty' class='container col-md-8'></div>
	        
		<?php
			if (isset($_SESSION['msg'])) {
				$msg = $_SESSION['msg'];
				unset($_SESSION['msg']);
				echo '<script type="text/javascript">alert("'.$msg.'");</script>';
			}
		?>
		

	</div>
	
	<!-- Create Class Modal -->
	<div class="modal fade" id="createClassModal" tabindex="-1" role="dialog" aria-labelledby="createCLassModal" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
	                </button>
	                 <h4 class="modal-title" id="myModalLabel">Create Class</h4>
	            </div>
	            <div class="modal-body">
    				<form class="form-horizontal" method="post" action="createClass.php">
	    				<div class="modal-body">
	    					<div class="form-group">
	    						<label for="department" class="col-sm-3 control-label">Department</label>
	    						<div class="col-sm-6">
	    							<select name="department" class="form-control" id="department">
	    								<option>ART</option>
	    								<option>ENG</option>
	    								<option>CSE</option>
	    								<option>MATH</option>
	    								<option>MUS</option>
	    								<option>TA</option>
	    							</select>
	    						</div>
	    					</div>
	    					<div class="form-group">
	    						<label for="course" class="col-sm-3 control-label">Course-Section</label>
	    						<div class="col-sm-6">
	    							<input type="text" name="course" class="form-control" id="course" placeholder="Example: 300-01" required>
	    						</div>
	    					</div>
	    					<div class="form-group">
	    						<label for="instructor" class="col-sm-2 control-label">Instructor</label>
	    						<div class="col-sm-10">
	    							<input type="text" name="instructor" class="form-control" id="instructor" value="<?php $name = $_SESSION['fname'] . ' ' . $_SESSION['lname']; echo $name; ?>" readonly>
	    						</div>
	    					</div>
	    					<div class="form-group">
	    						<label for="session" class="col-sm-2 control-label">Session</label>
	        					<div class="col-sm-10">
	        						<select name="session" class="form-control" id="session">
	        							<option>Spring 2017</option>
	        							<option>Summer 2017</option>
	        							<option>Fall 2017</option>
	        						</select>
	        					</div>
	    					</div>
	    				</div>
	    				<div class="modal-footer">
	    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    					<button type="submit" class="btn btn-success">Create</button>
	    				</div>
	    			</form>
	        	</div>
			</div>
		</div>
	</div>
			
	<!--New Class Event Form Modal-->
	<div class="modal fade" id="ModalNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action="createClassEvent.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Class Event for <?php echo $_SESSION['class'] ?></h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
							</div>
						</div>
						<div class="form-group">
							<label for="eventType" class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
								<select name="eventType" class="form-control" id="eventType">
									<option>Homework</option>
									<option>Project</option>
									<option>Exam</option>
									<option>Quiz</option>
									<option>Reminder</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<textarea type="textarea" name="description" class="form-control" id="description" placeholder="Description" rows="3" required></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="color" class="col-sm-2 control-label">Color</label>
							<div class="col-sm-10">
								<select name="color" class="form-control" id="color">
									<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
									<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
									<option style="color:#008000;" value="#008000">&#9724; Green</option>						  
									<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
									<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
									<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
									<option style="color:#000;" value="#000">&#9724; Black</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="start" class="col-sm-2 control-label">Start date</label>
							<div class="col-sm-10">
								<input type="text" name="start" class="form-control" id="start" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="end" class="col-sm-2 control-label">End date</label>
							<div class="col-sm-10">
								<input type="text" name="end" class="form-control" id="end" readonly>
							</div>
						</div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Create</button>
					</div>
				</form>
			</div>
		</div>
    </div>
    
    <!-- Edit Class Event Form Modal -->
	<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div role="tabpanel">
	                    <!-- Nav tabs -->
	                    <ul class="nav nav-tabs" role="tablist">
	                    	<li role="presentation" class="active"><a href="#viewTab" aria-controls="viewTab" role="tab" data-toggle="tab">View</a>
	
	                        </li>
	                        <li role="presentation"><a href="#editTab" aria-controls="editTab" role="tab" data-toggle="tab">Edit</a>
	
	                        </li>
	                    </ul>
	                    <!-- Tab panes -->
			            <div class="tab-content">
			            	<div role="tabpanel" class="tab-pane active" id="viewTab">
								<form class="form-horizontal" method="POST" action="addClassEvent.php">
									<br>
									<div class="form-group">
										<label for="title" class="col-sm-2 control-label">Title</label>
										<div class="col-sm-10">
											<input type="text" name="title" class="form-control" id="title" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="eventType" class="col-sm-2 control-label">Type</label>
										<div class="col-sm-10">
											<input type="text" name="eventType" class="form-control" id="eventType" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="description" class="col-sm-2 control-label">Description</label>
										<div class="col-sm-10">
											<textarea type="textarea" name="description" class="form-control" id="description" rows="3" readonly></textarea>
										</div>
									</div>
										<input type="hidden" name="color" class="form-control" id="color">
										<input type="hidden" name="start" class="form-control" id="start">
										<input type="hidden" name="end" class="form-control" id="end">
										
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Add Event to My Schedule</button>
									</div>
								</form>
			                </div>
			            	
			                <div role="tabpanel" class="tab-pane" id="editTab">
								<form class="form-horizontal" method="POST" action="editEvent.php">
									<br>
									<div class="form-group">
										<label for="title" class="col-sm-2 control-label">Title</label>
										<div class="col-sm-10">
											<input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
										</div>
									</div>
									<div class="form-group">
										<label for="eventType" class="col-sm-2 control-label">Type</label>
										<div class="col-sm-10">
											<select name="eventType" class="form-control" id="eventType">
												<option>Homework</option>
												<option>Project</option>
												<option>Exam</option>
												<option>Quiz</option>
												<option>Reminder</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="description" class="col-sm-2 control-label">Description</label>
										<div class="col-sm-10">
											<textarea type="textarea" name="description" class="form-control" id="description" placeholder="Description" rows="3" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="color" class="col-sm-2 control-label">Color</label>
										<div class="col-sm-10">
											<select name="color" class="form-control" id="color">
												<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
												<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
												<option style="color:#008000;" value="#008000">&#9724; Green</option>						  
												<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
												<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
												<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
												<option style="color:#000;" value="#000">&#9724; Black</option>
											</select>
										</div>
									</div>
									<div class="form-group"> 
										<div class="col-sm-offset-2 col-sm-10">
											<div class="checkbox">
												<label class="text-danger"><input type="checkbox" name="delete" id="delete"> Delete event</label>
											</div>
										</div>
									</div>
										<input type="hidden" name="eventID" class="form-control" id="eventID">
										
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Save changes</button>
									</div>
								</form>
							</div>
						</div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
    
    <!--SideBar-->
	<div id="options" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<h3>My Classes</h3>
		<form class="form-horizontal" method="POST" action="selectClass.php">
			<?php
				try {
					$dbh = new PDO("mysql:host=localhost;dbname=b18_20197884_csusb", root, NULL);
				} catch (PDOException $e) {
					exit($e->getMessage());
				}
				
				$currentUser = $_SESSION['googleID'];
				
				$stmt = $dbh->prepare("SELECT * FROM classes WHERE facultyid = :currentUser ORDER BY department, course" );
				$stmt->bindParam(':currentUser', $currentUser);
				$stmt->execute();
				
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$classID = $row['classID'];
				    $department = $row['department'];
				    $course = $row['course'];
				    $session = $row['session'];
			?>
				<label class="list"><input type="submit" style="display:none" name="select" value="<?php echo $row['classID'] ?>"><?php echo " $department $course $session" ?></label>
			<?php } ?>
		</form>
		<hr>
		<h3>Class Options</h3>
		<a href="#" data-toggle="modal" data-target="#createClassModal" class="list">Create New Class</a>
		<?php if (isset($_SESSION['classID']) || isset($_SESSION['class'])): ?>
			<form class="form-horizontal" method="POST" action="deleteClass.php">
					<label class="list"><input onclick="return confirm('Are you sure you want to delete this class? This will also delete all events for this class.')"; type="submit" style="display:none" name="delete" value="<?php echo $_SESSION['classID'] ?>">Delete Class: <?php echo $_SESSION['class'] ?></label>
			</form>
		
		<?php endif; ?>
	</div>
	
	<!-- Footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="list-inline">
						<li><a href="schedulePage.php">Schedule</a></li>
						<li class="footer-menu-divider">&sdot;</li>
						<li><a href="events.php">Events</a></li>
						<li class="footer-menu-divider">&sdot;</li>
						<?php if ($_SESSION['account'] == "Faculty"): ?>
					    	<li><a href="classesFaculty.php">Classes</a></li>
						<?php else: ?>
						    <li><a href="classesStudent.php">Classes</a></li>
						<?php endif; ?>
						<li class="footer-menu-divider">&sdot;</li>
						<li><a href="profilePage.php">Profile</a></li>
						<li class="footer-menu-divider">&sdot;</li>
						<li><a href="about.php">About</a></li>
					</ul>
					<p class="copyright text-muted small">Website By: CSUSB Schedulers. All Rights Reserved</p>
				</div><!-- col-lg-12 -->
			</div><!-- row -->
		</div><!-- container -->
	</footer>
	
	<script>
		function openNav() {
		    document.getElementById("options").style.width = "200px";
		}
		
		function closeNav() {
		    document.getElementById("options").style.width = "0";
		}
	</script>
			
</body>
			
	<script type="text/javascript">
		appStart();
			
		$(document).ready(function() {
			$('#faculty').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				theme: true,
				height: $(window).height()*0.75,
				handleWindowResize: false,
				eventLimit: true,
				selectable: true,
				selectHelper: true,
				defaultView: 'month',
				select: function(start, end) {
					$('#ModalNew #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
					$('#ModalNew #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
					$('#ModalNew').modal('show');
				},
				eventRender: function(event, element) {
					element.bind('dblclick', function() {
						$('#ModalEdit #eventID').val(event.eventID);
						$('#ModalEdit #id').val(event.id);
						$('#ModalEdit #title').val(event.title);
						$('#ModalEdit #eventType').val(event.eventType);
						$('#ModalEdit #description').val(event.description);
						$('#ModalEdit #color').val(event.color);
						$('#ModalEdit #start').val(event.start.format('YYYY-MM-DD HH:mm:ss'));
						$('#ModalEdit #end').val(event.end.format('YYYY-MM-DD HH:mm:ss'));
						$('#ModalEdit').modal('show');
					});
				},
				events: 'getDBEvents.php'
			});
		});

	</script>
	
</html>