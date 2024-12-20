<?php
require_once APPPATH . 'Config/mongodb.php';

$mongodb = \Config\MongoDB_Connection::getInstance();
$topics = $mongodb->find('topics');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Panel</title>
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
                <h1>Konular</h1>
            </header>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Başlık</th>
                    <th>İçerik</th>
                    <th>Resim</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($topics as $topic): 
                        $resimYolu = property_exists($topic, 'resim') && $topic->resim ? base_url('uploads/' . $topic->resim) : base_url('assets/images/default.jpg');
                        $baslik_url = $mongodb->createSlug($topic->baslik);
                    ?>
                        <tr>
                            <td><?= $topic->_id ?></td>
                            <td><?= $topic->baslik ?></td>
                            <td><?= substr($topic->icerik, 0, 100) ?>...</td>
                            <td>
                                <?php if(property_exists($topic, 'resim') && $topic->resim): ?>
                                    <img src="<?= $resimYolu ?>" alt="<?= $topic->baslik ?>" style="max-width: 100px;">
                                <?php else: ?>
                                    <span>Resim yok</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/duzenle/'.$topic->_id) ?>" class="button small">Düzenle</a>
                                <a href="<?= base_url('admin/sil/'.$topic->_id) ?>" class="button small" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
