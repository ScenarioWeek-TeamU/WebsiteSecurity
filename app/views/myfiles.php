<?php
if(!isset($_SESSION))
{
  session_start();
}
?>

<div class="children" style="padding:120px;padding-top:0px;">
  <div class="jumbotron" style="padding:50px">
    <center><h1>Your Files</h1></center>
    <br>
    <div style="color: red;" id="error_message">
      <center>
      <?php
      if(isset($_GET['err'])){
        echo '<p class="error">' . $_GET['err'] . '</p>';
      }
      ?>
      </center>
    </div>

    <center>
      <form id="form" action="<?php echo ROOTPATH;?>index.php?controller=file&action=upload" method="POST" enctype="multipart/form-data">
        <label class="btn btn-success btn-file">
        Upload File <input type="file" name="upload" class="hidden" onchange="$('#form').submit();">
        </label>
      </form>

      <br><br><br>

      <table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th class="col-md-2">Date uploaded</th>
            <th class="col-md-8">File URL</th>
            <th class="col-md-2"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if(isset($files) && !empty($files)){
            foreach($files as $file){
              echo'
                <tr>
                  <td>' . $file['date'] . '</td>
                  <td><a href="' . $file['file_url'] . '">' . $file['file_url'] . '</a></td>
                  <td><a href="' . ROOTPATH . 'index.php?controller=file&action=delete&id=' . $file['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
              ';
            }
          }else{
            echo'
              <tr>
                <td>No files to display</td>
                <td></td>
                <td></td>
              </tr>
            ';
          }
          ?>
        </tbody>
      </table>
    </center>


  </div>
</div>
