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
  <script src="js/order.js"></script>

</head>

<body>
  <?php include "include/header.php";?>


  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="modalClose">&times;</button>
          <h4 class="modal-title">Cancel Order</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <?php include ("include/imagemodal.php") ?>


  <div id="wrapper">
    <?php include "include/sidebar.php";?>

    <!-- Main content-->
    <div id="page-content-wrapper">
      <div class="container-fluid">

        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <div class="row">
              <div class="col col-xs-6">
                <h1 class="panel-title">Orders</h1>
              </div>

              <div class=" text-right">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-success btn-filter " data-target="0">
                    <input type="radio" name="options" id="option1" autocomplete="off" checked>
                    Completed
                  </label>
                  <label class="btn btn-warning btn-filter" data-target="1">
                    <input type="radio" name="options" id="option2" autocomplete="off"> Pending
                  </label>
                  <label class="btn btn-danger btn-filter " data-target="2">
                    <input type="radio" name="options" id="option3" autocomplete="off"> Canceled
                  </label>
                  <label class="btn btn-default btn-filter active" data-target="3">
                    <input type="radio" name="options" id="option4" autocomplete="off"> All
                  </label>

                </div>

                  <button class="btn btn-primary" id="filter">Filters</button>


              </div>

            </div>
            <div class="row" id="action" hidden="false">
              <button class="btn btn-success " id="complete">Complete &nbsp;<i class="glyphicon glyphicon-ok"></i></button>&nbsp;
              <button class="btn btn-danger " id="cancel">Cancel&nbsp;<i class="glyphicon glyphicon-remove"></i></button>
            </div>
          </div>


            <div class="panel-body">
              <div id="no-more-tables">
                <table class="table table-bordered table-striped table-list " id="tab_logic">

                  <thead>
                    <tr id="tablefilter" hidden="true">
                      <th></th>
                      <th><input type="text" class="form-control dataFilter" data-value="order_id" placeholder=" Number" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="product_name" placeholder=" Name" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="piece_code" placeholder=" Code" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="piece_size" placeholder=" Size" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="piece_color" placeholder=" Color" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="piece_gender" placeholder=" Gender" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="order_price" placeholder=" Price" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="customer_name" placeholder=" Name" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="customer_number" placeholder=" Number" /></th>
                      <th><input type="text" class="form-control dataFilter" data-value="customer_address" placeholder=" Address" /></th>
                      <th></th>
                    </tr>
                    <tr id="colhead" data-toggle="no-filter">
                      <th>S.N.</th>
                      <th class="sortable" data-order="NONE" data-value="orders.order_id">
                        Order Number

                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="product_name">Product Name
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="piece_code">Product Code
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="piece_size">Product Size
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>

                      </th>
                      <th class="sortable" data-order="NONE" data-value="piece_color">Product Color
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="piece_gender">Product Gender
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="order_price">Order Price
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="customer_name">Customer Name
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="customer_number">Customer Number
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th class="sortable" data-order="NONE" data-value="customer_address">Customer Address
                        <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                      </th>
                      <th>Piece Image</th>
                      <th>Piece Status</th>

                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>
            </div>
            <div class="panel-footer">
              <div class="row">
                <div class="col col-xs-4" id="page">
                </div>
                <div class="col col-xs-8">
                  <ul class="pagination  pull-right ">

                  </ul>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>

  </html>
