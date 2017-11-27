<?php session_start();
include "../include/db.php";
if(isset($_SESSION['user_name'])) {
  $sel_sql = "SELECT * FROM users WHERE user_email = '$_SESSION[user_name]'";
  if($run_sql = mysqli_query($conn,$sel_sql)) {
    if(mysqli_num_rows($run_sql)) {

    }else {
      header('Location: ../index.php');
    }
  }
  else {
    header('Location: ../index.php');
  }
}
else {
  header('Location: ../index.php');
}
?>

<!DOCTYPE html>

<html>

<head>
    <?php require "include/head.php" ?>
    
</head>

<body>
    <?php include "include/header.php";?>
    <div id="wrapper">
        <?php include "include/sidebar.php";?>
        <!-- Main content-->
        <div id="page-content-wrapper">
            <div class="col-md-3 ">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size:4.5em"></i></div>
                            <div class="col-xs-9 text-right">
                                <div style="font-size:2.5em">20</div>
                                <div>Orders</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <div class="pull-left">View Orders</div>
                            <div class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></div>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 ">
                <a href="#">
                    <div class="panel panel-primary">


                        <div class="panel-heading">

                            <div class="row">
                                <div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size:4.5em"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div style="font-size:2.5em">10</div>
                                    <div>Sold</div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <div class="pull-left">View Sales</div>
                            <div class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 ">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size:4.5em"></i></div>
                            <div class="col-xs-9 text-right">
                                <div style="font-size:2.5em">15%</div>
                                <div>Profit</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <div class="pull-left">View Profit</div>
                            <div class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></div>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size:4.5em"></i></div>
                            <div class="col-xs-9 text-right">
                                <div style="font-size:2.5em">5</div>
                                <div>Posts</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <div class="pull-left">View Products</div>
                            <div class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></div>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size:4.5em"></i></div>
                            <div class="col-xs-9 text-right">
                                <div style="font-size:2.5em">115</div>
                                <div>Products</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <div class="pull-left">View Products</div>
                            <div class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></div>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

    </div>

</body>

</html>
