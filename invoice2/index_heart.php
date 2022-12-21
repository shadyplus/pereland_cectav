<!DOCTYPE html>
<html>

<head>
    <script>
    (function(window) {
      if (window.location !== window.top.location) {
        window.top.location = window.location;
      }
    })(this);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <?php if (isset($title)): ?>
        <title><?php echo $title ?></title>
    <?php else: ?>
        <title>Заказ принят</title>
    <?php endif ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="static/style.css" media="all">
    <style>
    body { margin-top: 50px }

    .gift-box {
	position: relative;
	background: #fff;
	border: 2px solid #f50000;
	max-width: 800px;
    }
    .gift-box:after, .gift-box:before {
	top: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
    }

    .gift-box:after {
	border-color: rgba(136, 183, 213, 0);
	border-top-color: #fff;
	border-width: 30px;
	margin-left: -30px;
    }
    .gift-box:before {
	border-color: rgba(245, 0, 0, 0);
        border-top-color: #f50000;
        border-width: 33px;
        margin-left: -33px;
    }
    </style>
</head>

<body>
<?php if($order_id) { ?>
    <h1>Ваша заявка принята.</h1>
    
    <!-- <h2>Спасибо за проявленный интерес!</h2> -->

    <p>
      Спасибо за Ваш заказ! <br>
      Наш оператор свяжется с Вами в самое ближайшее время. Пожалуйста, включите ваш контактный телефон.
    </p>

    <table style="margin: auto">
            
        <tr>
            <th>Вы заказали</th>
            <td>
                <?= $product_name ?>
            </td>
        </tr>
    
        <tr>
            <th>Заказ №:</th>
            <td><?= $order_id ?></td>
        </tr>

        <tr>
            <th>Имя:</th>
            <td><?= $order_name; ?></td>
        </tr>

        <tr>
            <th>Телефон для связи:</th>
            <td><?= $order_phone; ?></td>
        </tr>


    </table>
<?php
    if (isset($tracker_pixels)) {
        foreach($tracker_pixels as $pixel_name => $pixel_id) {
            require_once (__DIR__.'/../pieces/trackers/'.$pixel_name.'.php');
        }
    }
    require_once (__DIR__.'/../trackers_order.php');
}
else {
    echo 'Error!';
}
?>

</body>
</html>
