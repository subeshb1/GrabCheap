<?php session_start();
require "../../include/db.php";
$success = 0;
$repeated = 0;
$successArray = array();
$repeatedArray = array();
if(isset($_POST['json'])) {

    $data =  json_decode($_POST['json']);

    for($i = 0;$i < count($data);$i++) {
    $brand_id =  brand($data[$i]->brand);
     $subbrand_id =  subBrand($data[$i]->subbrand,$brand_id);
     $product_id = product($data[$i]->product_name,$subbrand_id,$data[$i]->product_category);
     $piece_id = piece($data[$i],$product_id,0);
    }
    echo $success." pieces successfully added!</br>".implode("<br />",$successArray)."<br />";
    if($repeated!==0) {
        echo $repeated." repeated piece. Not Updated! </br>".implode("<br />",$repeatedArray);
    }

}

function brand($brand) {
  global $conn;
  $brand = trim($brand);
  $sel_sql = "SELECT brand_id from brand WHERE brand_name = '$brand'";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($run_sql)) {
    $row = mysqli_fetch_assoc($run_sql);
    return $row['brand_id'];
  }
  else {
    $sel_sql = "INSERT INTO `brand`( `brand_name`) VALUES ('$brand')";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    return brand($brand);
  }
}

function subBrand($subbrand,$brand) {
  $subbrand = trim($subbrand);
  global $conn;
  $sel_sql = "SELECT subbrand_id from subbrand WHERE subbrand_name = '$subbrand'";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($run_sql)) {
    $row = mysqli_fetch_assoc($run_sql);
    return $row['subbrand_id'];
  }
  else {
    $sel_sql = "INSERT INTO `subbrand`( `subbrand_name`, `brand_id`) VALUES ('$subbrand',$brand)";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

    return subBrand($subbrand,$brand);
  }
}

function product($product_name,$subbrand_id,$product_category) {
  $product_name = trim($product_name);
  $product_category = trim($product_category);
  global $conn;
  $sel_sql = "SELECT product_id from product WHERE product_name = '$product_name'";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($run_sql)) {
    $row = mysqli_fetch_assoc($run_sql);
    return $row['product_id'];
  }
  else {
    $sel_sql = "INSERT INTO `product`( `product_name`, `subbrand_id`, `product_category`) VALUES ('$product_name',$subbrand_id,'$product_category')";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    return product($product_name,$subbrand_id,$product_category);
  }
}

function piece($data,$product_id,$check) {
  global $success ;
  global $repeated ;
  global $successArray ;
  global $repeatedArray ;
  global $conn;
  $piece_code = $data->piece_code;
  $sel_sql = "SELECT piece_code from piece WHERE piece_code = '$piece_code'";
  $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($run_sql)) {
    $row = mysqli_fetch_assoc($run_sql);
    if(!$check){
    $repeated++;
    $repeatedArray[] = $piece_code;
  }

    return $row['piece_code'];
  }
  else {
    $sel_sql = "INSERT INTO `piece`(`piece_code`, `piece_color`, `piece_gender`, `piece_available`, `piece_sold_price`, `piece_image`, `product_id`, `piece_marked_price`, `piece_original_price`,`piece_size`) VALUES
    ('$piece_code','$data->piece_color','$data->piece_gender',TRUE,NULL,'$data->piece_image',$product_id,$data->piece_marked_price,$data->piece_original_price,$data->piece_size)";
    $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
    $success++;
    $successArray[] = $piece_code;
    return piece($data,$product_id,1);
  }
}

?>
