<?php session_start();
if(isset($_SESSION['user_name'])  ){
  header('Location: index.php');
}
include "include/db.php";
$error = "";

if(isset($_POST['submit'])) {

  if($_POST['email'] !="" && $_POST['name'] !="" && $_POST['pass'] !=""&& $_POST['cpass'] !="") {
    if($_POST['pass'] == $_POST['cpass'] ){
      $ins_sql = "INSERT into users ( `user_name`, `user_email`, `user_password`) VALUES ('$_POST[name]','$_POST[email]','$_POST[pass]')";
      $sel_sql = "select * from users where user_email = '".trim($_POST['email'])."'";

      $run_sql = mysqli_query($conn,$sel_sql) or die("Error: " . mysqli_error($conn));
      $count =0;
      while($rows = mysqli_fetch_array($run_sql)) {
        $count++;
      }


      if($count == 0) {
        $run_sql = mysqli_query($conn,$ins_sql);
        if($run_sql) {

          $error =  "Success";
        }
        else
        $error =  "Please try again";
      }
      else
      $error = "E-mail already exists";
    }
    else
    $error =  "Password don't match";
  }
  else
  $error =  "Fill all the fields";


}

if($error) {
  if($error == "Success")
  $error = '<div class="alert alert-success"> <a href="#" class="close" aria-label="close" data-dismiss="alert">&times</a>'.$error.'</div>';
  else
  $error = '<div class="alert alert-danger">  <a href="#" class="close" aria-label="close" data-dismiss="alert">&times</a>'.$error.'</div>';
}


?>

<!DOCTYPE html>


<html>
<head>
  <title>Grab Cheap</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

</head>
<body>

  <?php include"include/navbar.php";?>
  <div class="container">
    <article class="row">
      <section class="col-lg-8">
        <div class="page-header"><h2>Registration Form</h2></div>
        <?php echo $error;?>
        <form class="form-horizontal" method="POST"  action="#" role="form">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-8">
              <input type="text" id="name" name="name" class="form-control " placeholder="Name"/>
            </div>
          </div>

          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-8">
              <input type="email" id="email" name="email" class="form-control " placeholder="example@something.com"/>
            </div>
          </div>
          <div class="form-group">
            <label for="pass" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-8">
              <input type="password" name="pass" id="pass" class="form-control " placeholder="******"/>
            </div>
          </div>
          <div class="form-group">
            <label for="cpass" class="col-sm-2 control-label">Confirm Password</label>
            <div class="col-sm-8">
              <input type="password" id="cpass"  name="cpass" class="form-control " placeholder="******"/>
            </div>
          </div>
          <div class="form-group">
            <label for="cpass" class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
              <input type="submit" id="sibmit" name="submit" class="btn btn-block btn-danger"/>
            </div>
          </div>

        </form>

      </section>

      <?php
      include "include/sidebar.php";
      ?>
    </article>
  </div>
  <?php include("include/footer.php") ?>
</body>

</html>
