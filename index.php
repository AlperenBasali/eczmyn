<?php   require_once('config.php')?>

<?php 

    $query = "SELECT * from blocks";
    $result = mysqli_query($connect, $query);

    $blocks = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

<!-- ADMİN PANEL EKLENECEK -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    
    .top{
        display: flex;
        margin: auto;
        justify-content: center;
    }
    .bigBlock{
        display: flex;
    }
    
    .block{
        width: 75px;
        height: 75px;
        background-color: black;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: .3rem;
        padding: .2rem;
        word-break: break-all;
        text-decoration: none;
        cursor: pointer;
    }
    input{
        width: 300px;
        height: 50px;
        font-size: 100%;
        
    }
    .topBtn{
        cursor: pointer;
    }
    
</style>
<body>

<nav>
    <div class="top">
    <input id="searchPad" type="text" placeholder="  Search" >
    <button class="topBtn">Click</button>
</div>
</nav>
    <div class="bigBlock mt-2">
        <?php foreach($blocks as $block):?>
        <a href="info.php?id=<?php echo $block['id']; ?>" class="block"><?php echo $block["baslik"] ?></a>
       
        <?php endforeach; ?>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    const searchPad = document.querySelector("#searchPad")
   const block = document.querySelectorAll(".block")
   block.forEach(e => {
        console.log(e.innerHTML)
        console.log(searchPad.value)
        if(e.innerHTML.toLowerCase()== searchPad.value.toLowerCase()){
            console.log("vayyyy")
            e.style.backgroundColor = "red"; 
        }
        else{
            console.log("D:")
        }
        
        
   });

   let topBtn = document.querySelector(".topBtn")
   topBtn.addEventListener("click", function(){
    location.reload()
   })
   
   searchPad.addEventListener("keydown",function(a){
    if(a.keyCode === 13){
        location.reload()
    }

   })
    
</script>
<script>

   

</script>
</body>
</html>