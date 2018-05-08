<div class="jumbotron dark row col l3 s12 fast slideInRight">
<div>
    <div class="verse-panel transparent" data-action="verses" data-ajax="/verses">
        <div class="indicator-container">
            <div class="indicator active"></div>
        </div>
        <?php if (isset($verse) && !empty($verse)) : ?>
            <h2 class="ui header">God First</h2>
            <div class="txt" data-content="txt">
                <?= $verse->text; ?>
            </div>
            <div class="ref" data-content="ref">
                <?= $verse->reference; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="ui divided list animated slideInRight">
        <?php if (isset($categories) && !empty($categories)) : ?>
            <ul class="collection transparent">
                <?php foreach ($categories as $category) : ?>
                    <li class="collection-item waves-effect col s12 <?= ($category->title == $posts[0]->category)? 'active' : '' ?>">
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
            </ul>
        <?php endif; ?>
    </div>
</div>
</div>