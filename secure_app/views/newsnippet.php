<?php
if(!isset($_SESSION))
{
	session_start();
}
?>

<div class="children" style="padding:20px;padding-top: 20px;padding-right: 50px;padding-left: 50px">
  <div class="jumbotron" style="padding:50px">
    <?php displayError(); ?>

    <div class="container">
      <div class="well">
        <center>
          <h1>New Snippet</h1>
        </center>
        <br>
        <?php
        if(canPostSnippet()){
          echo'
        <div class="row">
          <div class="col-md-6">
            <form method="post" action="' . ROOTPATH . 'index.php?controller=snippet&action=create">
              <h3>Post a <strong>public</strong> snippet</h3>
              <input name="is_private" type="hidden" value="0"/>
              <textarea name="content" rows="6" cols="65"></textarea><br>
              <button type="submit" class="btn btn-success">Post Snippet</button>
            </form>
          </div>

          <div class="col-md-6">
            <form method="post" action="' . ROOTPATH . 'index.php?controller=snippet&action=create">
              <h3>Post a <strong>private</strong> Snippet</h3>
              <input name="is_private" type="hidden" value="1"/>
              <textarea name="content" rows="6" cols="65"></textarea><br>
              <button type="submit" class="btn btn-success">Post Snippet</button>
            </form>
          </div>
        </div>
          ';
        }
        ?>
      </div>
    </div>
  </div>
</div>
