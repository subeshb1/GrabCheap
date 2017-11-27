<?php session_start();
require "../../include/db.php";

date_default_timezone_set('Asia/Kathmandu');

$success = 0;
$repeated = 0;
$successArray = array();
$repeatedArray = array();
//checking if data has been sent through POST
if(isset($_POST['json'])) {

  //decoding the json in array object
  $data = json_decode($_POST['json']);

  //accessing each array element i.e order
  foreach ($data as $order) {

    //piece_id
    $piece_id = piece($order->piece_code);
    if($piece_id!=="error"){
      //customer_id
      $customer_id = customer($order->customer_number,$order);

      //order_id
      $order_id = order($order->order_price,$piece_id,$customer_id,0);

       updatePiece($order_id,"TRUE");

    }
    else {
      $repeated++;
      $repeatedArray[] = $order->piece_code;
    }
  }


  echo "Successfully added ".$success." pieces.<br />Piece Code: ".implode("<br />Piece ID: ",$successArray)."<br /><br  />";
  echo "Repeated order ".$repeated." pieces.<br />Piece Code: ".implode("<br />Piece ID: ",$repeatedArray)."<br />";


}
//handling order action in order.php
else if ( isset($_POST['update'])) {

    $action = $_POST['action'];
    echo var_dump($action);

    $order_id = $_POST['update'];
    if($action === "1") {
      completeOrder($order_id);
    }else {
      cancelOrder($order_id);
    }

}
//returns piece_id for respective piece_code
function piece($piece_code) {

  global $conn;
  $sel_sql = "SELECT piece_id from piece WHERE piece_code = '$piece_code' AND piece_order = FALSE";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($run_sql) == 1) {
    $row = mysqli_fetch_assoc($run_sql);
    return $row['piece_id'];

  }
  else return "error";
}


//returns customer_id if present else creates one and returns customer_id
function customer($customer_number,$data) {
  global $conn;
  $sel_sql = "SELECT customer_id from customer WHERE customer_number = '$customer_number'";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($run_sql)) {
    $row = mysqli_fetch_assoc($run_sql);
    return $row['customer_id'];
  }
  else {
    $sel_sql = "INSERT INTO `customer`( `customer_number`, `customer_name`, `customer_address`, `customer_gender`) VALUES
    ('$customer_number','$data->customer_name','$data->customer_address','$data->customer_gender')";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    return customer($customer_number,$data);
  }
}

//make a new order and return order_id

function order($order_price,$piece_id,$customer_id,$check) {
  global $conn;
  global $success;
  global $successArray;
  if($check){
    $sel_sql = "SELECT order_id from orders WHERE piece_id = '$piece_id'";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

    if(mysqli_num_rows($run_sql)) {
      $row = mysqli_fetch_assoc($run_sql);
      return $row['order_id'];
    }
  }
  else {
    $order_time = time();
    $user_id = user();
    $sel_sql = "INSERT INTO `orders`( `order_time`, `order_completion_time`, `order_completion`, `order_price`, `piece_id`, `customer_id`, `user_id`, `order_status`) VALUES
    ($order_time,NULL,FALSE,'$order_price','$piece_id','$customer_id','$user_id','PENDING')";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    $success++;
    $successArray[] = $piece_id;
    return order($order_price,$piece_id,$customer_id,1);

  }

}

function user() {
  global $conn;
  if(isset($_SESSION['user_name'])) {
    $sel_sql = "SELECT user_id from users WHERE user_email = '$_SESSION[user_name]'";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

    if(mysqli_num_rows($run_sql)) {
      $row = mysqli_fetch_assoc($run_sql);
      return $row['user_id'];
    }
  }
}
//piece_order handle
function updatePiece($order_id,$boolean) {
  global $conn;
  $sel_sql = "UPDATE piece set piece_order = $boolean WHERE piece_id = (SELECT piece_id from orders WHERE order_id = $order_id) ";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
  if($run_sql) {
    return "success";
  }
}


//cancel order
function cancelOrder($order_id) {
  global $conn;
  echo updatePiece($order_id,"FALSE");
  $sel_sql = "UPDATE orders set order_status='CANCELED' WHERE order_id=$order_id";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
  if($run_sql) {
    echo "success";
  }
}

//completeOrder
function completeOrder($order_id) {
  global $conn;
  $time = time();
  echo updatePiece($order_id,"FALSE");
  echo pieceSold($order_id);
  $sel_sql = "UPDATE orders set order_status='COMPLETED',order_completion_time=$time ,order_completion=TRUE WHERE  order_id=$order_id";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
  if($run_sql) {
    echo "success";
  }
}

//sell piece
function pieceSold($order_id) {
  global $conn;
  $sel_sql = "UPDATE piece set piece_available = FALSE,piece_sold_price= (SELECT order_price FROM orders WHERE order_id = $order_id) WHERE piece_id = (SELECT piece_id from orders WHERE order_id = $order_id) ";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
  if($run_sql) {
    return "success";
  }else {
    return "error";
  }
}


?>
