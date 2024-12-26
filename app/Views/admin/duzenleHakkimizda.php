<!DOCTYPE HTML>
<html>
<head>
    <title>Hakkımızda</title>
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
            <li><a href="<?= base_url('admin/duzenleHakkimizda/1') ?>">Hakkımızda</a></li>
        </ul>
    </nav>

        <div id="main">
            <section class="post">
                <header class="major">
                    <h1>Hakkımızda Düzenle</h1>
                </header>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form method="post" action="<?= current_url() ?>" enctype="multipart/form-data">
                    <div class="fields">
                        <div class="field">
                            <label for="baslik">Başlık</label>
                            <input type="text" name="baslik" id="baslik" value="<?= $hakkimizda->baslik ?? '' ?>" required />
                        </div>
                        <div class="field">
                            <label for="icerik">İçerik</label>
                            <textarea name="icerik" id="icerik" rows="6" required><?= $hakkimizda->icerik ?? '' ?></textarea>
                        </div>
                        <div class="field">
                            <label for="resim">Resim Yükle</label>
                            <input type="file" name="resim" id="resim" />
                            <?php if(isset($hakkimizda->resim) && !empty($hakkimizda->resim)): ?>
                                <div class="mt-2">
                                    <img src="<?= base_url('uploads/' . $hakkimizda->resim) ?>" alt="Mevcut Resim" style="max-width: 200px;" />
                                    <p>Mevcut Resim</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <ul class="actions">
                        <li><input type="submit" value="Güncelle" class="primary" /></li>
                        <li><a href="<?= base_url('admin/panel') ?>" class="button">İptal</a></li>
                    </ul>
                </form>
            </section>
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