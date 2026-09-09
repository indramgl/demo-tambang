<nav>
    <a href="<?= base_url(esc($locale) . '/') ?>">PT Indah Tambang Raya Semesta</a>
    <ul>
        <li><a href="<?= base_url('id/' . ltrim(service('uri')->getPath(), '/')) ?>" hreflang="id"><?= esc('ID') ?></a></li>
        <li><a href="<?= base_url('en/' . ltrim(service('uri')->getPath(), '/')) ?>" hreflang="en"><?= esc('EN') ?></a></li>
        <li><a href="<?= base_url('zh/' . ltrim(service('uri')->getPath(), '/')) ?>" hreflang="zh"><?= esc('ZH') ?></a></li>
        <li><a href="<?= base_url('fr/' . ltrim(service('uri')->getPath(), '/')) ?>" hreflang="fr"><?= esc('FR') ?></a></li>
        <li><a href="<?= base_url('es/' . ltrim(service('uri')->getPath(), '/')) ?>" hreflang="es"><?= esc('ES') ?></a></li>
        <li><a href="<?= base_url('ja/' . ltrim(service('uri')->getPath(), '/')) ?>" hreflang="ja"><?= esc('JA') ?></a></li>
    </ul>
</nav>
