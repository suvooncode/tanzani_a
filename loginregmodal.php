<div class="modal fade login-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalCenterTitle">Login</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		<form action='index.php' method='POST'>
		  <div class="form-group">
			<label>Email : </label>
			<input type="email" class="form-control" name="email" required>
		  </div>
		  <div class="form-group">
			<label>Password : </label>
			<input type="password" class="form-control" name="password" required>
		  </div>
		  <button type="submit" class="btn btn-success" name='login'>Login</button>

		  <a href="" style='float:right' data-toggle="modal" data-target="#exampleModalCenter3" onclick='login_modal_hide()'>Forgot Password?</a>
		</form>
		</div>

		<!-- <div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div> -->

		
	  </div>
	</div>
  </div>
		<!-- End::Footer area -->
<div class="modal fade" id="exampleModalsingup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalCenterTitle">Registration</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		<form action='index.php' method='POST'>
		<div class="form-group">
			<label>Full Name : </label>
			<input type="Text" class="form-control" name="fullname" required>
		  </div>
		  <div class="form-group">
			<label>Email : </label>
			<input type="email" class="form-control" name="email" required>
		  </div>
		  <div class="form-group">
			<label>Mobile No : </label>
			<input type="number" class="form-control" name="number" required>
		  </div>
		  <div class="form-group">
			<label>Password : </label>
			<input type="password" class="form-control" name="password" required>
		  </div>
		  <button type="submit" class="btn btn-success" name='submitreg'>Register</button>

		</form>
		</div>

		

		
	  </div>
	</div>
  </div>


  <div class="modal fade common-modal" id="exampleModalCenter3" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalCenterTitle">Forgot Password</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal()">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		<form action='' method='POST'>
		  <div class="form-group">
			<label>Email : </label>
			<input type="email" class="form-control" id="forgot_email" name="forgot_email" required>
		  </div>
		  
		  <button type="button" class="btn btn-success" id="change_password" name='forgot_submit'>Submit</button>

		 
		</form>
		</div>

		<!-- <div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div> -->

		
	  </div>
	</div>
  </div>