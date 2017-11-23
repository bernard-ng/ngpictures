<?php 
/* 

salut voici tout mon code sur les fonctions que j'ai utiliser pour ce projet....
si il ya des amelioration a faire , you can, j'ai crée ces fonction par inspiration c'est a dir je ne les 
ai pas ordonner donc sorry pour le desordre, et j'ai creer ces fonction sans verifier si elle exister deja en
predefini, quand suis inspirer je code...
hope sa sera comprehensif;

By BERNARD TSHABU NGANDU 

*/

// sa vous facilitera a changer le host de mysql et la base de donne, c'est inclu dns toute les pages.
function base_connexion($base_recu)
{
    try {
        $base= new PDO("mysql:host=127.0.0.1;dbname=$base_recu;charset=utf8","root","");
        $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $base->setAttribute(PDO::ATTR_SET_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $base;
    } catch (PDOException $e) {
        die("$e->getMessage() <br> $e->getLine() <br> $e->getFile()");
    }
}

// limitation de chaine de charatere 
function truncate_text($text,$maxchars = 157, $points= 1)
{
        if (strlen($text)>$maxchars) {
            $text = substr($text,0,$maxchars); // on recupere le text jusqu'au max de chars
            $position_espace = strrpos($text," "); // on recupre le dernier espace pour ne pas tronquer un mot
            $text = substr($text, 0 , $position_espace); // on recupere le text jusqu'au dernier espace apr le max chars
            if ($points == 1) {
                $text = $text."..." ;
            }
        }
        return $text; 
}
// limitation de chaine de charactere version 2
function limit_text($text,$maxchars, $points= 1)
{
    if (strlen($text)>$maxchars) {
        $text = substr($text,0,$maxchars); 
        $position_espace = strrpos($text," "); 
        $text = substr($text, 0 , $position_espace); 
        if ($points == 1) { 
            $text = $text."..." ; 
        }
    }
    return $text; 
}

function valid_text($text){

    $text = nl2br(user_mention_verif(htag($text)));
    return $text;
}


// premet de retirer les accents d'un string et ajouter les underScore
function removeAccent($text){

    //&grave; &acute; &circ; &uml; &cedil; &tilde; &ring;

    $removed = preg_replace("#À|À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å#", "a", $text);
    $removed = preg_replace("#Ò|Ó|Ô|Õ|Ö|Ø|ò|ó|ô|õ|ö|ø#","o",$removed);
    $removed = preg_replace("#È|É|Ê|Ë|è|é|ê|ë#","e",$removed);
    $removed = preg_replace("#Ç|ç#","c", $removed);
    $removed = preg_replace("#Ì|Í|Î|Ï|ì|í|î|ï#","i",$removed);
    $removed = preg_replace("#Ù|Ú|Û|Ü|ù|ú|û|ü#","u",$removed);
    $removed = preg_replace("#Ýýÿ#","y",$removed);
    $removed = preg_replace("#Ñ|ñ#","n",$removed);

    return $removed;
}

function addUnscore($text){

    $formated = explode(" ", $text);
    $formated = implode($formated,"_");
    return $formated;

}

function valid_userName($text){

    $remove = removeAccent($text);
    $VUN = addUnscore($remove);
    $valid_userName = strtolower(htmlspecialchars($VUN));
    return $valid_userName;
}



// formatage date, c'est possible en POO mais j'av pas le temps :)
function format_date($date)
{
        setlocale(LC_TIME,'Fr'); // on met en francais les mois et les jours 
        $dtt = $date ; // date recu en paremetre
        $mois = substr(strftime('%d', strtotime($dtt)), 0,3); // on recupere les 3 premiere lettres pour le mois
        $date = ucfirst(strftime(' %B-%Y' , strtotime($dtt))); // on recupere le jour et l'annee
        $formated = "$mois $date"; // le resultat 
        return $formated; // la valeur retrournée
}
function today_date()
{
        setlocale(LC_TIME, 'fr');
        $date = date('Y-m-d' , time()); // on recupere la date et l'heure du jour mais l'heure on s'en fou, simple non! 
        $mois = substr(strftime('%d', strtotime($date)), 0,3); 
        $dtt = ucfirst(strftime('%B-%Y' , strtotime($date))); 
        $formated = "$mois $dtt"; 
        return $formated;
}
function ng_date($date)
{
        setlocale(LC_TIME,'fr');
        $dtt = $date ;
        $jour =strftime('%d', strtotime($dtt));
        return $jour;
}
function ng_month($date){
        setlocale(LC_TIME,'fr');
        $dtt = $date ;
        $mois =substr(strftime('%B', strtotime($date)), 0,3);
        return $mois;
}



 /* 
formatage du temps comme sur les resaux sociaux... j'av pas envi de fair un "switch" 

la fonction 'temps' suivante fait un cumul de temps entre deux instant et nous affiche la repose selon
que le temps et en secondes en minutes en jour et au dela de 7 jous , on nous affiche carement la date
de la publication. 
*/
function temps($temps_recu)
{
    setlocale(LC_TIME,'fr'); // on met en francais les mois et les jours
    $temps_actu = time();   
    $temps_recu = strtotime($temps_recu); 
    $temps = $temps_actu - $temps_recu ;  // on recupere le temp passer entr les deux dates
    if ($temps >= 3600 && $temps <= 86400)  // si les secondes passee sont dans cett interval c'est les heures
    {
        $calcul = intval($temps / 3600);  // on divise sans restes les secondes par le nombre de secondes dans une heure
        $formated = "il y a $calcul"."h";
    }
    elseif ($temps >= 60 && $temps < 3600 ) // minutes
    {
        $calcul = intval(($temps % 3600) / 60);
        $formated = "il y a $calcul"."m";
    }
    elseif ($temps > 86400 &&  $temps <= 604800 ) // si les secondes passee sont dans cett interval c'est les jours
    {
        $calcul = intval($temps / 86400 ); // on divise sans restes les secondes par le nombre de secondes dans un jour
        $formated = "il y a $calcul"."j";
    }
    elseif ($temps > 604800) // au dela de 7 jour on affiche la date...
    {                
        $dtt = $temps_recu ; // date recu en paremetre
        $jour = substr(strftime('%d', $dtt), 0,3); // on recupere les 3 premiere lettres pour le mois
        if(date("Y") == strftime("Y",$dtt)){
            $date = ucfirst(strftime('%B' , $dtt)); // on recupere le mois et l'annee
        }else{
            $date = ucfirst(strftime('%B' , $dtt)); // on recupere le mois et l'annee 
        } 
        
        $formated = "$jour $date";
    }            
    else{

        $calcul = intval($temps % 60); // secondes 
        $formated = "il y a $calcul"."s"; 
    }
    return $formated; // la valeur retrounée
} 




   
// recuperation des miniature pour ngpictures et photos normal...
function article_min($article)
{
        $articleID = $article;
        global $base;

        $min= $base->prepare("SELECT * from article where id= ?");
        $min->execute(array($articleID));
        $min = $min->fetch();
        $min = $min['miniature'];
        $formated = $min;

        return $formated;
}
function ngarticle_min($article)
{
        $articleID = $article;
        global $base;

        $min= $base->prepare("SELECT * from ngarticle where id= ?");
        $min->execute(array($articleID));
        $min = $min->fetch();
        $min = $min['miniature'];
        $formated = $min;

        return $formated;
}

function photo_min($article)
{
        $articleID = $article;
        global $base;

        $min= $base->prepare("SELECT * from galerie where id= ?");
        $min->execute(array($articleID));
        $min = $min->fetch();
        $min = $min['nom'];
        $formated = $min;

        return $formated;
}
function ngphoto_min($article)
{
        $articleID = $article;
        global $base;

        $min= $base->prepare("SELECT * from nggalerie where id= ?");
        $min->execute(array($articleID));
        $min = $min->fetch();
        $min = $min['nom'];
        $formated = $min;

        return $formated;
}


// info sur les article des users...
function article_info($article,$info)
{

        global $base;
        $articleID = $article;

        if($info == "like"){

            $likes = $base -> prepare("select * from likes where articleID = ?");
            $likes -> execute(array($articleID));
            $likes = $likes->rowcount();

            $formated = $likes;

        }
        elseif($info == "dislike"){

            $dislikes = $base -> prepare("select * from dislikes where articleID = ?");
            $dislikes -> execute(array($articleID));
            $dislikes = $dislikes ->rowcount();

            $formated = $dislikes;
        }
        elseif($info == "love"){

            $love= $base->prepare("select * from love where articleID = ?");
            $love->execute(array($articleID));
            $love= $love->rowcount();

            $formated = $love;
        }
        else if($info == "commentaire"){

            $comment= $base->prepare("select * from commentaire where articleID = ?");
            $comment ->execute(array($articleID));
            $comment = $comment ->rowcount();

            $formated = $comment;
        }
        else if($info == "nombre"){

            $nombre= $base->prepare("select id from article where posterID = ?");
            $nombre ->execute(array($articleID));
            $nombre = $nombre ->rowcount();

            $formated = $nombre;

        
        }
        else if($info == "nb_article"){

            $nombre= $base->prepare("select id from article where id = ?");
            $nombre ->execute(array($articleID));
            $nombre = $nombre ->rowcount();

            $formated = $nombre;

        
        }
        else if($info == "posterID"){

            $nombre= $base->prepare("select posterID from article where id = ?");
            $nombre ->execute(array($articleID));
            $nombre = $nombre ->fetch()['posterID'];

            $formated = $nombre;

        
        }else{

            return false;
        }

        return $formated;
}

    
// infos sur un article... ngarticle...
function ngarticle_info($article,$info)
{
        global $base;
        $articleID = $article;

        if($info == "like"){

            $likes = $base -> prepare("select id from nglikes where articleID = ?");
            $likes -> execute(array($articleID));
            $likes = $likes->rowcount();

            $formated = $likes;

        }
        elseif($info == "dislike"){

            $dislikes = $base -> prepare("select id from ngdislikess where articleID = ?");
            $dislikes -> execute(array($articleID));
            $dislikes = $dislikes ->rowcount();

            $formated = $dislikes;
        }
        elseif($info == "love"){

            $love= $base->prepare("select id from nglove where articleID = ?");
            $love->execute(array($articleID));
            $love= $love->rowcount();

            $formated = $love;
        }
        else if($info == "commentaire"){

            $comment= $base->prepare("SELECT id from ngcommentaire where articleID = ?");
            $comment ->execute(array($articleID));
            $comment = $comment ->rowcount();

            $formated = $comment;
        }
        else if($info == "nombre"){

            $nombre= $base->prepare("SELECT id from ngarticle where articleID = ?");
            $nombre ->execute(array($articleID));
            $nombre = $nombre ->rowcount();

            $formated = $nombre;

        }else if($info == "miniature"){
            $min = $base->prepare("SELECT miniature from ngarticle where id = ?");
            $min->execute(array($articleID));
            $min = $min->fetch();
            $min = $min['miniature'];

            $formated = $min;
        }
        else{

           return false;
        }

        return $formated;
}

function photo_info($photo,$info)
{

        global $base;
        $photoID = $photo;

        if($info == "like"){

            $likes = $base -> prepare("select * from likes where photoID = ?");
            $likes -> execute(array($photoID));
            $likes = $likes->rowcount();

            $formated = $likes;

        }
        elseif($info == "dislike"){

            $dislikes = $base -> prepare("select * from dislikes where photoID = ?");
            $dislikes -> execute(array($photoID));
            $dislikes = $dislikes ->rowcount();

            $formated = $dislikes;
        }
        elseif($info == "love"){

            $love= $base->prepare("select * from love where photoID = ?");
            $love->execute(array($photoID));
            $love= $love->rowcount();

            $formated = $love;
        }
        else if($info == "commentaire"){

            $comment= $base->prepare("select * from commentaire where photoID = ?");
            $comment ->execute(array($photoID));
            $comment = $comment ->rowcount();

            $formated = $comment;
        }
        else if($info == "nombre"){

            $nombre= $base->prepare("select id from galerie where userID = ?");
            $nombre ->execute(array($photoID));
            $nombre = $nombre ->rowcount();

            $formated = $nombre;

        
        }
        else if($info == "nb_photo"){

            $nombre= $base->prepare("select id from galerie where id = ?");
            $nombre ->execute(array($photoID));
            $nombre = $nombre ->rowcount();

            $formated = $nombre;

        
        }
        else if($info == "posterID"){

            $nombre= $base->prepare("select userID from photo where id = ?");
            $nombre ->execute(array($photoID));
            $nombre = $nombre ->fetch()['posterID'];

            $formated = $nombre;

        
        }else{

            return false;
        }

        return $formated;
}

    
// infos sur un article... ngarticle...
function ngphoto_info($photo,$info)
{
        global $base;
        $photoID = $photo;

        if($info == "like"){

            $likes = $base -> prepare("select id from nglikes where photoID = ?");
            $likes -> execute(array($photoID));
            $likes = $likes->rowcount();

            $formated = $likes;

        }
        elseif($info == "dislike"){

            $dislikes = $base -> prepare("select id from ngdislikess where photoID = ?");
            $dislikes -> execute(array($photoID));
            $dislikes = $dislikes ->rowcount();

            $formated = $dislikes;
        }
        elseif($info == "love"){

            $love= $base->prepare("select id from nglove where photoID = ?");
            $love->execute(array($photoID));
            $love= $love->rowcount();

            $formated = $love;
        }
        else if($info == "commentaire"){

            $comment= $base->prepare("SELECT id from ngcommentaire where photoID = ?");
            $comment ->execute(array($photoID));
            $comment = $comment ->rowcount();

            $formated = $comment;
        }
        else if($info == "nombre"){

            $nombre= $base->prepare("SELECT id from nggalarie where photoID = ?");
            $nombre ->execute(array($photoID));
            $nombre = $nombre ->rowcount();

            $formated = $nombre;

        }else if($info == "miniature"){
            $min = $base->prepare("SELECT miniature from nggalarie where id = ?");
            $min->execute(array($photoID));
            $min = $min->fetch();
            $min = $min['miniature'];

            $formated = $min;
        }
        else{

           return false;
        }

        return $formated;
}

// info sur le user mm si il actualiser mill fois :) epui "poster" = "user"
function poster_pseudo($ART_posterId)
{       
            global $base;
            $posterID =$ART_posterId;
            $Posteur =$base->query("SELECT pseudo from membres where id=".$posterID." ");
            $pseudo = $Posteur->fetch();
            $formated = $pseudo['pseudo'];
            return $formated;
}
function poster_name($ART_posterId)
{       
            global $base;
            $posterID =$ART_posterId;
            $Posteur =$base->query("SELECT nom_complet from membres where id=".$posterID." ");
            $pseudo = $Posteur->fetch();
            $formated = $pseudo['nom_complet'];
            return $formated;
}
function poster_statut($ART_posterId)
{       
            global $base;
            $posterID =$ART_posterId;
            $Posteur =$base->query("SELECT statut from membres where id=".$posterID." ");
            $pseudo = $Posteur->fetch();
            $formated = $pseudo['statut'];
            return $formated;
}
function poster_profil($ART_posterId)
{       
            global $base;
            $posterID =$ART_posterId;
            $Posteur =$base->query("SELECT avatar from membres where id=".$posterID." ");
            $pseudo = $Posteur->fetch();
            $formated = $pseudo['avatar'];
            return $formated;
}
function poster_phone($ART_posterId)
{       
            global $base;
            $posterID =$ART_posterId;
            $Posteur =$base->query("SELECT num from membres where id=".$posterID." ");
            $pseudo = $Posteur->fetch();
            $formated = $pseudo['num'];
            return $formated;
}
function poster_email($ART_posterId)
{       
            global $base;
            $posterID =$ART_posterId;
            $Posteur =$base->query("SELECT email from membres where id=".$posterID." ");
            $pseudo = $Posteur->fetch();
            $formated = $pseudo['email'];
            return $formated;
}

// query des verset du jour et tout...
function verset()
{
        global $base;
        $vers = $base->query("SELECT * from verset order by id desc");
        $vers = $vers->rowcount();
}
function today_Verset()
{
        global $base;
        $vbj = $base->query('SELECT * from verset order by id desc limit 0,1');
        $V = $vbj->fetch();
        $verset = $V['contenu'] ;
        
        return $verset;
}
function today_Ref()
{
        global $base;
        $vbj = $base->query('SELECT * from verset order by id desc limit 0,1');
        $V = $vbj->fetch();
        $ref = $V['ref']  ;

        return $ref;
}
function verset_info()
{
        global $base;
        $vbj = $base->query('SELECT * from verset order by id desc limit 0,1');
        $V = $vbj -> rowcount();

        return $V;
}


// mention d'un user  avec @... les deux fonctions vont de paires...
// le lien vers le profil doit etre en absolue, vu que suis sur la machine sa sera different du server, pensez a changer sa... :)
function user_mention_verif($text)
{
        $text_format = strtolower($text);
        $text = $text_format;
        $text = preg_replace_callback("#@([a-zA-Z0-9_]+)#", "user_mention", $text);
        return $text;
}
function user_mention($matches)
{
        global $base;
        $verif = $base->prepare("SELECT id  from membres where pseudo = ?");
        $verif->execute(array($matches[1]));

        if($verif->rowcount() == 1)
        {
            $userID= $verif->fetch()['id'];
            return '<a style="color:#428bca; text-transform:none;" href="/membres/profil.php?id='.$userID.'">'.$matches[0].'</a>';
        }
        return $matches[0];
}



function htag($text)
{
        $text_format = strtolower($text);
        $text = $text_format;
        $text = preg_replace_callback("#\#([a-zA-Z0-9_]+)#", "tags", $text);
        return $text;
}
function tags($matches)
{
    return '<a style="color:#428bca; text-transform:none;" href=/galerie/galerie.php?q='.$matches[1].'>'.$matches[0].'</a>';
}

// hash tag just pour le fun, sinon sa passe pas cad il ya pas de lien...
// je reflechi encor a comment faire passer sa
function htags($string) 
{
    $aStr = explode(" ",$string);
    $words = count($aStr);
    for ($i = 0 ; $i < $words ; $i++) {
    	if (strpos($aStr[$i],"#") === 0) {
    		$str_checked = "<a href=\"#\">$aStr[$i]</a>";
    		$aStr[$i] = $str_checked;
    	}
    }
    $strH = implode(" ", $aStr);
    return $strH;
}


// formatage de monbre genre 10.000 = 10k et tout...
function KM_format($nombre)
{
    $nbr = intval($nombre);

    if($nbr >= 0 && $nbr < 1000)
    {
        $cal = $nbr;
        $formated = "$cal";
        return $formated; }

    else if($nbr >=1000 && $nbr < 100000)
    {
        $cal = round(($nbr / 1000),1);
        $formated = "$cal"."K";
        return $formated; }

    else if($nbr >= 100000)
    {
        $cal = round(($nbr / 100000),1);
        $formated = "$cal"."M";
        return $formated; }

    else{return $nbr ;}
}



//pour voir si une personne aime dja un article...
function check_nglike_statut($article,$userID)
{
    global $base;
    $articleID = intval($article);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from nglikes where articleID = ? and userID = ?");
    $check->execute(array($articleID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'aime</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'aime</span>";}
    else{ return false;}

    return $text;
}
function check_like_statut($article,$userID)
{
    global $base;
    $articleID = intval($article);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from likes where articleID = ? and userID = ?");
    $check->execute(array($articleID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class='' >j'aime</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'aime</span>";}
    else{ return false;}

    return $text;
}
function check_ngdislike_statut($article,$userID)
{
    global $base;
    $articleID = intval($article);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from ngdislikess where articleID = ? and userID = ?");
    $check->execute(array($articleID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class='' >je n'aime pas</span>";}
    elseif($check == 1){$text = "<span class='like-active'>je n'aime pas</span>";}
    else{ return false;}

    return $text;
}
function check_dislike_statut($article,$userID)
{
    global $base;
    $articleID = intval($article);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from dislikes where articleID = ? and userID = ?");
    $check->execute(array($articleID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class='' >je n'aime pas</span>";}
    elseif($check == 1){$text = "<span class='like-active'>je n'aime pas</span>";}
    else{ return false;}

    return $text;
}function check_nglove_statut($article,$userID)
{
    global $base;
    $articleID = intval($article);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from nglove where articleID = ? and userID = ?");
    $check->execute(array($articleID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'adore</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'adore</span>";}
    else{ return false;}

    return $text;
}
function check_love_statut($article,$userID)
{
    global $base;
    $articleID = intval($article);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from love where articleID = ? and userID = ?");
    $check->execute(array($articleID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'adore</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'adore</span>";}
    else{ return false;}

    return $text;
}



//pour voir si une personne aime dja un article...
function check_nglikep_statut($photo,$userID)
{
    global $base;
    $photoID = intval($photo);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from nglikes where photoID = ? and userID = ?");
    $check->execute(array($photoID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'aime</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'aime</span>";}
    else{ return false;}

    return $text;
}
function check_likep_statut($photo,$userID)
{
    global $base;
    $photoID = intval($photo);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from likes where photoID = ? and userID = ?");
    $check->execute(array($photoID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'aime</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'aime</span>";}
    else{ return false;}

    return $text;
}
function check_ngdislikep_statut($photo,$userID)
{
    global $base;
    $photoID = intval($photo);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from ngdislikess where photoID = ? and userID = ?");
    $check->execute(array($photoID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>je n'aime pas</span>";}
    elseif($check == 1){$text = "<span class='like-active'>je n'aime pas</span>";}
    else{ return false;}

    return $text;
}
function check_dislikep_statut($photo,$userID)
{
    global $base;
    $photoID = intval($photo);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from dislikes where photoID = ? and userID = ?");
    $check->execute(array($photoID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>je n'aime pas</span>";}
    elseif($check == 1){$text = "<span class='like-active'>je n'aime pas</span>";}
    else{ return false;}

    return $text;
}function check_nglovep_statut($photo,$userID)
{
    global $base;
    $photoID = intval($photo);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from nglove where photoID = ? and userID = ?");
    $check->execute(array($photoID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'adore</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'adore</span>";}
    else{ return false;}

    return $text;
}
function check_lovep_statut($photo,$userID)
{
    global $base;
    $photoID = intval($photo);
    $userID = intval($userID);
    $check = $base->prepare("SELECT * from love where photoID = ? and userID = ?");
    $check->execute(array($photoID,$userID));
    $check = $check->rowcount();
    if($check == 0){$text = "<span class=''>j'adore</span>";}
    elseif($check == 1){$text = "<span class='like-active'>j'adore</span>";}
    else{ return false;}

    return $text;
}


//pour voir si on suis ou pas une personne...
 function check_following_statut($followerID,$followingID){

    global $base;
    $follower = intval($followerID);
    $following = intval($followingID);
    $check = $base->prepare("SELECT * from following where followerID= ? and followingID= ?");
    $check->execute(array($follower,$following));
    $check = $check->rowcount();

    if($check == 0){$text = "Follow";}
    else if($check == 1){$text = "Unfollow";}
    else{return false;}

    return $text;
 }

// les nombres de following...
function Check_following_num($follow){

    global $base;
    $me = intval($follow);
    $check = $base->prepare("SELECT id from following where followerID= ? ");
    $check->execute(array($me));
    $check = $check->rowcount();
    $number = $check;

    return $number;
}

// les nombres de followers
function check_follower_num($follow)
{

    global $base;
    $me = intval($follow);
    $check = $base->prepare("SELECT id from following where followingID= ? ");
    $check->execute(array($me));
    $check = $check->rowcount();
    $number = $check;

    return $number;
}


/// verifie si oui ou non un membre est en ligne...
function isOnline($userID)
{
    global $base;
    $online = $base->prepare("SELECT * from online where userID = :userID");
    $online = $online->execute(["userID" => $userID])->fetch(PDO::FETCH_ASSOC);
    $usersOnline = $online->rowcount();
    return (!$usersOnline)? "Off" : "En ligne";
}
function getUsersOnline()
{
        global $base;
        $time = time();
        $userID = $_SESSION['id'];
        $verif = $base->prepare('SELECT * from online where userID = ?');
        $verif->execute(array($userID));
        $user_online = $verif->rowcount();

            if(!$user_online){

                $ins = $base ->prepare("INSERT into online(time_actu,userID) values(?,?) ");
                $ins->execute(array($time_actu,$userID));

            }else {

                $update = $base->prepare("UPDATE online set time_actu = ?  where userID = ?");
                $update->execute(array($time_actu,$userID));
            }

        $session = time() - 15;

        $online_users = $base ->prepare("SELECT * from online where time_actu < ?");
        $online_users->execute(array($session));        
        $nb_online = $online_users->rowcount();

        $t = ($nb_online > 1) ? "s" : "" ;
        $num = "<div class='last'>".KM_format($nb_online)." personne".$t." en ligne </div>";
        return $num;
}

