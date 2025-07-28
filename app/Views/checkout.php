<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<h3>Buy Now</h3>

<?php if ($submitted): ?>
    <p>Item: <?= esc($item) ?></p>
    <p>Paid: $<?= esc($amount) ?></p>
<?php else: ?>
    <form method="post">
        <input type="hidden" name="item" value="Bundle Box">
        <input type="hidden" name="amount" value="1.99">
        <button type="submit">Purchase</button>
    </form>
<?php endif; ?>

<?= $this->endSection() ?>

