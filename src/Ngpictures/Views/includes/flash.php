<?php if ($flashMessageManager->has()) : ?>
    <?php foreach ($flashMessageManager->get() as $type => $message) : ?>
        <script>
            var message = "<?php echo $message ?>";
            var type = "<?php echo $type ?>";
            Materialize.toast(message, 5000, type);
        </script>
    <?php endforeach; ?>
<?php endif; ?>
