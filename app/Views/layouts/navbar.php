<nav>
    <a href="<?= base_url(esc($locale) . '/') ?>">PT Indah Tambang Raya Semesta</a>
    <ul>
        <?php foreach ($localeUrls as $lang => $url): ?>
            <li><a href="<?= esc($url) ?>" hreflang="<?= esc($lang) ?>"><?= esc($lang) ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>
