<?php
require_once APPPATH . 'Config/mongodb.php';
$mongodb = \Config\MongoDB_Connection::getInstance();

if(isset($_POST['ekle'])) {
    $baslik = $_POST['baslik'];
    $icerik = $_POST['icerik'];
    $zaman = date('Y-m-d H:i:s');
    
    // Resim yükleme işlemi
    $resim = null;
    if(isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
        $uploadDir = FCPATH . 'uploads/';
        
        // Uploads klasörü yoksa oluştur
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $resim = uniqid() . '_' . basename($_FILES['resim']['name']);
        $uploadFile = $uploadDir . $resim;
        
        if (move_uploaded_file($_FILES['resim']['tmp_name'], $uploadFile)) {
            // Resim başarıyla yüklendi
        } else {
            echo "Resim yüklenirken bir hata oluştu.";
            $resim = null;
        }
    }
    
    // Konuyu veritabanına ekle
    $konu = [
        'baslik' => $baslik,
        'icerik' => $icerik,
        'zaman' => $zaman
    ];
    
    // Eğer resim yüklendiyse, resim adını da ekle
    if ($resim !== null) {
        $konu['resim'] = $resim;
    }
    
    if ($mongodb->insert('topics', $konu)) {
        header('Location: ' . base_url('admin/panel'));
        exit;
    } else {
        echo "Konu eklenirken bir hata oluştu.";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Konu Ekle</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <base href="<?= base_url() ?>">
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>
<body class="is-preload">
<div id="wrapper">
    <header id="header">
        <a href="<?= base_url() ?>" class="logo">Admin Panel</a>
    </header>
    <nav id="nav">
        <ul class="links">
            <li><a href="<?= base_url('admin/panel') ?>">Konular</a></li>
            <li><a href="<?= base_url('admin/ekle') ?>">Konu Ekle</a></li>
            <li><a href="<?= base_url('admin/duzenleHakkimizda/1') ?>">Hakkımızda</a></li>
        </ul>
    </nav>
    <div id="main">
        <section class="post">
            <header class="major">
                <h1>Konu Ekleme</h1>
            </header>
            <form method="post" action="<?= current_url() ?>" enctype="multipart/form-data">
                <div class="fields">
                    <div class="field">
                        <label for="baslik">Başlık</label>
                        <input type="text" name="baslik" id="baslik" required />
                    </div>
                    <div class="field">
                        <label for="icerik">İçerik</label>
                        <textarea name="icerik" id="icerik" rows="6" required></textarea>
                    </div>
                    <div class="field">
                        <label for="resim">Resim Yükle</label>
                        <input type="file" name="resim" id="resim" />
                    </div>
                </div>
                <ul class="actions">
                    <li><input type="submit" name="ekle" value="Ekle" /></li>
                </ul>
            </form>
        </section>
    </div>
    <div id="copyright">
        <ul><li>Çin Mitolojisi &copy; <?= date('Y') ?></li><li>Design: <a href="https://github.com/ontheroonkilled">Berat Beşgül</a></li></ul>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#icerik').summernote({
            placeholder: 'İçerik yazın...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']]
            ],
            lang: 'tr-TR'
        });
    });
</script>
</body>
</html>
