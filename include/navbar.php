<!-- Nav bar-->
<?php
$home = "";
$post = "";
$registration = "";
if(strrpos($_SERVER['SCRIPT_NAME'],"index.php") )
$home = "active";
else if(strrpos($_SERVER['SCRIPT_NAME'],"post.php"))
$post = "active";
else {
  $registration="active";
}


?>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class=" container-fluid">
          <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>



                <a href="index.php" class="navbar-brand">
        <img style="height:50px; margin-top:-15px"   src="img/logo_inverse.jpg" />
      </a>
                <div class="navbar-brand">
                    <a href="index.php" class="navbar-brand" style=" margin-top:-15px;">GRABCHEAP</a>
                </div>
            </div>



            <div class="navbar-collapse collapse" id="mainNavBar">
                <ul class="nav navbar-nav ">
                    <li class="<?php echo $home;?>"><a href="index.php">Home</a></li>
                    <li class="<?php echo $post;?>"> <a href="post.php">Articles</a></li>
                    <li><a href="#">Products</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
        if(!isset($_SESSION['user_name'])){
          echo '<li class="'.$registration.'"><a  href="registration.php">Register  </a></li>';
        }
        else {
          echo '
          <li ><a href="admin/index.php">Admin Panel</a></li>
          <li > <a href="account/logout.php">Log Out</a></li> ';
        }
        ?>
                </ul>
            </div>
        </div>
    </nav>
