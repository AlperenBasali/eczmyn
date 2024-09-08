<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = $_POST['order'];

    if (!empty($order)) {
        foreach ($order as $position => $id) {
            $stmt = $connect->prepare("UPDATE blocks SET position = ? WHERE id = ?");
            $stmt->bind_param("ii", $position, $id);
            $stmt->execute();
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order is empty.']);
    }
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>



<script>
  $(document).ready(function() {
    // Initialize Sortable
    var medicationList = document.getElementById('medication-list');
    new Sortable(medicationList, {
        animation: 150,
        onEnd: function(evt) {
            var order = [];
            $('.bigBlock > .block-item').each(function() {
                order.push($(this).data('id'));
            });
            console.log('New order:', order);

            // Send new order to the server via AJAX
            $.ajax({
                url: 'update_order.php',
                method: 'POST',
                data: { order: order },
                success: function(response) {
                    console.log('Order updated:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order:', error);
                }
            });
        }
    });
});

</script>