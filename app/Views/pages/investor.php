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

<section class="documents">
    <h2><?= esc($locale) === 'id' ? 'Dokumen Investor' : 'Investor Documents' ?></h2>
    <div class="table">
        <div class="table-row">
            <span><?= esc($locale) === 'id' ? 'Laporan Keuangan' : 'Financial Report' ?></span>
            <span>PDF</span>
        </div>
        <div class="table-row">
            <span><?= esc($locale) === 'id' ? 'Pengumuman' : 'Announcements' ?></span>
            <span>PDF</span>
        </div>
        <div class="table-row">
            <span><?= esc($locale) === 'id' ? 'Prospektus' : 'Prospectus' ?></span>
            <span>PDF</span>
        </div>
    </div>
</section>

<section class="cta">
    <h2><?= esc($locale) === 'id' ? 'Hubungi Investor Relations' : 'Contact Investor Relations' ?></h2>
    <a href="<?= base_url($locale . '/kontak') ?>" class="btn-primary">
        <?= esc($locale) === 'id' ? 'Hubungi Kami' : 'Get In Touch' ?>
    </a>
</section>

<?= $this->endSection() ?>
