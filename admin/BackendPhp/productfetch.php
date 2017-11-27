<?php
//fetch.php
include "../../include/db.php";


if(isset($_POST["query"],$_POST["type"]) ){
$str = mysqli_real_escape_string($conn, $_POST["query"]);
$data = $_POST['type'];
$table = getTable($data);
$attribute = getAttribute($data);
if($table!="" && $attribute!=""){
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

} else {
  echo json_encode($data);
}
}

function getTable($data) {
  if (strrpos($data,"subbrand")!==false) {
    return "subbrand";
  }else if(strrpos($data,"brand")!==false) {
    return "brand";
  }else if(strrpos($data,"product")!==false){
      return "product";
  }else if(strrpos($data,"piece")!==false)
      return "piece";
    else
        return "";
}

function getAttribute($data) {
  if (strrpos($data,"subbrand")!==false) {
    return "subbrand_name";
  }
  else if(strrpos($data,"brand")!==false) {
    return "brand_name";
  }else if(strrpos($data,"product")!==false){
      if(strrpos($data,"name")!==false)
        return "product_name";
      else
          return "product_category";
  } else if(strrpos($data,"color")!==false)
      return "piece_color";
      else
        return "";
}


?>
