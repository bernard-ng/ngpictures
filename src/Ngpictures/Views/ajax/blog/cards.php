<?php

if (!empty($result)) :
    foreach ($result as $a) :
        echo'
    <article class="card" id="'.$a->id.'">
        <header class="card-image">
            <div class="ng-article-img">
                <img src="'.$a->thumbUrl.'" alt="'.$a->title.'">
            </div>
        </header>
        <section class="ng-news-card-content">
            <section class="ng-news-card-title">';
        if ($a->categories_id !== null) :
            echo '<a href="'.$a->categoryUrl.'"><i class="icon icon-tags"></i></a>';
        endif;
                echo'
                <h2 >'.$a->title.' &nbsp;<small>'.$a->category.'</small></h2>
            </section>
            <main>
                <p>
                    '.$a->snipet.'
                </p>
                <a href="'.$a->url.'" class="ng-news-card-seemore right">Voir plus</a>
            </main>
            <footer id="articleInfo">
                <div class="ng-news-card-stat">
                    <i class="icon icon-save"></i>&nbsp;
                    <a href="'.$a->downloadUrl.'" title="Télécharger la photo">Télécharger</a>
                </div>
                <div class="ng-news-card-stat">
                    <i class="icon icon-time"></i>&nbsp;
                    <time id="date_created" data-time="'.strtotime($a->date_created).'">'.$a->time.'</time>
                </div>
                <div class="ng-news-card-stat">
                    <i class="icon icon-thumbs-up"></i>&nbsp;
                    <small><a id="showLikes" href=/likes">'.$a->Likes.'</a></small>
                </div>
            </footer>
        </section>
        <footer class="ng-news-card-footer" id="articleOptions">
            <a id="likeBtn" class="ng-news-card-footer-item '.$a->isLike.'" href="'.$a->likeUrl.'" title="aimer la publication">
                <i class="icon icon-thumbs-up"></i>&nbsp;J\'aime
            </a>
            <a id="commentBtn" class="ng-news-card-footer-item" href="'.$a->commentUrl.'" title="commenter la publication">
                <i class="icon icon-comment" ></i>&nbsp;Commenter
            </a>
            <a id="shareBtn" class="ng-news-card-footer-item" href="/share/" title="partager la publication">
                <i class="icon icon-share"></i>&nbsp;partager
            </a>
        </footer>
    </article>';
    endforeach ;
endif;
