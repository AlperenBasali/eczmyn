<?php require_once('config.php')?>

<?php
   
    $block_id = $_GET['id'];
    
    $query = "SELECT * FROM blocks WHERE id = $block_id";
    $result = mysqli_query($connect, $query);
    $block_info = mysqli_fetch_assoc($result);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<div class="card m-auto mt-5 " style="width: 36rem;">
  <img src=" <?php echo $block_info["resim"]?> " class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $block_info["baslik"] ?></h5>
    <p class="card-text"><?php echo $block_info["acıklama"] ?></p>
  </div>
  <!-- <ul class="list-group list-group-flush">
    <li class="list-group-item">An item</li>
    <li class="list-group-item">A second item</li>
    <li class="list-group-item">A third item</li>
  </ul>
  <div class="card-body">
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div> -->
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>