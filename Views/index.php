<?php
include_once '../Models/ImageReceiver.php';
$receiver = new ImageReceiver();
?>
<html>
<head>
    <title>Grid</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</head>
<body>
<div class="game-board">
<?php for($i=0;$i<9;$i++){?>
  <?php $image =$receiver->getImageUrl(rand(0,count($receiver::$imagePostUrlArray)))?>
    <div class="box">
        <a data-fancybox="gallery" href="<?php echo $image?>"><img src="<?php echo $image?>"></a>
    </div>
<?php };?>
</div>
</body>
</html>

