<?php
if (isset($_GET['m'],$_GET['id'],$_GET['t'])
    and !empty($_GET['m']) 
    and !empty($_GET['id'])
    and !empty($_GET['t'])
) {

    $id = floor($_GET['id']);
    $m = htmlspecialchars($_GET['m']);
    $t = htmlspecialchars($_GET['t']);
    $app = Ngpic::getInstance();

    $like = $app->getModel('likes');
    $dislike = $app->getModel('dislike');

    switch ($t) {
        case 1:
            $post = $app->getModel('articles')->find($id);
            break;
        case 2:
            $post = $app->getModel('galery')->find($id);
            break;
        case 3:
            $post = $app->getModel('ngarticles')->find($id);
            break;
        case 4:
            $post = $app->getModel('nggalery')->find($id);
            break;
    }

    switch ($m) {
        case 1 :
            if ($t = 1) {
                if (!$post) {    
                    if ($like->isLiked($post)){
                         $like->remove($id,$t);
                     } else {
                         $like->add($id,$t,$_SESSION['id']);
                     }
                }
            }
            if ($t = 2) {
                if (!$post) {    
                    if ($like->isLiked($post)){
                         $like->remove($id,$t);
                     } else {
                         $like->add($id,$t,$_SESSION['id']);
                     }
                }
            }
            if ($t = 3) {
                if (!$post) {    
                    if ($like->isLiked($post)){
                         $like->remove($id,$t);
                     } else {
                         $like->add($id,$t,$_SESSION['id']);
                     }
                }
            }
            if ($t = 4) {
                if (!$post) {    
                    if ($like->isLiked($post)){
                         $like->remove($id,$t);
                     } else {
                         $like->add($id,$t,$_SESSION['id']);
                     }
                }
            }
        break;

        case 2 :
            if ($t = 1) {
                if (!$post) {    
                    if ($dislike->isDisLiked($post)){
                        $dislike->remove($id,$t);
                    } else {
                        $dislike->add($id,$t,$_SESSION['id']);
                    }
                }
            }
            if ($t = 2) {
                if (!$post) {    
                    if ($dislike->isDisLiked($post)){
                        $dislike->remove($id,$t);
                    } else {
                        $dislike->add($id,$t,$_SESSION['id']);
                    }
                }
            }
            if ($t = 3) {
                if (!$post) {    
                    if ($dislike->isDisLiked($post)){
                        $dislike->remove($id,$t);
                    } else {
                        $dislike->add($id,$t,$_SESSION['id']);
                    }
                }
            }
            if ($t = 4) {
                if (!$post) {    
                    if ($dislike->isDisLiked($post)){
                        $dislike->remove($id,$t);
                    } else {
                        $dislike->add($id,$t,$_SESSION['id']);
                    }
                }
            }
        break;

        default :
            header("HTTP/1.1 500 internal server error");
        break;
    }
}
