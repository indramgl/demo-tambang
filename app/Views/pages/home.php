<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero">
    <h1><?= esc($title) ?></h1>
    <p><?= esc($locale) === 'id' ? 'Selamat datang di PT Indah Tambang Raya Semesta' : 'Welcome to PT Indah Tambang Raya Semesta' ?></p>
</section>

<section class="about">
    <h2><?= esc($locale) === 'id' ? 'Tentang Kami' : 'About Us' ?></h2>
    <p><?= esc($locale) === 'id' ? 'Perusahaan tambang terpercaya di Indonesia' : 'A trusted mining company in Indonesia' ?></p>
</section>

<section class="services-grid">
    <h2><?= esc($locale) === 'id' ? 'Layanan' : 'Services' ?></h2>
    <div class="grid">
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Eksplorasi' : 'Exploration' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Layanan eksplorasi mineral' : 'Mineral exploration services' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Produksi' : 'Production' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Layanan produksi tambang' : 'Mining production services' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Pengolahan' : 'Processing' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Layanan pengolahan mineral' : 'Mineral processing services' ?></p>
        </div>
    </div>
</section>

<section class="cta">
    <h2><?= esc($locale) === 'id' ? 'Hubungi Kami' : 'Contact Us' ?></h2>
    <a href="<?= base_url($locale . '/kontak') ?>" class="btn-primary">
        <?= esc($locale) === 'id' ? 'Hubungi Kami' : 'Get In Touch' ?>
    </a>
</section>

<?= $this->endSection() ?>
