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
      <form method="post" action="<?php echo ROOTPATH;?>index.php?controller=user&action=update">
        <center><h1> Edit your details</h1></center><br><br>

          <h3>Username</h3>
          <div class="row">
            <div class="col-md-12"><input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $user['username'];?>"><br></div>
          </div>

          <h3>Password</h3>
          <div class="row">
            <div class="col-md-12"> <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $user['password'];?>"><br></div>
          </div>

          <h3>Profile Icon URL</h3>
          <div class="row">
            <div class="col-md-12"> <input type="text" class="form-control" name="icon_url" placeholder="Profile Icon URL" value="<?php echo $user['icon_url'];?>"><br></div>
          </div>

          <h3>Homepage URL</h3>
          <div class="row">
            <div class="col-md-12"><input type="text" class="form-control" name="homepage_url" placeholder="Homepage URL" value="<?php echo $user['homepage_url'];?>"><br></div>
          </div>

          <div class="row">
            <button type="submit" class="btn btn-primary col-md-5">Update Profile</button>
            <a href="<?php echo ROOTPATH;?>index.php?controller=user&action=profile" class="btn btn-default col-md-5" style="float:right;">Cancel</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
