<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<h3>Feedback</h3>

<form method="get">
    <input type="text" name="text" placeholder="Say something...">
    <button type="submit">Send</button>
</form>

<?php if ($text): ?>
    <p>Response: <?= $text ?></p> <!-- No sanitization -->
<?php endif; ?>

<?= $this->endSection() ?>

