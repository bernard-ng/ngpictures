<?php if (!empty($verses) || !empty($categories)) : ?>
    <aside class="row col l3 s12 fast slideInRight">
        <div class="card grey dark-4">
            <?php if (isset($verse) && !empty($verse)) : ?>
                <div class="verse-panel transparent" data-action="verses" data-ajax="/verses">
                    <div class="indicator-container">
                        <div class="indicator active"></div>
                    </div>
                    <h2 class="ui header">God First</h2>
                    <div class="txt" data-content="txt">
                        <?= $verse->text; ?>
                    </div>
                    <div class="ref" data-content="ref">
                        <?= $verse->reference; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="ui divided list animated slideInRight">
                <?php if (isset($categories) && !empty($categories)) : ?>
                    <ul class="collection transparent">
                        <?php foreach ($categories as $category) : ?>
                            <?php $active_category = $posts[0]->category ?? 'art' ?>
                            <li class="collection-item waves-effect col s12 <?= ($category->title == $active_category)? 'active' : '' ?>">
                                <a href="<?= $category->url; ?>">
                                    <div style="margin: 10px">
                                        <div class="collection-item-title">
                                            <?= $category->title; ?>
                                            <span class="secondary-content"><i class="icon icon-right-open"></i></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li class="collection-item waves-effect">
                                <a href="/categories">Toutes les Catégories</a>
                            </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </aside>
<?php endif; ?>
