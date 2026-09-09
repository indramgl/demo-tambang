<!doctype html>
<html lang="<?= esc($locale) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> — PT Indah Tambang Raya Semesta</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <?php foreach (['id', 'en', 'zh', 'fr', 'es', 'ja'] as $lang): ?>
        <link rel="alternate" hreflang="<?= esc($lang) ?>" href="<?= base_url($lang . '/' . ltrim(service('uri')->getPath(), '/')) ?>" />
    <?php endforeach; ?>
</head>
<body>
    <?= $this->include('layouts/navbar') ?>
    <main id="content">
        <?= $content ?>
    </main>
    <?= $this->include('layouts/footer') ?>
</body>
</html>
