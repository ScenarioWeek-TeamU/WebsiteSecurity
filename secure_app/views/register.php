<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<div class="children" style="padding-top: 20px;padding-right: 50px;padding-left: 50px">
	<div class="jumbotron" style="padding:50px">
	<center><h1>Create an account</h1></center>

		<br><br>

		<?php displayError(); ?>

		<form class="form-horizontal" method="post" action="<?php echo ROOTPATH; ?>index.php?controller=user&action=register" onsubmit="/*return genLoginHash(this)*/">
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
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="repeatpassword" class="control-label">Repeat Password</label>
						<input name="repeatpassword" type="password" class="form-control" id="repeatpassword" placeholder="Repeat Password">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="icon_url" class="control-label">Profile Icon URL</label>
						<input name="icon_url" type="text" class="form-control" id="icon_url" placeholder="Profile Icon URL">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="homepage_url" class="control-label">Homepage URL</label>
						<input name="homepage_url" type="text" class="form-control" id="homepage_url" placeholder="Homepage URL">
					</div>

					<br>

					<div class="form-group">
						<center>
							<button type="submit" class="btn btn-primary">Register</button>
						</center>
					</div>
				</div>
			</fieldset>
		</form>

	</div>
</div>
