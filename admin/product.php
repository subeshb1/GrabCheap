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

    <script src="js/product.js"></script>

</head>

<body>
    <?php include "include/header.php";?>
    <?php include ("include/imagemodal.php") ?>

    <!-- Edit tab Modal-->
    <div class="modal fade" id="actionModal">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="brand_name ">Brand</label>
                            <input type="text" placeholder="Brand" class="form-control" id="brand_name" />
                        </div>
                        <div class="form-group">
                            <label for="subbrand_name ">Sub Brand</label>
                            <input type="text" placeholder="Sub Brand" class="form-control" id="subbrand_name" />
                        </div>
                        <div class="form-group">
                            <label for="product_name ">Product</label>
                            <input type="text" placeholder="Product Name" class="form-control" id="product_name" />
                        </div>
                        <div class="form-group">
                            <label for="product_category ">Category</label>
                            <input type="text" placeholder="Category" class="form-control" id="product_category" />
                        </div>
                        <div class="form-group">
                            <label for="piece_code">Piece Code</label>
                            <input type="text" placeholder="Piece Code" class="form-control" id="piece_code" />
                        </div>
                        <div class="form-group">
                            <label for="piece_original_price">Original Price</label>
                            <input type="text" placeholder="Original Price" class="form-control" id="piece_original_price" />
                        </div>
                        <div class="form-group">
                            <label for="piece_marked_price">Marked Price</label>
                            <input type="text" placeholder="Marked Price" class="form-control" id="piece_marked_price" />
                        </div>
                        <div class="form-group">
                            <label for="Gender">Gender</label>
                            <select class="form-control">
                                <option value = "Male">Male</option>
                                <option value = "Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="piece_color">Piece Color</label>
                            <input type="text" placeholder="Color" class="form-control" id="piece_color" />
                        </div>
                        <div class="form-group">
                            <label for="piece_size">Piece Size</label>
                            <input type="text" placeholder="Size" class="form-control" id="piece_size" />
                        </div>
                        <div class="form-group">
                            <label for="piece_image">Image</label>
                            <input type="file" placeholder="Size" class="form-control" id="piece_image" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>


            </div>

        </div>
    </div>
    <div id="wrapper">
        <?php include "include/sidebar.php";?>

        <!-- Main content-->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <h1 class="panel-title">Piece</h1>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button class="btn btn-primary  pull-right" id="filter">Filters</button>

                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#actionModal">Edit</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#actionModal">Delete</button>

                    </div>
                    <div class="panel-body">

                        <div id="no-more-tables">


                            <table class="table table-bordered table-striped table-list" id="tab_logic">
                                <thead>
                                    <tr id="tablefilter" hidden="true" display="">
                                        <th></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="brand_name" placeholder=" Brand" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="subbrand_name" placeholder=" Sub-Brand" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="product_name" placeholder="Product" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="product_category" placeholder="Category" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="piece_code" placeholder="Code" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="piece_original_price" placeholder="Original Price" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="piece_marked_price" placeholder="Marked" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="piece_gender" placeholder="Gender" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="piece_color" placeholder="Color" /></th>
                                        <th><input type="text" class="form-control dataFilter" data-value="piece_size" placeholder="Size" /></th>
                                        <th></th>
                                    </tr>
                                    <tr id="colhead" data-toggle="no-filter">
                                        <th>S.N.</th>
                                        <th class="sortable" data-order="NONE" data-value="brand_name">
                                            Brand

                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="subbrand_name">Sub Brand
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="product_name">Product
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="product_category">Category
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>

                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="piece_code">Code
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="piece_original_price">Original Rs.
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="piece_marked_price"> Marked Price
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>

                                        <th class="sortable" data-order="NONE" data-value="piece_gender">Gender
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="piece_color">Color
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th class="sortable" data-order="NONE" data-value="piece_size">Size
                                            <div class="pull-right "><span class="glyphicon glyphicon-sort" style="Color:rgb(188, 188, 188);"> </span></div>
                                        </th>
                                        <th>Piece Image</th>



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
                                <ul class="pagination  pull-right">

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
