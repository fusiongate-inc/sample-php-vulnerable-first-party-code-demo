<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<h3>Buy Now</h3>

<?php if ($submitted): ?>
    <p>Item: <?= esc(htmlspecialchars($item, ENT_QUOTES, 'UTF-8')) ?></p>
    <p>Paid: $<?= esc(htmlspecialchars($amount, ENT_QUOTES, 'UTF-8')) ?></p>
<?php else: ?>
    <form method="post" action="<?= current_url() ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="item" value="Bundle Box">
        <input type="hidden" name="amount" value="1.99">
        <button type="submit">Purchase</button>
    </form>
<?php endif; ?>

<?= $this->endSection() ?>