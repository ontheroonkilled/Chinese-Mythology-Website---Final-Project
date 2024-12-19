<!DOCTYPE HTML>
<html>
<head>
    <title>Konu Düzenle</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">
<div id="wrapper">
    <header id="header">
        <a href="../index.php" class="logo">Admin Panel</a>
    </header>
    <nav id="nav">
        <ul class="links">
            <li><a href="">Konular</a></li>
            <li><a href="">Konu Ekle</a></li>
        </ul>
    </nav>
    <div id="main">
        <section class="post">
            <header class="major">
                <h1>Konu Düzenle</h1>
            </header>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="fields">
                    <div class="field">
                        <label for="baslik">Başlık</label>
                        <input type="text" name="baslik" id="baslik" value="" required />
                    </div>
                    <div class="field">
                        <label for="icerik">İçerik</label>
                        <textarea name="icerik" id="icerik" rows="6" required></textarea>
                    </div>
                    <div class="field">
                        <label for="resim">Resim Yükle</label>
                        <input type="file" name="resim" id="resim" />

                            <img src="" alt="Mevcut Resim" width="100" />
                            <p>Mevcut Resim</p>

                    </div>
                    <input type="hidden" name="id" value="" />
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
<script src="assets/js/main.js"></script>
</body>
</html>
