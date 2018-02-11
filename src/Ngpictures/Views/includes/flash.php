<?php if ($flashMessageManager->has()) : ?>
    <div class="flash" id="flash">
        <?php foreach ($flashMessageManager->get() as $type => $message) : ?>
                <div class="flash-content" >
                    <i class="icon icon-close flash-close-icon"></i>
                    <span class="flash-content-icon-<?= $type ?>"><i class="icon icon-info-sign"></i></span>
                    <span class="flash-content-message"><?= $message ?></span>
                </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
