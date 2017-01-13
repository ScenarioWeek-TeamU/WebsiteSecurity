<?php
if(!isset($_SESSION))
{
	session_start();
}

  $token = sha1(uniqid());
  $_SESSION['delete_snippet_token'] = $token;

if(!isset($user) || empty($user)){
  header('Location: index.php?controller=snippet&action=index');
}
?>

<div class="children" style="padding:20px;padding-top: 20px;padding-right: 50px;padding-left: 50px">
  <div class="jumbotron" style="padding:50px">
    <?php displayError(); ?>

    <div class="container">
      <div class="well">
        <center>
          <img src="<?php echo $user['icon_url'];?>" name="aboutme" width="140" height="140" class="img-circle">
          <h3>User: <strong><?php echo htmlspecialchars($user['username']);?></strong></h3>
          <h4><?php if(isAdmin()) echo 'Administrator';?></h4>
          <?php
          if(isAdmin()){
          echo'<a href="' . ROOTPATH . 'index.php?controller=user&action=edituserprofile&id=' . $user_id . '" class="btn btn-primary">Edit details</a>';
          }
          ?>
        </center>
        <br>

        <div class="row">

          <h3>Homepage</h3>

          <a href="<?php echo htmlspecialchars($user['homepage_url']); ?>"><div class="alert alert-dismissible alert-info">
            <?php echo htmlspecialchars($user['homepage_url']);?>
          </div></a>

          <h3>Snippets</h3>

          <?php
          if($snippets){
            foreach($snippets as $snippet){
              if(intval($snippet['is_private']) === 1){
                  $alert_col = "alert-warning";
              }else{
                  $alert_col = "alert-success";
              }
              echo'
              <div class="alert ' . $alert_col . '">';
              if(isLoggedIn() && (isAdmin() || strcmp($_SESSION['user_id'], $user['user_id']) === 0)){
                echo'<form method="post" action="' . ROOTPATH . 'index.php?controller=snippet&action=delete">
                <input type="hidden" name="token" value="' . $token . '">
                <input type="hidden" name="id" value="' . $snippet['id'] . '">
                <input type="hidden" name="redirect_id" value="' . $user_id . '">
                <button type="submit" onclick="return confirmDialog();" class="close" data-dismiss="alert">&times;</button></form>';
              }
              echo'
                <h4 class="alert-heading">"' . htmlspecialchars($snippet['content']) . '"</h4><strong>Posted on ' . $snippet['date'] . '</strong>
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
