<!-- vitamin sınıflarını vitamin-demir olarak değiştir -->
<?php
 session_start();
 if (!isset($_SESSION['loggedin'])) {
     header("Location: login.html");
     exit();
 }
?>

 <?php 
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $_POST['baslik'];
    $aciklama = $_POST['aciklama'];
    $resim = $_POST['resim'];
    $sinif = $_POST['sinif'];

    if (!empty($baslik)) {
        // En yüksek position değerini bul
        $query = "SELECT MAX(position) as max_position FROM blocks";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);
        $max_position = $row['max_position'];

        // Yeni bloğa en yüksek position değerinden bir fazlasını atayın
        $new_position = $max_position + 1;

        $stmt = $connect->prepare("INSERT INTO blocks (baslik, aciklama, resim, sinif, position) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $baslik, $aciklama, $resim, $sinif, $new_position);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Block title cannot be empty.";
    }
}

$query = "SELECT * FROM blocks ORDER BY position ASC";
$result = mysqli_query($connect, $query);
$blocks = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<style>
    .block{
    width: 150px;
    height: 150px;
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
    border-radius: 10%;
}
</style>
<body>

<nav>
    <div class="top">
        <label for="searchPad"></label>
        <input id="searchPad" type="text" placeholder="  Search">
        
    </div>

    <div class="menu visually-hidden">
        <ul>
            <li><a href="index.php" id="refreshLink">HEPSİ</a></li>
            <li><a href="#" data-filter="göz-damla">GÖZ-DAMLA</a></li>
            <li><a href="#" data-filter="burun-sprey">BURUN-SPREY</a></li>
            <li><a href="#" data-filter="kan-sulandirici">KAN-SULANDIRICI</a></li>
            <li><a href="#" data-filter="vitamin-demir">VİTAMİN-DEMİR</a></li>
            <li><a href="#" data-filter="prostat">PROSTAT</a></li>
            <li><a href="#" data-filter="kadin-dogum">KADIN-DOĞUM</a></li>
            <li><a href="#" data-filter="tansiyon">TANSİYON</a></li>
            <li><a href="#" data-filter="kolestrol">KOLESTROL</a></li>
            <li><a href="#" data-filter="antibiyotik">ANTİBİYOTİK</a></li>
            <li><a href="#" data-filter="psikiyatri">PSİKİYATRİ</a></li>
            <li><a href="#" data-filter="mide">MİDE</a></li>
            <li><a href="#" data-filter="soguk-alginligi">SOĞUK ALGINLIĞI</a></li>
            <li><a href="#" data-filter="agri-kesici">AĞRI KESİCİ</a></li>
            <li><a href="#" data-filter="kas-gevsetici">KAS GEVŞETİCİ</a></li>
        </ul>
    </div>
    <span class="list-count"></span>
   
        <!-- Button trigger modal -->
   
    <!-- <button type="button" class="btnEkle btn btn-primary m-auto d-flex mt-2"  data-bs-toggle="modal" data-bs-target="#exampleModal">
      Etken madde
    </button> -->
    <div class="d-flex">
        <a class="btn btn-secondary m-auto mt-2" href="index.php">ANASAYFA</a>

    </div>
</nav>

<div class="container mt-2">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-2">
        <form action="" method="POST" class="mb-3">
            <div class="mb-3">
                <label for="sinif" class="form-label">Class</label>
                <select id="sinif" class="form-control" name="sinif">
                    <option value="" disabled selected>Select Class</option>
                    <option value="göz-damla">Göz Damla</option>
                    <option value="burun-sprey">Burun Sprey</option>
                    <option value="kan-sulandirici">Kan Sulandırıcı</option>
                    <option value="vitamin-demir">Vitamin-Demir</option>
                    <option value="prostat">Prostat</option>
                    <option value="kadin-dogum">Kadın Doğum</option>
                    <option value="tansiyon">Tansiyon</option>
                    <option value="kolestrol">Kolestrol</option>
                    <option value="antibiyotik">Antibiyotik</option>
                    <option value="agri-kesici">Ağrı Kesici</option>
                    <option value="soguk-alginligi">Ateş Düşürücü</option>
                    <option value="kas-gevsetici">Kas Gevşetici</option>
                    <option value="mide">Mide</option>
                    <option value="psikiyatri">Psikiyatri</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="baslik" class="form-label">İlaç</label>
                <input type="text" class="form-control" id="baslik" name="baslik" placeholder="parol" required>
            </div>
            <div class="mb-3">
                <label for="aciklama" class="form-label">Etken Madde</label>
                <textarea class="form-control" id="aciklama" name="aciklama" rows="3" placeholder="parasetamol"></textarea>
            </div>
            <div class="mb-3">
                <label for="resim" class="form-label">Resim Linki</label>
                <input type="text" class="form-control" id="resim" name="resim" placeholder="https://www.atabay.com/wp-content/uploads/2020/04/parol-500-3-Kopya-scaled.jpg">
            </div>
            <button type="submit" class="btn btn-primary">Ekle</button>
        </form>
    </div>
  </div>
</div>

<div class="bigBlock row row-cols-12" id="medication-list">
    <?php foreach ($blocks as $block): ?>

        <?php $isHiddenClass = trim($block['baslik']) === '.' ? 'hidden' : ''; ?>

        <div class="block-item col <?php echo $isHiddenClass; ?> " data-id="<?php echo $block['id']; ?>" data-class="<?php echo htmlspecialchars($block['sinif']); ?>" data-description="<?php echo htmlspecialchars($block['aciklama']); ?>" data-position="<?php echo $block['position']; ?>">
    <a href="info.php?id=<?php echo $block['id']; ?>" class="block">
        <?php echo htmlspecialchars($block["aciklama"]); ?>
    </a>
</div>
    <?php endforeach; ?>
    <span class="empty-item">no results</span>
</div>

</div>
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

// ...
document.getElementById('refreshLink').addEventListener('click', function(e) {
            e.preventDefault(); // Varsayılan link davranışını engelle
            location.reload(); // Sayfayı yeniden yükle
        });
    


        $(document).ready(function() {
    var jobCount = $('.bigBlock > .block-item').length;
    $('.list-count').text(jobCount + ' items');

    $("#searchPad").keyup(function() {
        var searchTerm = $("#searchPad").val().toLowerCase();

        $.extend($.expr[':'], {
            'containsi': function(elem, i, match, array) {
                return (elem.textContent || elem.innerText || '').toLowerCase()
                .indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });

        $(".bigBlock > .block-item").each(function() {
            var title = $(this).find('.block').text().toLowerCase();
            var description = $(this).data('description').toLowerCase();

            if (title.indexOf(searchTerm) >= 0 && description.indexOf(searchTerm) >= 0) {
                $(this).find('.block').css('background-color', 'black'); // Both match
            } else if (title.indexOf(searchTerm) >= 0) {
                $(this).find('.block').css('background-color', 'blue'); // Title match
            } else if (description.indexOf(searchTerm) >= 0) {
                $(this).find('.block').css('background-color', 'red'); // Description match
            } else {
                $(this).find('.block').css('background-color', ''); // Reset to default background
            }
        });


        // Sayacı güncelle
        var jobCount = $('.bigBlock > .block-item').filter(function() {
            var title = $(this).find('.block').text().toLowerCase();
            var description = $(this).data('description').toLowerCase();
            return title.indexOf(searchTerm) >= 0 || description.indexOf(searchTerm) >= 0;
        }).length;
        $('.list-count').text(jobCount + ' items');

        if (jobCount == 0) {
            $('.bigBlock').addClass('empty');
        } else {
            $('.bigBlock').removeClass('empty');
        }
    });


    // Filter by class
    $('.menu a').click(function(e) {
        e.preventDefault();
        var filter = $(this).data('filter');

        $('.bigBlock > .block-item').each(function() {
            var itemClass = $(this).data('class');
            if (itemClass === filter) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });

        var jobCount = $('.bigBlock > .block-item:not(.hidden)').length;
        $('.list-count').text(jobCount + ' items');

        if (jobCount == 0) {
            $('.bigBlock').addClass('empty');
        } else {
            $('.bigBlock').removeClass('empty');
        }
    });
});
// ...

$(document).ready(function() {

    var selectedFilter =

    // Filter blocks based on selected filter
    $('[data-filter]').click(function(e) {
        e.preventDefault();
        var filter = $(this).data('filter');
        if (filter) {
            $('.block-item').hide().filter('[data-class="' + filter + '"]').show();
        } else {
            $('.block-item').show();
        }
    });

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

    // Display count of visible blocks
    updateBlockCount();
    $('.block-item').on('filter', function() {
        updateBlockCount();
    });

    function updateBlockCount() {
        var count = $('.block-item:visible').length;
        $('.list-count').text(count + ' items');
    }
});
</script>

</html>
