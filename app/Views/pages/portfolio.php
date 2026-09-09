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

<section class="portfolio-filter">
    <h2><?= esc($locale) === 'id' ? 'Proyek Terpilih' : 'Selected Projects' ?></h2>
    <div class="grid">
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Proyek A' : 'Project A' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Deskripsi proyek A' : 'Project A description' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Proyek B' : 'Project B' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Deskripsi proyek B' : 'Project B description' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Proyek C' : 'Project C' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Deskripsi proyek C' : 'Project C description' ?></p>
        </div>
    </div>
</section>

<section class="cta">
    <h2><?= esc($locale) === 'id' ? 'Lihat Proyek Lain' : 'View More Projects' ?></h2>
    <a href="<?= base_url($locale . '/kontak') ?>" class="btn-primary">
        <?= esc($locale) === 'id' ? 'Hubungi Kami' : 'Contact Us' ?>
    </a>
</section>

<?= $this->endSection() ?>
