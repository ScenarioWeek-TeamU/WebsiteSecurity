<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<div class="children" style="padding-top: 20px;padding-right: 50px;padding-left: 50px">
	<div class="jumbotron col-md-6 col-md-offset-3" style="padding:50px">
		<center><h1>Login</h1></center>

		<br><br>

		<div style="color: red;" id="error_message">
			<center>
			<?php
			if(isset($_GET['err'])){
				echo '<p class="error">' . $_GET['err'] . '</p>';
			}
			?>
			</center>
		</div>

		<form class="form-horizontal" method="post" action="<?php echo ROOTPATH; ?>index.php?controller=user&action=login" onsubmit="/*return genLoginHash(this)*/">
			<fieldset>
				<div class="col-md-12">
					<div class="form-group">
						<label for="username" class="control-label">Username</label>
						<input name="username" type="text" class="form-control" id="username" placeholder="Username">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="password" class="control-label">Password</label>
						<input name="password" type="password" class="form-control" id="password" placeholder="Password">
					</div>

					<br>

					<div class="form-group">
						<center>
							<button type="submit" class="btn btn-primary">Submit</button>
						</center>
					</div>
				</div>
			</fieldset>
		</form>

	</div>
</div>
