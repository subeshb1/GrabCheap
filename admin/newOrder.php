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
    <script src="js/neworder.js"></script>



</head>

<body>
    <?php include "include/header.php";?>
    <?php include ("include/imagemodal.php") ?>
    <div id="wrapper">
        <?php include "include/sidebar.php";?>
        <!-- Main content-->

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="table-alert alert alert-danger" hidden></div>
                <div class="table-alert2 alert alert-success" hidden></div>
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <h2 >New Order</h2>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">
                <div id="no-more-tables">

                    <table class="table table-bordered table-striped table-condensed cf" id="tab_logic">
                        <thead class="cf">
                            <tr class="table-danger">
                                <th>S.N.</th>
                                <th>Ordered Piece Code</th>
                                <th>Product Name </th>
                                <th>Settled Price</th>
                                <th>Customer Mobile Number</th>
                                <th>Customer Name</th>
                                <th>Customer Address</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr id="row0">

                                <td data-title="S.N.">1</td>

                                <td data-title="Ordered Piece Code" >
                                    <input name="piece_code" type="text" class="form-control typeahead" placeholder="Code" autocomplete="off" required/></td>

                                <td data-title="Product Name">
                                    <input name="product_name" type="text" class="form-control " placeholder="Product Name" autocomplete="off" required disabled/></td>

                                <td data-title="Settled Price">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rs.</span>
                                        <input name="order_price" type="text" class=" form-control typeahead " placeholder="Rs." autocomplete="off" required/>
                                    </div>
                                </td>

                                <td data-title="Customer Number">
                                    <input name="customer_number" type="text" class=" form-control typeahead " placeholder="Number" autocomplete="off" required/></td>

                                <td data-title="Customer Name">
                                    <input name="customer_name" type="text" class=" form-control " placeholder="Name" autocomplete="off" required/></td>

                                <td data-title="Customer Address">
                                    <input name="customer_address" type="text" class=" form-control typeahead " placeholder="Address" autocomplete="off" required />
                                </td>



                                <td data-title="Gender">
                                    <select name="customer_gender" class="btn btn-default">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>

                                        </select>
                                </td>

                        </tbody>
                    </table>
                    </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <a id="add_row" class="btn btn-primary pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-danger">Delete Row</a>
                            <button id="save_button" type="button" class="btn btn-success center-block">Save</button>
                        </div>
                    </div>


                </div>

                <div class="table-alert alert alert-danger" hidden></div>
                <div id="result"></div>
                <div style="height:50px;width:50px"></div>
            </div>
        </div>
    </div>

</body>

</html>
