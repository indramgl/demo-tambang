<!doctype html>
<html lang="<?= esc($locale ?? 'id') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'PT Indah Tambang Raya Semesta') ?> — PT Indah Tambang Raya Semesta</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <?= link_tag('assets/css/main.css') ?>
    [Hreflang tags untuk multilingual]
</head>
<body>
    <?= $this->include('layouts/navbar') ?>
    <main id="content">
        <?= $this->renderSection('content') ?>
    </main>
    <?= $this->include('layouts/footer') ?>
</body>
</html>
