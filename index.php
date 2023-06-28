<?php
require_once 'backend/sdbh.php';
$dbh = new sdbh();
?>

<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="assets/css/style.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
  <div class="row row-header">
    <div class="col-12">
      <img src="assets/img/logo.png" alt="logo" style="max-height:50px"/>
      <h1>Прокат</h1>
    </div>
  </div>
  <div class="row row-form">
    <h4>Форма расчета:</h4>
    <div class="container_form">
      <div class="row row-body">
        <div class="col-3">
          <span style="text-align: center">Форма обратной связи</span>
          <i class="bi bi-activity"></i>
        </div>
        <div class="col-9">
          <form method="post" action="" id="form">
            <label class="form-label" for="product">Выберите продукт:</label>
            <select class="form-select" name="product" id="product">
              <?php
                $products = $dbh->get_all_assoc($dbh->query_exc('select * from a25_products'));
                foreach($products as $product){ ?>
                  <option value="<?=$product['ID']?>"><?=$product['NAME']?></option>
                <?php
                }
              ?>
            </select>
            <label for="customRange1" class="form-label">Количество дней:</label>
            <input name="days" type="text" class="form-control" id="customRange1" min="1" max="30">
            <label for="customRange1" class="form-label">Дополнительно:</label>
            <?php
            $services = unserialize($dbh->mselect_rows('a25_settings', ['set_key' => 'services'], 0, 1, 'id')[0]['set_value']);
            foreach($services as $k => $v){ ?>
              <div class="form-check">
                <input
                  data-check
                  value="<?= str_replace(' ', '', $v) ?>"
                  class="form-check-input"
                  type="checkbox"
                  id="<?= str_replace(' ', '', $k) ?>" checked>
                <label class="form-check-label" for="<?= str_replace(' ', '', $k) ?>">
                  <?= $k ?>
                </label>
              </div>
              <?php
            }
            ?>
            <button type="submit" id="price_button" class="btn btn-primary">Рассчитать</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <h2 class="result_price"></h2>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
