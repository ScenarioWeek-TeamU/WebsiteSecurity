<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<div class="container">
	<div class="row">
		<?php
			if(isset($_GET['err'])){
				echo '<h3 class="error">' . $_GET['err'] . '</h3>';
			}else{
				echo '<h3 class="error">An error has occured! Invalid access.</h3>';
			}
		?>
	</div>
</div>
