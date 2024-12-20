<?php
require_once __DIR__ . '/../../config/mongodb.php';

$mongodb = MongoDB_Connection::getInstance();

// ID'ye göre konu bilgilerini getir
$id = $_GET['id'] ?? null;
if($id) {
    $topic = $mongodb->findOne('topics', ['_id' => new MongoDB\BSON\ObjectId($id)]);
}

if(isset($_POST['guncelle'])) {
    $baslik = $_POST['baslik'];
    $icerik = $_POST['icerik'];
    $id = $_POST['id'];
    
    $updateData = [
        'baslik' => $baslik,
        'icerik' => $icerik
    ];
    
    // Resim yükleme işlemi
    if(isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
        $uploadDir = FCPATH . 'uploads/';
        
        // Uploads klasörü yoksa oluştur
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $resim = uniqid() . '_' . basename($_FILES['resim']['name']);
        $uploadFile = $uploadDir . $resim;
        
        if (move_uploaded_file($_FILES['resim']['tmp_name'], $uploadFile)) {
            $updateData['resim'] = $resim;
        }
    }
    
    // MongoDB'de güncelleme
    $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
    $result = $mongodb->update('topics', $filter, $updateData);
    
    if($result->getModifiedCount() > 0) {
        header('Location: ' . base_url('admin/panel'));
        exit;
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Konu Düzenle</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <base href="<?= base_url() ?>">
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
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
        </ul>
    </nav>
    <div id="main">
        <section class="post">
            <header class="major">
                <h1>Konu Düzenle</h1>
            </header>
            <form method="post" action="<?= base_url('admin/duzenle') ?>" enctype="multipart/form-data">
                <div class="fields">
                    <div class="field">
                        <label for="baslik">Başlık</label>
                        <input type="text" name="baslik" id="baslik" value="<?= $topic->baslik ?? '' ?>" required />
                    </div>
                    <div class="field">
                        <label for="icerik">İçerik</label>
                        <textarea name="icerik" id="icerik" rows="6" required><?= $topic->icerik ?? '' ?></textarea>
                    </div>
                    <div class="field">
                        <label for="resim">Resim Yükle</label>
                        <input type="file" name="resim" id="resim" />
                        <?php if(isset($topic->resim) && !empty($topic->resim)): ?>
                            <img src="<?= base_url('uploads/' . $topic->resim) ?>" alt="Mevcut Resim" width="100" />
                            <p>Mevcut Resim</p>
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="id" value="<?= $id ?? '' ?>" />
                </div>
                <ul class="actions">
                    <li><input type="submit" name="guncelle" value="Güncelle" /></li>
                </ul>
            </form>
        </section>
    </div>
    <div id="copyright">
        <ul><li>Çin Mitolojisi &copy; 2024</li><li>Design: <a>Berat Beşgül</a></li></ul>
    </div>
</div>
<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
