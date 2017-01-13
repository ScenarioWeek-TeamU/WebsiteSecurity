-<?php
if(!isset($_SESSION))
{
	session_start();
}
?>

<?php
if(!isLoggedIn()){
echo '<div class="children" style=";padding-right: 50px;padding-left: 50px">
  <div class="jumbotron">

      <center><h2> You are not currently logged in </h2></center>
      <center><h4> Please either login or register </h4></center><br>
      <center>
          <a href="index.php?controller=pages&action=login" class="btn btn-success btn-lg">Log In</a>
          <a href="index.php?controller=pages&action=register" class="btn btn-warning btn-lg">Register</a>
     </center>

 </div>
</div>';
}
?>

<div class="children" style="padding-right: 50px;padding-left: 50px">
  <div class="jumbotron" style="padding:50px">

      <center><h1> Most recent snippets </h1></center>
      <center><h3> See what others have been up to</h3></center><br>
  </div>

      <div style="padding-left: 150px;padding-right: 150px">

      <?php
      if(empty($posts)){
        echo'<div class="panel panel-info">
          <div class="panel-heading">
              <h3 class="panel-title">No users to display</h3>
          </div>
          <div class="panel-body">No snippets to display.</div>';
      }else{
        foreach($posts as $post){
          if(intval($post['recent_snippet_id']) === 0){
            continue;
          }
          echo'
          <div class="panel panel-info">
            <div class="panel-heading">
                <a href="' . ROOTPATH . 'index.php?controller=user&action=publicprofile&id=' . $post['user_id'] . '"><h3 class="panel-title">' . $post['username'] . '</h3></a>
            </div>
            <div class="panel-body">
              "' . $post['content'] . '" <strong>' . $post['date'] . '</strong>
              <br><br><a class="btn btn-warning" href="' . ROOTPATH . 'index.php?controller=user&action=publicprofile&id=' . $post['user_id'] . '">Profile</a> <a class="btn btn-success" href="' . $post['homepage_url'] . '" target="_blank">Homepage</a>
            </div>
          </div>
          ';
        }
      }
      ?>
  </div>
</div>
