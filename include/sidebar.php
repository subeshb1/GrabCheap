<aside class="col-lg-4">
    <form class="panel-group form-horizontal" role="form">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel-header">
                    <h4>Search Something</h4>
                </div>

                <div class="input-group">
                    <input type="search" class="form-control" placeholder="Search ..." />
                    <div class="input-group-btn ">
                        <button class="btn btn-defaut" type="submit">
              <i class="glyphicon glyphicon-search" ></i>
            </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <?php
  if(!isset( $_SESSION['user_name']))
  echo '
  <form class="panel-group form-horizontal" role="form" action="account/login.php" method="post">
    <div class="panel panel-default">
      <div class="panel-heading">Login Area</div>
      <div class="panel-body">

        <div class="form-group">
          <label for="username" class="control-label col-sm-4">User Name</label>
          <div class="col-sm-7">
            <input type="text" name="username" id="username" class="form-control" placeholder="Email"/>
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="control-label col-sm-4">Password</label>
          <div class="col-sm-7">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <input type="submit"  name="login" class="btn btn-success btn-block" />
          </div>
        </div>
      </div>
    </div>
  </form>';
  ?>
        <div class="list-group">
            <?php

    $sel_sql = "Select * from posts";
    $run_sql = mysqli_query($conn,$sel_sql);
    $class = "";
    while($rows = mysqli_fetch_assoc($run_sql)) {
      if(isset($_GET['post_id'])){
        if($rows['post_id'] == $_GET['post_id'])
        $class = "active";
        else
        $class = "";
      }
      echo '<a href="post.php?post_id='.$rows['post_id'].'" class="list-group-item '.$class.'">
      <h4 class="list-group-item-heading">'.$rows['post_title'].'</h4>
      <p class="list-group-item-text text-justify">'.substr($rows['post_description'],0,100).'</p>
      </a>';
    }
    ?>
    </div>
</aside>
