<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block_id = $_POST['id'];

    $stmt = $connect->prepare("DELETE FROM blocks WHERE id = ?");
    $stmt->bind_param("i", $block_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
