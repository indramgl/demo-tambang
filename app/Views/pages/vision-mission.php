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

<section class="vision">
    <h2><?= esc($locale) === 'id' ? 'Visi' : 'Vision' ?></h2>
    <p><?= esc($locale) === 'id' ? 'Menjadi perusahaan tambang terkemuka di Indonesia' : 'To be a leading mining company in Indonesia' ?></p>
</section>

<section class="mission">
    <h2><?= esc($locale) === 'id' ? 'Misi' : 'Mission' ?></h2>
    <ol>
        <li><?= esc($locale) === 'id' ? 'Mengelola sumber daya tambang secara berkelanjutan' : 'Manage mining resources sustainably' ?></li>
        <li><?= esc($locale) === 'id' ? 'Meningkatkan kesejahteraan masyarakat sekitar' : 'Improve welfare of surrounding communities' ?></li>
        <li><?= esc($locale) === 'id' ? 'Menerapkan standar keselamatan dan lingkungan terbaik' : 'Apply best safety and environmental standards' ?></li>
    </ol>
</section>

<section class="core-values">
    <h2><?= esc($locale) === 'id' ? 'Nilai Inti' : 'Core Values' ?></h2>
    <div class="grid">
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Integritas' : 'Integrity' ?></h3>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Inovasi' : 'Innovation' ?></h3>
        </div>
        <div class="card">
            <h3><?= esc($locale) === 'id' ? 'Tanggung Jawab' : 'Responsibility' ?></h3>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
