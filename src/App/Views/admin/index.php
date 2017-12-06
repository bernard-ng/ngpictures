<div class="container row">
<?php include(APP."/Views/includes/right-aside.php"); ?>

<div class="card col l11 m12">
    <div class="section-title mb-20 mt-20 ml-10">
        <i class="icon icon-pencil"></i>&nbsp;Les Derniers Articles
        <span class="badge new"><?= $nb_article ?></span>
    </div>
    <div class="col l6 mb-30 z-depth-2">
        <table class="responsive-table bordered striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $a) : ?>
                    <tr>
                        <td><b><?= $a->id ?></b></td>
                        <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                        <td>
                            <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                <input type="hidden" name="id" value="<?= $a->id?>" >
                                <input type="hidden" name="type" value="1" >
                                <button type="submit" class="btn btn-small waves-effect waves-light red">
                                    <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td><b>0</b></td>
                    <td>Aucun article pour l'instant</td>
                    <td>
                        <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                            <input type="hidden" name="id" value="0" >
                            <input type="hidden" name="type" value="1" >
                            <button type="submit" class="btn btn-small waves-effect waves-light red">
                                <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="card-action">
            <b>Users posts</b> <a href="<?= ADMIN."/articles" ?>" class="right">see all</a>
        </div>
    </div>

    <div class="col l6 z-depth-2 mb-10">
        <table class="responsive-table bordered striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($blog as $b) : ?>
                <tr>
                    <td><b><?= $b->id ?></b></td>
                    <td><a href="<?= $b->url ?>"><?= $b->title ?></a></td>
                    <td>
                        <form method="POST" action="<?= ADMIN."/delete"  ?>" style="display: inline-block !important;">
                            <input type="hidden" name="id" value="<?= $b->id?>" >
                            <input type="hidden" name="type" value="3" >
                            <button type="submit" class="btn btn-small waves-effect waves-light red">
                                <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                            </button>
                        </form>
                       
                        <a href="<?= ADMIN."/blog/edit/{$b->id}" ?>">
                             <button class="btn btn-small waves-effect waves-light">
                                <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="card-action">
            <b>Sites posts</b> <a href="<?= ADMIN."/blog" ?>" class="right">see all</a>
        </div>
    </div>
</div>

<div class="card col l12 m12">
    <div class="section-title mb-10 mt-20 ml-10">
        <i class="icon icon-plus"></i>&nbsp;Ajouter au site</div>
    <div class=" ml-30 mb-30">
        <div class="col l3 m3 s12 mb-20">
            <button class="ng-btn" style="display: inline;">
                <a href="<?= ADMIN."/blog/add"  ?>" style="color:#fff !important;">Nouvel Article</a>
            </button>
        </div>
        <div class="col l3 m3 s12 mb-20">
            <button class="ng-btn" style="display: inline;">
                <a href="<?= ADMIN."/nggalery/post" ?>" style="color:#fff !important;">Nouvel Photo</a>
            </button>
        </div>
        
        <div class="col l3 m3 s12 mb-20">
            <button class="ng-btn" style="display: inline;">
                <a href="<?= ADMIN."/godfirst/post" ?>" style="color:#fff !important;">Nouveau Verset</a>
            </button>
        </div>
        
        <div class="col l3 m3 s12 mb-20">
            <button class="ng-btn" style="display: inline;">
                <a href="<?= ADMIN."/event/post" ?>" style="color:#fff !important;">Nouvel Event</a>
            </button>
        </div>
    </div>
</div>


<div class="card col l9 m12">
    <div class="section-title mb-20 mt-20 ml-10">
        <i class="icon icon-stats"></i>&nbsp;Statistiques
    </div>

    <div id="stat" class="col l6 m12 s12 statistic"></div>
    <div id="stat2" class="col l6 m12 s12 statistic"></div>


    <div class="card horizontal  col l4 m4 s12">
        <span class="card-title"><i class="icon icon-user"></i> Users</span>
        <div class="card-stacked">
            <div class="card-content" style="font-size: 1.5em;">
                <center><?= $nb_users ?></center>
            </div>
        </div>
    </div>

    <div class="card horizontal  col l4 m4 s12">
        <span class="card-title"><i class="icon icon-pencil"></i> Posts</span>
        <div class="card-stacked">
            <div class="card-content" style="font-size: 1.5em;">
                <center><?= $nb_article ?></center>
            </div>
        </div>
    </div>

    <div class="card horizontal  col l4 m4 s12">
        <span class="card-title"><i class="icon icon-picture"></i> Pictures</span>
        <div class="card-stacked">
            <div class="card-content" style="font-size: 1.5em;">
                <center>not ready</center>
            </div>
        </div>
    </div>
</div>


<?php include(APP."/Views/includes/left-aside.php"); ?>





</div>

