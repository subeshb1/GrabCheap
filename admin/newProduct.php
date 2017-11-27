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
    <script src="js/newproduct.js"></script>



</head>

<body>
  <?php include ("include/imagemodal.php") ?>
    <?php include "include/header.php";?>
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
                                <h2 >New Product</h2>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="no-more-tables">

                            <table class="table table-bordered table-striped table-condensed cf" id="tab_logic">
                                <thead class="cf">
                                    <tr class="table-danger">
                                        <th>S.N.</th>
                                        <th>Brand Name</th>
                                        <th>Sub-Brand </th>
                                        <th>Product Name</th>
                                        <th> Category</th>
                                        <th>Piece Code</th>
                                        <th>Original Price</th>
                                        <th>Marked Price</th>
                                        <th>Piece Gender</th>
                                        <th>Piece Color</th>
                                        <th>Piece Size</th>
                                        <th>Piece Image</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="row0">

                                        <td data-title="S.N.">1</td>

                                        <td data-title="Brand Name" class="table-success">
                                            <input name="brand" type="text" class="form-control" placeholder="Brand" autocomplete="off" required/></td>

                                        <td data-title="Sub-Brand ">
                                            <input name="subbrand" type="text" class="form-control " placeholder="Sub-Brand" autocomplete="off" required/></td>

                                        <td data-title="Product ">
                                            <input name="product_name" type="text" class=" form-control " placeholder="Product Name" autocomplete="off" required/></td>

                                        <td data-title="Product Category">
                                            <input name="product_category" type="text" class=" form-control " placeholder="Category" autocomplete="off" required/></td>

                                        <td data-title="Piece Code">
                                            <input name="piece_code" type="text" class=" form-control " placeholder="Code" autocomplete="off" required />
                                        </td>

                                        <td data-title="Original Price">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rs.</span>
                                                <input name="piece_original_price" type="text" class=" form-control " placeholder="Rs." autocomplete="off" required />
                                            </div>
                                        </td>

                                        <td data-title="Marked Price">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rs.</span>
                                                <input name="piece_marked_price" type="text" class=" form-control " placeholder="Rs." autocomplete="off" required/>
                                            </div>
                                        </td>

                                        <td data-title="Gender">
                                            <select name="piece_gender" class="btn btn-default">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>

                                        </select>
                                        </td>
                                        <td data-title="Piece Color">
                                            <input name="piece_color" type="text" class=" form-control " placeholder="Color" autocomplete="off" required />
                                        </td>

                                        <td data-title="Piece Size">
                                            <input name="piece_size" type="text" class=" form-control  " placeholder="Size" autocomplete="off" required/>
                                        </td>

                                        <td data-title="Image" class="condensed">

                                            <input name="piece_image" type="file" id="file0" class="form-control file" data-img="a">
                                            <span id="uploaded_image"></span>
                                        </td>

                                    </tr>
                                    <!-- <tr id="row1"></tr> -->

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
