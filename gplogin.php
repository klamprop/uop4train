 <?php include "header.php"; ?>
<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ .'/vendor/google/apiclient/src');


//const CLIENT_ID = '1043757324243-7u09it9a1j72hs4q1p4rpr44m4lhbhgt.apps.googleusercontent.com';
//const APPLICATION_NAME = "FORGEBox test app";


?>


 
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->


<?php if(!isset($_SESSION["UROLE_ID"])) {
	$state = md5(rand());
	$_SESSION['GPSTATE'] = $state;
	
	//will print button only if not logged in
	?>  

		<div id="gConnect">
			<button class="g-signin"
				data-scope="email"


				data-clientId="<?php echo CLIENT_ID;?>"
				data-accesstype="offline"
				data-callback="onSignInCallback"
				data-theme="dark"
				data-cookiepolicy="single_host_origin">
			</button>
		  </div>
		  
<?php }  ?>  
  
  <div id="authOps" style="display:none">
    <h2>User is now signed in to the app using Google+</h2>
    <p>If the user chooses to disconnect, the app must delete all stored
    information retrieved from Google for the given user.</p>
    <button id="disconnect" >Disconnect your Google account from this app</button>

    <h2>User's profile information</h2>
    <p>This data is retrieved client-side by using the Google JavaScript API
    client library.</p>
    <div id="profile"></div>

    <h2>User's friends that are visible to this app</h2>
    <p>This data is retrieved from your server, where your server makes
    an authorized HTTP request on the user's behalf.</p>
    <p>If your app uses server-side rendering, this is the section you
    would change using your server-side templating system.</p>
    <div id="visiblePeople"></div>

    <h2>Authentication Logs</h2>
    <pre id="authResult"></pre>
  </div>



</div><!--  ------------------------  END CONTENT      ------------------------      -->


<script type="text/javascript">
  (function() {
    var po = document.createElement('script');
    po.type = 'text/javascript'; po.async = true;
    po.src = 'https://plus.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
  })();
  </script>


<script type="text/javascript">
var helper = (function() {
  var authResult = undefined;

  return {
    /**
     * Hides the sign-in button and connects the server-side app after
     * the user successfully signs in.
     *
     * @param {Object} authResult An Object which contains the access token and
     *   other authentication information.
     */
    onSignInCallback: function(authResult) {

      if (authResult['access_token']) {
        // The user is signed in
        this.authResult = authResult;
	//send the authresult to server
        helper.connectServer();
      } else if (authResult['error']) {
        // There was an error, which means the user is not signed in.
        // As an example, you can troubleshoot by writing to the console:
        console.log('There was an error: ' + authResult['error']);
        $('#authResult').append('Logged out');
        $('#authOps').hide('slow');
        $('#gConnect').show();
      }
      console.log('authResult', authResult);
    },

    /**
     * Calls the server endpoint to disconnect the app for the user.
     */
    disconnectServer: function() {
      // Revoke the server tokens
      $.ajax({
        type: 'GET',
        url: 'gpconnect.php?disconnect=1',
        async: false,
        success: function(result) {
          console.log('revoke response: ' + result);
          $('#authOps').hide();
          $('#profile').empty();
          $('#visiblePeople').empty();
          $('#authResult').empty();
          $('#gConnect').show();
        },
        error: function(e) {
          console.log(e);
        }
      });
    },
    /**
     * Calls the server endpoint to connect the app for the user. The client
     * sends the one-time authorization code to the server and the server
     * exchanges the code for its own tokens to use for offline API access.
     * For more information, see:
     *   https://developers.google.com/+/web/signin/server-side-flow
     */
    connectServer: function() {
	console.log("CONNECT SERVER ============================");
	console.log(this.authResult.code);
      $.ajax({
        type: 'POST',
        url: 'gpconnect.php?state=<?php echo $state; ?>',
        contentType: 'application/octet-stream; charset=utf-8',
        success: function(result) {
		$('#authResult').append(result);
          	console.log(result);
	
		$('#authOps').show('slow');
        	$('#gConnect').hide();

        },
        processData: false,
        data: this.authResult.code
      });
    }


  };
})();


/**
 * Perform jQuery initialization and check to ensure that you updated your
 * client ID.
 */
$(document).ready(function() {
  $('#disconnect').click(helper.disconnectServer);
  if ($('[data-clientid="YOUR_CLIENT_ID"]').length > 0) {
    alert('This sample requires your OAuth credentials (client ID) ' +
        'from the Google APIs console:\n' +
        '    https://code.google.com/apis/console/#:access\n\n' +
        'Find and replace YOUR_CLIENT_ID with your client ID and ' +
        'YOUR_CLIENT_SECRET with your client secret in the project sources.'
    );
  }
});


/**
 * Calls the helper method that handles the authentication flow.
 *
 * @param {Object} authResult An Object which contains the access token and
 *   other authentication information.
 */
function onSignInCallback(authResult) {
  helper.onSignInCallback(authResult);
}


 </script>



 <?php include "footer.php"; ?>

