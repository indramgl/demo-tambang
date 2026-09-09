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

<section class="timeline">
    <h2><?= esc($locale) === 'id' ? 'Perjalanan Perusahaan' : 'Company Journey' ?></h2>
    <div class="timeline-item">
        <h3><?= esc($locale) === 'id' ? 'Didirikan' : 'Founded' ?></h3>
        <p><?= esc($locale) === 'id' ? 'Awal mula perjalanan perusahaan' : 'The beginning of the company journey' ?></p>
    </div>
    <div class="timeline-item">
        <h3><?= esc($locale) === 'id' ? 'Perkembangan' : 'Growth' ?></h3>
        <p><?= esc($locale) === 'id' ? 'Tahap-tahap pertumbuhan perusahaan' : 'Stages of company growth' ?></p>
    </div>
</section>

<section class="stats">
    <h2><?= esc($locale) === 'id' ? 'Statistik Kunci' : 'Key Statistics' ?></h2>
    <div class="stat">
        <span class="stat-number"><?= esc($locale) === 'id' ? '2005' : '2005' ?></span>
        <span class="stat-label"><?= esc($locale) === 'id' ? 'Tahun Berdiri' : 'Year Founded' ?></span>
    </div>
</section>

<?= $this->endSection() ?>
