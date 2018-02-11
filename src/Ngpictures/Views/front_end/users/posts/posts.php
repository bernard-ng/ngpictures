<?php
use Ng\Core\Managers\SessionManager;

?>
<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <main class="col s12 m12 l9">
        <div class="card-panel">
            <div class="section-title mb-20 mt-20 ml-10">
                <i class="icon icon-pencil"></i>&nbsp;Mes publications
                <span class="btn primary-b right"><?= count($articles) ?></span>
            </div>
            <table class="card responsive-table bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>action</th>
                        <th>date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($articles)) : ?>
                    <?php foreach ($articles as $a) : ?>
                        <tr>
                            <td><b><?= $a->id ?></b></td>
                            <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= "/account/post/delete/".SessionManager::getInstance()->read(TOKEN_KEY) ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" id="delete">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <a href=<?= "/account/post/edit/{$a->id}/".SessionManager::getInstance()->read(TOKEN_KEY) ?>>
                                    <button class="btn btn-small waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>

                            </td>
                            <td><time><?= $a->time ?></time></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td><b>0</b></td>
                        <td>Aucun article</td>
                        <td>
                            <button type="submit" class="btn btn-small waves-effect waves-light disabled">
                                <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>  
    </main>
</section>
