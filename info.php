<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.html");
    exit();
}
?>

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
<style>
 .anasayfa{
  display: flex;
  text-align: center;
  justify-content: center;
  color: black;
  text-decoration: none;
  padding: 1rem;
  font-weight: 900;
  background-color: grey;
 }
</style>
<body>
  <a class="anasayfa" href="index.php">Ana Sayfa</a>
<div class="card m-auto mt-5 " style="width: 36rem;">
  <img src=" <?php echo $block_info["resim"]?> " class="card-img-top" alt="Yüklenemedi">
  <div class="card-body">
    <h5 class="card-title"><?php echo $block_info["baslik"] ?> (<?php echo $block_info["sinif"]?>)</h5>
    <p class="card-text"><?php echo $block_info["aciklama"] ?></p>
    <a href="#" class="btn btn-primary edit-btn">Edit</a>
    <a href="#" class="btn btn-danger delete-btn">Delete</a>
</div>


  
</div>

<<div id="editForm" style="display: none;">
    <form action="update_block.php" method="POST">
        <input type="hidden" name="block_id" value="<?php echo $block_info['id']; ?>">
        <div class="mb-3">
            <label for="editBaslik" class="form-label">Block Title</label>
            <input type="text" class="form-control" id="editBaslik" name="editBaslik" value="<?php echo $block_info['baslik']; ?>">
        </div>
        <div class="mb-3">
            <label for="editAciklama" class="form-label">Description</label>
            <textarea class="form-control" id="editAciklama" name="editAciklama" rows="3"><?php echo $block_info['aciklama']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="editResim" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="editResim" name="editResim" value="<?php echo $block_info['resim']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="button" class="btn btn-secondary cancel-btn">Cancel</button>
    </form>
</div>



</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$(document).ready(function() {
    $('.edit-btn').click(function(e) {
        e.preventDefault();
        $('#editForm').toggle();
    });

    $('.cancel-btn').click(function() {
        $('#editForm').hide();
    });

    $('.delete-btn').click(function(e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this block?")) {
            var block_id = <?php echo $block_info['id']; ?>;

            $.ajax({
                type: 'POST',
                url: 'delete_block.php',
                data: { id: block_id },
                success: function(response) {
                    if (response === 'Success') {
                        // Redirect to another page or refresh current page
                        window.location.href = 'index.php'; // Redirect to home page or any other page
                    } else {
                        alert('Error deleting block: ' + response);
                    }
                }
            });
        }
    });
});
</script>


</html>