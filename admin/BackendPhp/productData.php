<?php
include "../../include/db.php";
if(isset($_POST['page'])) {
  $page = $_POST['page']*7;
  $orderBy = $_POST['orderBy'];
  $order = $_POST['order'];
  $filterObject = json_decode($_POST['filterObject']);


  $data = array();
  $sel_sql = "SELECT brand_name,subbrand_name,product_name,product_category,piece_code,piece_original_price,piece_marked_price,piece_gender,piece_color,piece_size,piece_image from brand inner join subbrand on subbrand.brand_id = brand.brand_id inner join product on product.subbrand_id=subbrand.subbrand_id inner join piece on product.product_id= piece.product_id
   where piece_order=FALSE and piece_available=true and
   brand_name LIKE '$filterObject->brand_name%' and
   subbrand_name LIKE '$filterObject->subbrand_name%' and
   product_name LIKE '$filterObject->product_name%' and
   product_category LIKE '$filterObject->product_category%' and
   piece_code LIKE '$filterObject->piece_code%' and
   piece_original_price LIKE '$filterObject->piece_original_price%' and
   piece_marked_price LIKE '$filterObject->piece_marked_price%' and
   piece_gender LIKE '$filterObject->piece_gender%' and
   piece_color LIKE '$filterObject->piece_color%' and
   piece_size LIKE '$filterObject->piece_size%' ORDER BY $orderBy $order
   LIMIT $page,7;
  ";
  $run_sql = mysqli_query($conn,$sel_sql);
  while ($row = mysqli_fetch_assoc($run_sql)) {
    $data[] = $row;
  }
  echo json_encode($data);
}


?>
