<?php if ($flashMessageManager->has()) : ?>
    <?php foreach ($flashMessageManager->get() as $type => $message) : ?>
    <audio src="/sounds/flash_message.ogg" autoplay></audio>
        <script>
            var message = "<?php echo $message ?>";
            var type = "<?php echo $type ?>";
            Materialize.toast(message, 5000, type);
        </script>
    <?php endforeach; ?>
<?php endif; ?>
