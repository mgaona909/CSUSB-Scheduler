/*global $, gapi, ajax, location, reportError, data, moment*/

var profile;
var id_token;
var client;
var auth2; // The Sign-In object.
var googleUser; // The current user.
var CLIENT_ID = "564010345649-44di9sthgr1qlil8kgl6o1q0ighceknj.apps.googleusercontent.com";
var APIKEY = 'AIzaSyDWJlUe3EO7M7pTGlxScsZ_WLoXObJ5d2k';
var DISCOVERY_DOCS = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';
var SCOPES = "https://www.googleapis.com/auth/calendar";
/**
 * Calls startAuth after Sign in V2 finishes setting up.
 */
var appStart = function() {
  gapi.load('auth2', initSigninV2);
  gapi.load('client:auth2', initClient);
};

/**
 * Initializes Signin v2 and sets up listeners.
 */
var initSigninV2 = function() {
  auth2 = gapi.auth2.init({
	  client_id: CLIENT_ID,
	  scope: profile
  });
};


function initClient(){
  gapi.client.init({
	clientId: CLIENT_ID,
	scope: profile
  }).then(function(){
	// Listen for sign-in state changes.
	auth2.isSignedIn.listen(signinChanged);
	signinChanged(auth2.isSignedIn.get());
	
  });
  
  // Sign in the user if they are currently signed in.
  if (auth2.isSignedIn.get() == true) {
	auth2.signIn();
  }

  // Start with the current live values.
  refreshValues();
}


/**
 * Listener method for sign-out live value.
 *
 * @param {boolean} val the updated signed out state.
 */
function signinChanged(isSignedIn){
  console.log('Sign-in status changed to ' + isSignedIn);
}

/**
 * Retrieves the current user and signed in states from the GoogleAuth
 * object.
 */
var refreshValues = function() {
  if (auth2){
	console.log('Refreshing values...');
	googleUser = auth2.currentUser.get();
  }
};


function onSignIn(googleUser) {
	// Useful data for your client-side scripts:
	profile = googleUser.getBasicProfile();
	
	// The ID token you need to pass to your backend:
	id_token = googleUser.getAuthResponse().id_token;
	
	ajax('googleAccounts.php', {id_token:id_token, fname:profile.getGivenName(), lname:profile.getFamilyName(), email:profile.getEmail(), image:profile.getImageUrl()}, function(response){
		if(response.result === 'error'){
			console.log("Something went wrong");
		}else if (response.result==='success'){
			location.reload()
		} else {
		   console.log('Response message has no result attribute');
		}
		
	});
}    


function signOut() {
  auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
	console.log('User signed out.');
  });
  
   ajax('logout.php', null, function(response){
	  location.reload()
  });
  
}

//Function for toggling visibility when item is clicked
function toggle(id) {
	var e = document.getElementById(id);
    if(e.style.visibility == "hidden") {
        e.style.visibility = "visible";
    } else {
        e.style.visibility = "hidden";
    }
}

// Load the API and make an API call.  Display the results on the screen.
function makeApiCall() {
	gapi.client.load('calendar', 'v3').then(function() {
		//Assemble the API request
		var request = gapi.client.calendar.events.list({
			'calendarId': 'primary'
		});
	
		//Execute the API request
		request.then(function(resp) {
			var eventsList = [];
			var successArgs;
			var successRes;
			
			if (resp.result.error) {
				reportError('Google Calendar API: ' + data.error.message, data.error.errors);
			}
			else if (resp.result.items) {
				$.each(resp.result.items, function(i, entry) {
					var url = entry.htmlLink;
					eventsList.push({
						id: entry.id,
						title: entry.summary,
						start: entry.start.dateTime || entry.start.date, // try timed. will fall back to all-day
						end: entry.end.dateTime || entry.end.date, // same
						url: url,
						location: entry.location,
						description: entry.description
					});
				});
				// call the success handler(s) and allow it to return a new events array
				successArgs = [ eventsList ].concat(Array.prototype.slice.call(arguments, 1)); // forward other jq args
				successRes = $.fullCalendar.applyAll(true, this, successArgs);
				if ($.isArray(successRes)) {
					return successRes;
				}
			}
			// Here create your calendar but the events options is -- fullcalendar.events: eventsList 
			// $('#calendar').fullCalendar({
			// 	header: {
			// 		left: 'prev,next today',
			// 		center: 'title',
			// 		right: 'month,agendaWeek,agendaDay',
			// 	},
			// 	displayEventTime: false,
			// 	selectable: true,
			// 	selectHelper: true,
			// 	select: function(start, end) {
				
			// 		$('#newEventModal #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
			// 		$('#newEventModal #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
			// 		$('#newEventModal').modal('show');
			// 	},
			// 	timeFormat: 'h:(mm)t',
			// 	eventSources: [
			// 		{
			// 			url: '/getEvent.php',
			// 			color: 'red',
			// 			textColor: 'white'
			// 		}
			// 	],
			// 	googleCalendarApiKey: APIKEY,
			// 	events: eventsList,
			// 	defaultView: 'agendaWeek',
			// 	theme: true,
			// 	editable: true, 
			// 	eventClick: function(event) {
			// 		//populate the modal with the event details
			// 		var eventDesc = moment(event.start).format('h:mm a')+" - "+moment(event.end).format('h:mm a')+"<br/>"+"<br/>"+event.description;
					
					
			//         $('#modalTitle').html(event.title);
			//         $('#modalBody').html(eventDesc);
			//         $('#eventUrl').attr('href', event.url);
			//         $('#fullCalModal').modal('show');
			        
			//         //clear the modal once closed
			//         $(document).on("hidden.bs.modal", function (e) {
			// 		    $(e.target).removeData("bs.modal").find("#modalBody","#modalTitle").empty();
			// 		});
					
			// 		//prevent redirect to google event page
			// 		return false;
			// 	},
			// 	dayClick: function(date) {
			//         $('#newEventModal').modal('show');
			// 	}
			// });
			
			return eventsList;
		});
	});
}