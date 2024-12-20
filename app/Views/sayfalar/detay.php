<div id="main">
    <?php if(isset($topic)): 
        $resimYolu = property_exists($topic, 'resim') && $topic->resim ? base_url('uploads/' . $topic->resim) : base_url('assets/images/default.jpg');
    ?>
        <section class="post">
            <header class="major">
                <h2><?= $topic->baslik ?></h2>
            </header>
            <div class="image main">
                <img src="<?= $resimYolu ?>" alt="<?= $topic->baslik ?>" />
            </div>
            <p><?= $topic->icerik ?></p>
        </section>
    <?php else: ?>
        <p>İçerik bulunamadı.</p>
    <?php endif; ?>
</div>
