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

<section class="about-company">
    <h2><?= esc($locale) === 'id' ? 'Tentang Kami' : 'About Us' ?></h2>
    <p><?= esc($locale) === 'id' ? 'PT Indah Tambang Raya Semesta adalah perusahaan tambang terpercaya di Indonesia' : 'PT Indah Tambang Raya Semesta is a trusted mining company in Indonesia' ?></p>
</section>

<section class="vision">
    <h2><?= esc($locale) === 'id' ? 'Visi Misi' : 'Vision & Mission' ?></h2>
    <p><?= esc($locale) === 'id' ? 'Menjadi perusahaan tambang terkemuka yang berkelanjutan' : 'To be a leading sustainable mining company' ?></p>
</section>

<section class="core-values">
    <h2><?= esc($locale) === 'id' ? 'Nilai Inti' : 'Core Values' ?></h2>
    <div class="grid">
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Integritas' : 'Integrity' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Kami beroperasi dengan integritas tertinggi' : 'We operate with the highest integrity' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Keberlanjutan' : 'Sustainability' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Kami mengutamakan keberlanjutan lingkungan' : 'We prioritize environmental sustainability' ?></p>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Inovasi' : 'Innovation' ?></h3>
            <p><?= esc($locale) === 'id' ? 'Kami mengadopsi teknologi terkini' : 'We adopt cutting-edge technology' ?></p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
