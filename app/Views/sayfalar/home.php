<?php
require_once APPPATH . 'Config/mongodb.php';
?>
<div id="main">
    <section class="posts">
        <?php 
        if(isset($topics)):
            foreach($topics as $topic): 
                $baslik_url = \Config\MongoDB_Connection::getInstance()->createSlug($topic->baslik);
                $resimYolu = property_exists($topic, 'resim') && $topic->resim ? base_url('uploads/' . $topic->resim) : base_url('assets/images/default.jpg');
            ?>
                <article>
                    <header>
                        <span class="date"><?= date('Y-m-d', strtotime($topic->zaman ?? 'now')) ?></span>
                        <h2><a href="<?= base_url('detay/'.$baslik_url) ?>"><?= $topic->baslik ?></a></h2>
                    </header>
                    <a href="<?= base_url('detay/'.$baslik_url) ?>" class="image fit">
                        <img src="<?= $resimYolu ?>" alt="<?= $topic->baslik ?>" />
                    </a>
                    <p><?= substr($topic->icerik, 0, 300) ?>...</p>
                    <ul class="actions special">
                        <li><a href="<?= base_url('detay/'.$baslik_url) ?>" class="button">Devamını Oku</a></li>
                    </ul>
                </article>
            <?php 
            endforeach;
        else:
            echo "<p>Veri bulunamadı</p>";
        endif;
        ?>
    </section>

    <!-- Footer -->
    <footer>
        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="<?= base_url('?sayfa=1') ?>" class="first">Baş</a>
                <a href="<?= base_url('?sayfa='.($current_page - 1)) ?>" class="previous">Önceki</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $current_page): ?>
                    <a href="<?= base_url('?sayfa='.$i) ?>" class="page active"><?= $i ?></a>
                <?php else: ?>
                    <a href="<?= base_url('?sayfa='.$i) ?>" class="page"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="<?= base_url('?sayfa='.($current_page + 1)) ?>" class="next">Sonraki</a>
                <a href="<?= base_url('?sayfa='.$total_pages) ?>" class="last">Son</a>
            <?php endif; ?>
        </div>
    </footer>
</div>