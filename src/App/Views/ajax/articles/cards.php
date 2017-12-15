<?php
if (!empty($result)) : 
	foreach ($result as $a) : 
	echo '
    <article class="card" id="'.$a->id.'">
        <header class="ng-news-card-header">
            <span class="ng-news-card-image-profil">
                <a href="'.$a->userAvatarUrl.'" class="zoombox">
                    <img src="'.$a->userAvatarUrl.'" alt="Profile '.$a->username.'" title="'.$a->username.'">
                </a>
            </span>
            <p class="ng-news-card-header-title">
                <a href="'.$a->userAccountUrl.'" title="voir le profil">
                    '.$a->username.'        
                </a>
            </p>';

            if($a->thumb !== null):
            	echo '
                <a id="picBtn" class="ng-news-card-header-icon" href="'.$a->userGalleryUrl.'" title="voir la galery">
                    <i class="icon icon icon-picture"></i>
                </a>
                <a id="saveBtn" class="ng-news-card-header-icon" href="'.$a->downloadUrl.'" title="télécharger la photo">
                    <i class="icon icon icon-save"></i>
                </a>';
            endif;
        echo '</header>';
        if($a->thumb !== null):
        	echo '
            <div class="card-image">
                <span class="ng-news-card-image-article">
                    <a href="'.$a->url.'">
                        <img src="'.$a->thumbUrl.'" alt="Article Image" title="'.$a->title.'">
                    </a>
                </span>
            </div>';
        endif;
        echo '
        <main class="ng-news-card-content">
            <section class="ng-news-card-title">';
                if ($a->category_id !== null):
                    echo '<a href="'.$a->categoryUrl.'"><i class="icon icon-tags"></i></a>';
                endif;
                echo '
                <h2>'.$a->title.'&nbsp;<small>'.$a->category.'</small></h2>
            </section>
            <section>
                <p>'.$a->snipet.'</p>
                <a href="'.$a->url.'" class="ng-news-card-seemore right">Voir plus</a>
            </section>
            <section id="articleInfo">
                <div class="ng-news-card-stat">
                    <i class="icon icon-time"></i>&nbsp;
                    <time id="date_created" data-time="'.strtotime($a->date_created).'">'.$a->time.'</time>
                </div>
                <div class="ng-news-card-stat">
                    <i class="icon icon-thumbs-up"></i>&nbsp;
                    <small>
                        <a id="showLikes" href="'.$a->showLikesUrl.'">'.$a->likes.'</a>
                    </small>
                </div>
                <div class="ng-news-card-stat">
                    <i class="social social-chat"></i>&nbsp;
                    <small>
                        <a id="showComments" href="'.$a->showCommentsUrl.'">'.count($a->comments).'commentaires</a>
                    </small>
                </div>
            </section>
        </main>
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
	endforeach;
endif;