<section class="card horizontal verse-panel" id="versesContainer">
    <div class="card-stacked">
        <main class="ng-contain">
        	<span class="badge new"><?= $verse->id ?></span>
            <p id="verseTextContainer"><?= $verse->text ?></p>
        </main>
        <footer class="card-action">
            <span class="left verse" id="verseContainer"><?= $verse->reference ?></span>
        </footer>
    </div>
</section>
