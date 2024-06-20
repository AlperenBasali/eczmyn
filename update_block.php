<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block_id = $_POST['block_id'];
    $editBaslik = $_POST['editBaslik'];
    $editAciklama = $_POST['editAciklama'];
    $editResim = $_POST['editResim'];

    $stmt = $connect->prepare("UPDATE blocks SET baslik = ?, aciklama = ?, resim = ? WHERE id = ?");
    $stmt->bind_param("sssi", $editBaslik, $editAciklama, $editResim, $block_id);

    if ($stmt->execute()) {
        // Redirect back to the block display page with the updated information
        header("Location: info.php?id=" . $block_id);
        exit();
    } else {
        echo "Error updating block: " . $stmt->error;
    }
}
?>
