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

<section class="contact-grid">
    <div class="contact-form">
        <h2><?= esc($locale) === 'id' ? 'Kirim Pesan' : 'Send a Message' ?></h2>
        <form>
            <div class="form-group">
                <label for="name"><?= esc($locale) === 'id' ? 'Nama' : 'Name' ?></label>
                <input type="text" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="email"><?= esc($locale) === 'id' ? 'Email' : 'Email' ?></label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="message"><?= esc($locale) === 'id' ? 'Pesan' : 'Message' ?></label>
                <textarea id="message" name="message"></textarea>
            </div>
            <button type="submit" class="btn-primary">
                <?= esc($locale) === 'id' ? 'Kirim' : 'Send' ?>
            </button>
        </form>
    </div>
    <div class="contact-info">
        <h2><?= esc($locale) === 'id' ? 'Informasi Kontak' : 'Contact Information' ?></h2>
        <p><?= esc($locale) === 'id' ? 'PT Indah Tambang Raya Semesta' : 'PT Indah Tambang Raya Semesta' ?></p>
        <p><?= esc($locale) === 'id' ? 'Jl. Contoh No. 123, Jakarta' : 'Jl. Example No. 123, Jakarta' ?></p>
        <p>Email: contact@ptindah.com</p>
        <p>Phone: +62 21 1234 5678</p>
    </div>
</section>

<?= $this->endSection() ?>
