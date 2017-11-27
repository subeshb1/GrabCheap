<?php session_start();

include "../include/db.php";
if(isset($_POST['login'])) {
  if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $getUserName = mysqli_real_escape_string($conn,$_POST['username']);
    $getPassword = mysqli_real_escape_string($conn,$_POST['password']);
    $sel_sql = "Select * from users where user_email = '$getUserName' AND user_password = '$getPassword'";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    if($run_sql) {
      if(mysqli_num_rows($run_sql) == 1) {
          $_SESSION['user_name'] = $getUserName;
          header('Location: ../admin');
      }
      else {
        header('Location: ../index.php?login=incorrect');
      }
    }
    else{
      header('Location: ../index.php?login=connection_error');
    }
  }
  else {
    header('Location: ../index.php?login=empty');
  }
}
else {
  header('Location: ../index.php?login=empty');
}
?>
