<?php session_start();
include "include/db.php";
?>

<!DOCTYPE html>


<html>
<head>
  <title>Posts</title>
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
        <div class="panel panel-default">
          <?php

          if (isset($_GET['post_id']))
          {
            $sel_sql = "Select * from posts where post_id = '$_GET[post_id]'";
            $run_sql = mysqli_query($conn, $sel_sql);

            if ($rows = mysqli_fetch_assoc($run_sql))
            {
              echo '
              <div class="panel-heading">
              <h3>' . $rows['post_title'] . '</h3>
              </div>
              <div class="panel-body">
              <img src="' . $rows['post_image'] . '" width="100%"/>
              <div style="margin-top:20px;">
              <p class="text-justify ">
              ' . $rows['post_description'] . '
              </p>
              </div>
              </div>
              ';
            }
            else echo "<p>No such Post</p>";
          }
          else echo "<p>No such Post</p>";
          ?>

        </div>
      </section>

      <?php
      include "include/sidebar.php";
      ?>
    </article>
  </div>
  <?php include("include/footer.php") ?>
</body>

</html>
