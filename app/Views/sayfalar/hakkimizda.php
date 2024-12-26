<?= $this->include('tema/header') ?>

<div id="main">
    <?php if(isset($hakkimizda)): 
        $resimYolu = property_exists($hakkimizda, 'resim') && $hakkimizda->resim ? base_url('uploads/' . $hakkimizda->resim) : base_url('assets/images/default.jpg');
    ?>
        <section class="post">
            <header class="major">
                <h2><?= $hakkimizda->baslik ?></h2>
            </header>
            <div class="image main">
                <img src="<?= $resimYolu ?>" alt="<?= $hakkimizda->baslik ?>" />
            </div>
            <?= $hakkimizda->icerik ?>
        </section>
    <?php else: ?>
        <p>İçerik bulunamadı.</p>
    <?php endif; ?>
</div>

<?= $this->include('tema/footer') ?>