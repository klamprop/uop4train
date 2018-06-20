<section id="login_layer_top" style="background-color: #FFFFFF;">
	<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 pull-right">
					     	<ul class="navbar-nav pull-right header-menu" style="list-style-type: none;">

									 <li class="pull-right" style="padding-left:10px;"> <a href="register.php" style="color: #555555";>Register</a></li>

					         <li id="fat-menu" class="dropdown pull-right">
					          <a href="#" class="dropdown-toggle singnincolors" data-toggle="dropdown" style="background-color:#ffffff;">
					             Sign In</b>
					          </a>
					          <ul class="dropdown-menu center pull-right list-unstyled" style="min-width:300px; padding:10px; list-style-type: none;">
											<li>
											<h1 style="color:#555555; margin-top:0px">Sign In</h1>
											<div class="status alert alert-success" style="display: none"></div>
											<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
												<div class="form-group">
													<input type="email" class="form-control" id="InputEmail1" placeholder="email when sign up" name="username">
												</div>
												<div class="form-group">
													<input type="password" class="form-control" id="InputPassword1" placeholder="Your FORGEBox password" name="password">
												</div>
												<button type="submit" class="btn btn-default">Sign In</button>
												<br><a href="forgot_my_pass.php" style="font-size: 12px; color:#555555; text-decoration: none;">Forgot my password :(</a>
											</form>
										</li>
										<br/>
										  <li class="divider"></li>
											<li>
											 <form action="https://www.forgebox.eu/fb/loginssaml.php" method="get">
												<input type="hidden" name="login" value="1">
													<button type="submit" class="btn btn-info"><b>GRNet</b></button>
												</form>


												<div id="gConnect" class="col-xs-6 col-sm-3 col-md-3 col-lg-3" >
												<?php if(!isset($_SESSION["UROLE_ID"]) || $_SESSION["UROLE_ID"]==7) {
												$state = md5(rand());
												$_SESSION['GPSTATE'] = $state;
												//will print GOOGLE button only if not logged in
												?>

												<button class="g-signin"
												data-scope="email"
												data-clientId="<?php echo CLIENT_ID;?>"
												data-accesstype="offline"
												data-callback="onSignInCallback"
												data-theme="dark"
												data-cookiepolicy="single_host_origin">
												</button>
												<?php }  ?>

												</div>
											</li>
					          </ul>
					         </li>


								</ul>
							</div>
						</div>

			</div>

<br>
</section>

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
      }
      console.log('authResult', authResult);
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
		window.location.replace('index.php');
        },
        processData: false,
        data: this.authResult.code
      });
    }


  };
})();



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
