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
				$err = htmlspecialchars($_GET['err']);
				echo '<h1 class="error" style="color: red;">' . $err . '</h1>';
			}else{
				echo '<h1 class="error" style="color: red;">An error has occured! Invalid access.</h1>';
			}
		?>
	</div>
</div>
