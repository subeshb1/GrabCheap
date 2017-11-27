
<?php
include "../../include/db.php";
if(isset($_POST['page'])) {
  $page = $_POST['page']*7;
  $orderBy = $_POST['orderBy'];
  $order = $_POST['order'];
  $filterObject = json_decode($_POST['filterObject']);
  $data = array();
  $filter = getFilter($_POST['status']);

  $sel_sql = "SELECT order_id,product_name,piece_code,piece_size,piece_color,piece_gender,order_price,customer_name,customer_number,customer_address,piece_image,order_status
  from orders INNER JOIN customer on  customer.customer_id = orders.customer_id
  INNER join piece on piece.piece_id = orders.piece_id
  INNER JOIN product on product.product_id = piece.product_id
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
    ORDER BY $orderBy $order LIMIT $page,7
  ";

  $run_sql = mysqli_query($conn,$sel_sql);
  if(mysqli_num_rows($run_sql) >=1) {
    while ($row = mysqli_fetch_assoc($run_sql)) {
      $data[] = $row;
    }
  }
  echo json_encode($data);
}else {
  echo json_encode($data);
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
