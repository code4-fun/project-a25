<?php
require_once('sdbh.php');
$dbh = new sdbh();

$function = $_POST['function'];
switch($function){
  case 'calculate_price':
    echo json_encode(calculate_price(), JSON_UNESCAPED_UNICODE);
}

function calculate_price(){
  global $dbh;

  if(empty($_POST['days']) || $_POST['days'] < 0){
    return '<span>Необходимо заполнить количество дней</span>';
  }

  $product_id = $_POST['product'];
  $days_selected = $_POST['days'];
  $services_selected = explode('<<>>', $_POST['checked_services']);
  $result_price = 0;

  $product = $dbh->mselect_rows('a25_products', ['ID' => $product_id], 0, 1, 'id')[0];
  $tariff = unserialize($product['TARIFF']);

  if(empty($tariff)){
    $result_price = $days_selected * $product['PRICE'];
  } else {
    krsort($tariff);
    foreach($tariff as $days => $price){
      if($days_selected < $days){
        continue;
      } else {
        $result_price = $days_selected * $price;
        break;
      }
    }
  }

  if($services_selected){
    foreach($services_selected as $service){
      $result_price += $service * $days_selected;
    }
  }

  return "<span>Итоговая стоимость: {$result_price}</span>";
}
