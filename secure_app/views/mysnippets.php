<?php
if(!isset($_SESSION))
{
	session_start();
}
?>

<div class="children" style="padding:20px;padding-top: 20px;padding-right: 50px;padding-left: 50px">
  <div class="jumbotron" style="padding:50px">
    <div class="container">
      <div class="well">
        <div class="row">
          <center><h1>My Snippets</h1></center><br>

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
