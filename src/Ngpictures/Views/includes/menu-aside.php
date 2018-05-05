<div class="jumbotron dark row col l3 s12 m12 animated fast slideInRight">
        <ul class="collection dark outlined" data-collapsible="accordion">
            <?php if (isset($verse) && !empty($verse)) : ?>
                <li>
                    <div class="collapsible-header">God First</div>
                    <div class="collapsible-body">
                        <?= $verse->text; ?>
                        <br><br>
                        <?= $verse->ref; ?>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (isset($categories) && !empty($categories)) : ?>
                <li>
                    <div class="collapsible-header">Catégories</div>
                    <div class="collapsible-body">
                        <div class="ui list">
                            <?php foreach ($categories as $category) : ?>
                            <div class="item">
                                <i class="icon icon-tag"></i>
                                <a href="<?= $category->url; ?>" class="content grey-txt">
                                    <?= $category->title ?? $categories->name; ?>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
            <li>
                <div class="collapsible-header">Albums</div>
                <div class="collapsible-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores est dignissimos quod quas, quae excepturi tempora officia quibusdam eum fugit nemo id hic ratione blanditiis accusantium laudantium fugiat ipsa consequatur.
                </div>
            </li>
        </ul>
    </div>
