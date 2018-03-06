<div class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <div class="col l9 s12 m12">
        <nav class="nav z-depth-2" style="margin-bottom: -5px;">
            <div class="nav-wrapper">
                <ul>
                    <li><a href="<?= ADMIN."/logs/delete" ?>">Supprimer</a></li>
                    <li class="right"><a href="<?= ADMIN."/logs/send"  ?>">Récevoir en mail</a></li>
                </ul>
            </div>
        </nav>
        <div class="card col s12">
            <?php echo nl2br($logs); ?>
        </div>
    </div>
</div>
