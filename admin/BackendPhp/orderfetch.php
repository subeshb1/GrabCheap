<?php
//fetch.php
include "../../include/db.php";

if(isset($_POST["dat"],$_POST["item"])) {
  $type = $_POST["item"];
  $data = $_POST["dat"];
  if($type == "piece") {
    $sel_sql = "SELECT product_name FROM `product` WHERE product_id =( SELECT product_id FROM piece WHERE piece_code='$data' AND piece_available=TRUE AND piece_order = FALSE)";
    $run_sql = mysqli_query($conn,$sel_sql);
    if(mysqli_num_rows($run_sql)) {
      $row = mysqli_fetch_assoc($run_sql);
      echo json_encode($row);
    }

  }
  else {
    $sel_sql = "SELECT customer_name,customer_address,customer_gender FROM customer WHERE customer_number = '$data'";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    if(mysqli_num_rows($run_sql)) {
      $row = mysqli_fetch_assoc($run_sql);
      echo json_encode($row);
    }


  }
}

else if(isset($_POST["query"],$_POST["type"]) ){
  $str = mysqli_real_escape_string($conn, $_POST["query"]);
  $data = $_POST['type'];
  $table = getTable($data);
  $attribute = getAttribute($data);
  if($table!="" && $attribute!=""){
    if($table === "piece")
    $sel_sql = "SELECT distinct $attribute FROM $table where $attribute LIKE '".$str."%' AND piece_order = FALSE AND piece_available=TRUE";
    else
    $sel_sql = "SELECT distinct $attribute FROM $table where $attribute LIKE '".$str."%'";
    $run_sql = mysqli_query($conn,$sel_sql)or die(mysqli_error($conn));
    $data = array();

    if(mysqli_num_rows($run_sql)) {
      while($row = mysqli_fetch_assoc($run_sql))
      {
        $data[] = $row[$attribute];
      }
      echo json_encode($data);
    }else {
      echo json_encode($data);
    }

  }
}

function getTable($data) {

  if(strrpos($data,"piece")!==false)
  return "piece";
  else if(strrpos($data,"customer")!==false)
  return "customer";
  else
  return "";
}

function getAttribute($data) {
  if(strrpos($data,"piece")!==false)
  return "piece_code";
  else if(strrpos($data,"customer")!==false)
  return "customer_number";
  else
  return "";
}


?>
