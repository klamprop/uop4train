<section id="login_layer_top" style="background: url('images/loginlayer_background.PNG') no-repeat center center;background-color: #aeaeae; color: #FFFFFF;">
	<div class="container">
			<div class="row" style ="">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
				<h2>&nbsp;</h2>
				<h2 style="color:#FFFFFF;">Welcome to FORGEBox installation at test facilities<br/><?php echo $InstallationSite;?></h2>
				<p style="color:#FFFFFF;">Use the fields on the right to login to FORGEBox and enjoy our interactive courses on top of FIRE testbeds!</p>
				<p style="color:#FFFFFF;"><?php echo $SiteNoteTeaser;?></p>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="row" >
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<h1 style="color:#FFFFFF;margin-top:0px">Sign In</h1>
					<p  style="color:#FFFFFF;">Use the following fields to sign in FORGEBox</p>
					<div class="status alert alert-success" style="display: none"></div>					
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<div class="form-group">							
							<input type="email" class="form-control" id="InputEmail1" placeholder="email when sign up" name="username">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="InputPassword1" placeholder="Your FORGEBox password" name="password">
						</div>
						
						<br />
						<button type="submit" class="btn btn-default">Sign In</button> or <a href="register.php" style="color: white";>Sign up for ForgeBox</a>
					</form>
					<br />	
					</div>
					</div>
					<div class="row" style="padding-bottom:20px;padding-left:15px;">
						<a href="forgot_my_pass.php" style="color:#FFFFFF; text-decoration: none;">Forgot my password!</a>
					</div>
					<div class="row" >
						 <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
                                                        <form action="https://www.forgebox.eu/fb/loginssaml.php" method="get">
							<input type="hidden" name="login" value="1">
                                                        <button type="submit" class="btn btn-info"><b>GRNet</b></button>
                                                        </form>
                                                  </div>

						<div id="gConnect" class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
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

						</div>

						<?php }  ?>  



					</div>
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
