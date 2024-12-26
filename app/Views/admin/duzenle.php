<?php
if (!isset($topic)) {
    echo "Konu bulunamadı.";
    return;
}

$resimYolu = property_exists($topic, 'resim') && $topic->resim ? base_url('uploads/' . $topic->resim) : base_url('assets/images/default.jpg');
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
        <a href="<?= base_url('admin') ?>" class="logo">Admin Panel</a>
    </header>

    <div id="main">
        <section>
            <h2>Konu Düzenle</h2>
            <form method="post" action="<?= current_url() ?>" enctype="multipart/form-data">
                <div class="row gtr-uniform">
                    <div class="col-12">
                        <label for="baslik">Başlık</label>
                        <input type="text" name="baslik" id="baslik" value="<?= $topic->baslik ?>" required />
                    </div>
                    <div class="col-12">
                        <label for="icerik">İçerik</label>
                        <textarea name="icerik" id="icerik" rows="6" required><?= $topic->icerik ?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="resim">Resim</label>
                        <?php if(property_exists($topic, 'resim') && $topic->resim): ?>
                            <img src="<?= $resimYolu ?>" alt="Mevcut Resim" style="max-width: 200px; margin-bottom: 10px;">
                            <br>
                        <?php endif; ?>
                        <input type="file" name="resim" id="resim" accept="image/*">
                        <small>Yeni resim seçmezseniz mevcut resim korunacaktır.</small>
                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" name="duzenle" value="Kaydet" class="primary" /></li>
                            <li><a href="<?= base_url('admin') ?>" class="button">İptal</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<div id="copyright">
        <ul><li>Çin Mitolojisi &copy; <?= date('Y') ?></li><li>Design: <a href="https://github.com/ontheroonkilled">Berat Beşgül</a></li></ul>
    </div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#icerik'), {
            toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
            language: 'tr'
        })
        .catch(error => {
            console.error(error);
        });
</script>

</body>
</html>
