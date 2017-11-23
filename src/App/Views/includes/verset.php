<section class="card horizontal verse-panel" id="godfirstContainer">
    <div class="card-stacked">
        <main class="ng-contain">
        	<span class="badge new"><?= $verse->id ?></span>
            <p id="verseTextContainer"><?= $verse->text ?></p>
        </main>
        <footer class="card-action">
            <i class="right icon icon-menu-down verse-down"></i>
            <span class="left verse" id="verseContainer"><?= $verse->reference ?></span>
        </footer>
    </div>
</section>

