<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card">
            <div class="page-title section-title">Edition <i class="icon icon-pencil right"></i></div>

            <form action="" method="POST" class="ml-10 mr-10 mb-30" enctype="multipart/form-data">
	            <div class="file-field input-field ">
	                    <span class="btn blue-grey darken-1 waves-effect waves-light col s2 m2 l2" style="display: inline-block;">
	                        <span><i class="icon icon-picture"></i></span>
	                        <input type="file" name="thumb">
	                    </span>
	                    <span class="file-paht-wrapper col s10 l10 m10" style="display: inline-block;" >
	                        <input class="file-path" placeholder="cliquer pour modifier le profile" type="text">
	                    </span>
	                </div>

	                <div class="submit-button">
	                    <button type="submit" class="ng-btn waves-effect waves-light">confirmer&nbsp;<i class="icon icon-send"></i></button>
	                </div>
            </form>

            <form action="" method="POST" class="ml-10 mr-10 mb-30">

                <div class="col l12 m12 s12">
                    <input type="text" id="name" name="name" placeholder="titre" value="<?= $user->name ?>">
                </div>

                <div class="col l6 m6 s12">
                    <input type="text" id="email" name="phone" placeholder="numéro mobile" value="<?= $user->phone ?>">
                </div>

                <div class="col l6 m6 s12">
                    <input type="email" id="email" name="email" placeholder="email" value="<?= $user->email ?>">
                </div>

                <div class="input-field col l12 m12 s12">
                    <textarea id="content" name="bio"><?= $user->bio ?></textarea>
                </div>

                <div class="submit-button">
                    <button type="submit" class="ng-btn waves-effect waves-light">confirmer&nbsp;<i class="icon icon-send"></i></button>
                </div>
            </form>
        </div>
    </section>
</main>

