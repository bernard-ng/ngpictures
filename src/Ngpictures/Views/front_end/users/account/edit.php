<main class="container row">
    <?php include(APP . "/Views/includes/left-aside.twig"); ?>
    <section class="col l9 m12 s12">
        <div class="card col l12 m12 s12">
            <div class="page-title section-title">Edition <i class="icon icon-pencil right"></i></div>

            <form action="" method="POST" class="ml-10 mr-10 mb-30" enctype="multipart/form-data">
                <div class="file-field input-field ">
                        <span class="btn blue-grey darken-1 waves-effect waves-light col s4 m4 l4" style="display: inline-block;">
                            <span><i class="icon icon-picture"></i></span>
                            <input type="file" name="thumb">
                        </span>
                        <span class="file-paht-wrapper col s8 l8 m8" style="display: inline-block;" >
                            <input class="file-path" placeholder="cliquer pour modifier le profile" type="text">
                        </span>
                    </div>

                    <div class="submit-button">
                        <button type="submit" class="link-btn feed-btn waves-effect waves-light primary-b">confirmer</i></button>
                    </div>
            </form>

            <form action="" method="POST" class="ml-10 mr-10 mt-30">

                <div class="default-form  col l12 m12 s12">
                    <label for="name">Pseudo</label>
                    <input type="text" id="name" name="name" placeholder="titre" value="<?= $user->name ?>">
                </div>

                <div class="default-form col  l6 m6 s12">
                    <label for="phone">Mobile</label>
                    <input type="tel" id="phone" name="phone" placeholder="numéro mobile" value="<?= $user->phone ?>">
                </div>

                <div class="default-form  col l6 m6 s12">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email" value="<?= $user->email ?>">
                </div>

                <div class="default-form  col l12 m12 s12">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio"><?= $user->bio ?></textarea>
                </div>

                <div class="submit-button mb-30">
                    <button type="submit" class="link-btn feed-btn waves-effect waves-light primary-b">confirmer</i></button>
                </div>
            </form>
        </div>
    </section>
</main>
