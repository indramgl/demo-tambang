<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav class="breadcrumb">
    <a href="<?= base_url($locale . '/') ?>"><?= esc($locale) === 'id' ? 'Beranda' : 'Home' ?></a>
    <span>/</span>
    <span><?= esc($title) ?></span>
</nav>

<section class="hero">
    <h1><?= esc($title) ?></h1>
</section>

<section class="services-grid">
    <h2><?= esc($locale) === 'id' ? 'Layanan & Produk' : 'Services & Products' ?></h2>
    <div class="grid">
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Eksplorasi Mineral' : 'Mineral Exploration' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Layanan eksplorasi mineral berkualitas' : 'Quality mineral exploration services' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Penambangan' : 'Mining' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Operasi penambangan yang aman' : 'Safe mining operations' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Pengolahan' : 'Processing' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Pengolahan mineral bernilai tinggi' : 'High-value mineral processing' ?></p>
        </div>
    </div>
</section>

<section class="cta">
    <h2><?= esc($locale) === 'id' ? 'Butuh Layanan Kami?' : 'Need Our Services?' ?></h2>
    <a href="<?= base_url($locale . '/kontak') ?>" class="btn-primary">
        <?= esc($locale) === 'id' ? 'Hubungi Kami' : 'Contact Us' ?>
    </a>
</section>

<?= $this->endSection() ?>
