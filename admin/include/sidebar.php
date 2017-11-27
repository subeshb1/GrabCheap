<!--static sidebar-->
<div id="sidebar-wrapper" class="navbar-default nav">
    <ul class="nav navbar-default  ">

        <li><a href="#" class="alert alert-info" id="menuList"><strong>Menu</strong> <i class="glyphicon glyphicon-menu-hamburger pull-right"></i> </a></li>

        <li ><a href="index.php"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a></li>
        <li><a href="#new-item" data-toggle="collapse"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Item</a>
            <ul class="nav collapse" id="new-item">
                <li><a href="newProduct.php"><i class="glyphicon glyphicon-shopping-cart"><div  class="col-sm-3"></div></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; New Product</a></li>
                <li><a href="newOrder.php"><i class="glyphicon glyphicon-usd"><div  class="col-sm-3"></div></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Order</a></li>
            </ul>
        </li>
        <li><a href="#"><i class="glyphicon glyphicon-list"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Posts</a></li>
        <li><a href="order.php"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orders</a></li>
        <li><a href="product.php"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Products</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-tasks"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Categories</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-user"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Profile</a></li>
    </ul>

    <!--Menu toggle Scrip-->

</div>

<div id="sidebar-button" class="navbar-default nav">
    <a href="#" class="btn btn-toolbar " id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
</div>


<script>
$(document).ready(function() {
  $("#sidebar-wrapper").hide();
    $("#menuList").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").hide(400);
        $("#wrapper").toggleClass("menuDisplayed");
    });

    $("#menu-toggle").click(function(e) {
        e.preventDefault();

        $("#wrapper").toggleClass("menuDisplayed");
        $("#sidebar-wrapper").show(400);
    });
  });

</script>
