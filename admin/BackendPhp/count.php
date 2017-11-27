<?php
include "../../include/db.php";
if(isset($_POST['type'])) {
    $type = $_POST['type'];

    if($type == "piece"){
      $orderBy = $_POST['orderBy'];
      $order = $_POST['order'];
      $filterObject = json_decode($_POST['filterObject']);

      $sel_sql = "SELECT count(*) as total from brand inner join subbrand on subbrand.brand_id = brand.brand_id inner join product on product.subbrand_id=subbrand.subbrand_id inner join piece on product.product_id= piece.product_id where  piece_order=FALSE and piece_available=true and
      brand_name LIKE '$filterObject->brand_name%' and
      subbrand_name LIKE '$filterObject->subbrand_name%' and
      product_name LIKE '$filterObject->product_name%' and
      product_category LIKE '$filterObject->product_category%' and
      piece_code LIKE '$filterObject->piece_code%' and
      piece_original_price LIKE '$filterObject->piece_original_price%' and
      piece_marked_price LIKE '$filterObject->piece_marked_price%' and
      piece_gender LIKE '$filterObject->piece_gender%' and
      piece_color LIKE '$filterObject->piece_color%' and
      piece_size LIKE '$filterObject->piece_size%'";
      $run_sql = mysqli_query($conn,$sel_sql) or die(mysqli_error($conn));
      $row = mysqli_fetch_assoc($run_sql);
      echo $row['total'];
    }
    else if ($type == "order") {
      $orderBy = $_POST['orderBy'];
      $order = $_POST['order'];
      $filterObject = json_decode($_POST['filterObject']);

      $filter = getFilter($_POST['status']);
      $sel_sql = "SELECT count(*) as total  from orders INNER JOIN customer on  customer.customer_id = orders.customer_id INNER join piece on piece.piece_id = orders.piece_id INNER JOIN product on product.product_id = piece.product_id
      WHERE $filter AND
      order_id LIKE '$filterObject->order_id%' AND
      product_name LIKE '$filterObject->product_name%' AND
      piece_code LIKE '$filterObject->piece_code%' AND
      piece_size LIKE '$filterObject->piece_size%' AND
      piece_color LIKE '$filterObject->piece_color%' AND
      piece_gender LIKE '$filterObject->piece_gender%' AND
      order_price LIKE '$filterObject->order_price%' AND
      customer_name LIKE '$filterObject->customer_name%' AND
      customer_number LIKE '$filterObject->customer_number%' AND
      customer_address LIKE '$filterObject->customer_address%'
       ORDER BY $orderBy $order
     ";
      $run_sql = mysqli_query($conn,$sel_sql);
      $row = mysqli_fetch_assoc($run_sql);
      echo $row['total'];
    }else
        echo "90909";
}



function getFilter($num) {
    switch($num){
        case 0:

            return "order_status='COMPLETED'";
        case 1:
            return "order_status='PENDING'";
        case 2:
            return "order_status='CANCELED'";
        case 3:
            return 1;

    }
}

 ?>
