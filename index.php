<?php session_start();
include "include/db.php";
$errorCode = "";
if(!isset($_SESSION['user_name'])) {
  if(isset($_GET['login'])) {
    if($_GET['login'] == 'incorrect') {
      $errorCode = '<div class="alert alert-danger"> <a href="#" class="close" aria-label="close" data-dismiss="alert">&times</a>Username or Password Incorrect</div>';
    }elseif ($_GET['login'] == 'empty') {
      $errorCode = '<div class="alert alert-danger"> <a href="#" class="close" aria-label="close" data-dismiss="alert">&times</a>Please fill in both UserName and Password</div>';
    }
    else {

      $errorCode = '<div class="alert alert-danger"> <a href="#" class="close" aria-label="close" data-dismiss="alert">&times</a>Connection Problem. Please try again later.</div>';
    }
  }
}
else {
  $errorCode = "";
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
        <?php echo $errorCode; ?>
        <article class="row">
            <section class="col-lg-8">
                <?php
        $sel_sql = "SELECT * FROM posts";
        $run_sql = mysqli_query($conn,$sel_sql);
        while($rows = mysqli_fetch_assoc($run_sql)) {
          echo'
          <div class="panel panel-success">
          <div class="panel-heading">
          <h3><a href="post.php?post_id='.$rows['post_id'].'">'.$rows['post_title'].'</a></h3>
          </div>
          <div class="panel-body">
          <div class="col-lg-4">
          <img src="'.$rows['post_image'].'" width="100%"/>
          </div>
          <div class="col-lg-8"><p class="text-justify">
          '.substr($rows['post_description'],0,300).'...
          </p>
          </div>
          <a href="post.php?post_id='.$rows['post_id'].' " class="btn btn-primary">Read More</a>
          </div>
          </div>
          ';
        }
        ?>
            </section>

            <?php
      include "include/sidebar.php";
      ?>
        </article>
    </div>
    <?php include("include/footer.php") ?>
</body>
</html>
