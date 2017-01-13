<?php
if(!isset($_SESSION))
{
	session_start();
}
?>

<div class="children" style="padding:20px;padding-top: 20px;padding-right: 50px;padding-left: 50px">
  <div class="jumbotron" style="padding:50px">
    <div style="color: red;" id="error_message">
      <center>
      <?php
      if(isset($_GET['err'])){
        echo '<p class="error">' . $_GET['err'] . '</p>';
      }
      ?>
      </center>
    </div>

    <div class="container">
      <div class="well">
        <center>
          <img src="<?php echo $user['icon_url'];?>" name="aboutme" width="140" height="140" class="img-circle">
          <h3>User: <strong><?php echo $user['username'];?></strong></h3>
          <h4><?php if(isAdmin()) echo 'Administrator';?></h4>
          <a href="<?php echo ROOTPATH;?>index.php?controller=user&action=editmyprofile" class="btn btn-primary">Edit my details</a>
        </center>
        <br>

        <div class="row">

          <h3>Homepage</h3>

          <a href="<?php echo $user['homepage_url']; ?>"><div class="alert alert-dismissible alert-info">
            <?php echo $user['homepage_url'];?>
          </div></a>

          <h3>My Snippets</h3>

          <?php
          if($snippets){
            foreach($snippets as $snippet){
              if(intval($snippet['is_private']) === 1){
                  $alert_col = "alert-warning";
              }else{
                  $alert_col = "alert-success";
              }
              echo'
              <div class="alert ' . $alert_col . '">
                <a href="' . ROOTPATH . 'index.php?controller=snippet&action=delete&id=' . $snippet['id'] . '" onclick="return confirmDialog();"><button type="button" class="close" data-dismiss="alert">&times;</button></a>
                <h4 class="alert-heading">"' . $snippet['content'] . '"</h4><strong>Posted on ' . $snippet['date'] . '</strong>
              </div>
              ';
            }
          }else{
            echo'
              <div class="alert alert-dismissible alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                No snippets to display
              </div>
              ';
          }
          ?>

        </div>

      </div>
    </div>
  </div>
</div>
