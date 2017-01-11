<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<div class="container">
	<div class="row">
		<h1>Congratulations! User:
		<?php
			if(isset($_SESSION['username'])){
				echo $_SESSION['username'];
			}else{
				echo 'user';
			}
		?>
		 has been registered successfully.</h1>

		 <a href="<?php echo ROOTPATH;?>index.php?controller=snippet&action=index">Click here to continue...</a>
	</div>
</div>
