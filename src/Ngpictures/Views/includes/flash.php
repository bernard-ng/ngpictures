<?php if ($flashMessageManager->has()) : ?>
    <?php foreach ($flashMessageManager->get() as $type => $message) : ?>
    <audio autoplay>
    	 <source src="/sounds/flash-message.m4r" type="audio/m4r; codecs=opus"/>
		 <source src="/sounds/flash-message.ogg" type="audio/ogg; codecs=vorbis"/>
		 <source src="/sounds/flash-message.mp3" type="audio/mpeg"/>
    </audio>
        <script>
            var message = "<?php echo $message ?>";
            var type = "<?php echo $type ?>";
            Materialize.toast(message, 5000, type);
        </script>
    <?php endforeach; ?>
<?php endif; ?>
