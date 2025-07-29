<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<?php
// Sanitize user input to prevent XSS attacks
$sanitizedText = htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
?>

<h3>Feedback</h3>

<form method="post">
    <input type="text" name="userInput" placeholder="Say something..." required>
    <button type="submit">Send</button>
</form>

<?php if ($sanitizedText): ?>
    <p>Response: <?= $sanitizedText ?></p>
<?php endif; ?>

<?= $this->endSection() ?>