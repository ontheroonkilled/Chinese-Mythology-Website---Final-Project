<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <base href="<?= base_url() ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />
    <noscript><link rel="stylesheet" href="<?= base_url('assets/css/noscript.css') ?>" /></noscript>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <a href="<?= base_url() ?>" class="logo">Admin Login</a>
    </header>

    <!-- Main -->
    <div id="main">
        <!-- Post -->
        <section class="post">
            <header class="major">
                <h2>Admin Girişi</h2>
            </header>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <!-- Login Form -->
            <form method="post" action="<?= base_url('admin/login') ?>">
                <div class="row gtr-uniform">
                    <div class="col-12">
                        <label for="kullanici_adi">Kullanıcı Adı</label>
                        <input type="text" name="kullanici_adi" id="kullanici_adi" value="yonetici" required />
                    </div>
                    <div class="col-12">
                        <label for="sifre">Şifre</label>
                        <input type="password" name="sifre" id="sifre" value="123" required />
                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" value="Giriş Yap" class="primary" /></li>
                        </ul>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <!-- Footer -->
    <div id="copyright">
        <ul><li>Çin Mitolojisi &copy; 2024</li><li>Design: <a>Berat Beşgül</a></li></ul>
    </div>

</div>

<!-- Scripts -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.scrollex.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.scrolly.min.js') ?>"></script>
<script src="<?= base_url('assets/js/browser.min.js') ?>"></script>
<script src="<?= base_url('assets/js/breakpoints.min.js') ?>"></script>
<script src="<?= base_url('assets/js/util.js') ?>"></script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>

</body>
</html>
