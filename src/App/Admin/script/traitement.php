<?php

if(!isset($_SESSION['id']) or $_SESSION['id'] != 10 )
{
    $app->internalError();
}               

 
      $idd = Str::secure($_SESSION['id']);
      $userID = $app->getDb->getDb()->query("select * from membres where id= ?",[$idd]);
    
      $userPseudo = $verif['pseudo'];
      $userid = $verif['id'];
      $editionMODE = 0;
      
      if (isset($_GET['edit']) and !empty($_GET['edit'])) {
        $editionMODE = 1;
        $editID = htmlspecialchars($_GET['edit']);
        $articleEDIT= $base->prepare("select * from ngarticle where id=?");
        $articleEDIT->execute(array($editID));
        
        if($articleEDIT->rowcount()==1)
        {
          
          $articleEDIT =$articleEDIT->fetch();
          
        }
        else{
          
          header("location:/plus/erreur/404.php");

        }
      }
      

      //publication article

      if(isset($_POST['titre'],$_POST['contenu']))
      {
        if(!empty($_POST['titre']) and !empty($_POST['contenu']))
        {
          $titre=htmlspecialchars($_POST['titre']);
          $contenu=htmlspecialchars($_POST['contenu']);
          $poster=htmlspecialchars($userPseudo);
          $posterID=htmlspecialchars($userid);
          if($editionMODE==0)
          { 
            
          
            if(isset($_FILES['miniature']) and !empty($_FILES['miniature']['name']))
            {
              $insert=$base->prepare('insert into ngarticle (titre,contenu,date_pub,posterID)   values (?,?,NOW(),?)');
              $insert->execute(array($titre,$contenu,$posterID));
              $lastID= $base->lastInsertId();
              $admitExt=array("jpg","jpeg");
              $Extupload = end(explode(".", $_FILES['miniature']['name']));
              if(in_array($Extupload,$admitExt)){
              
                
                require '../php/class/imgClass.php';   // on cree de miniature et on les envoi dans les different dossier
                $img = '$lastID'.'.'.'$Extupload' ;
                $name = $lastID.'.'.$Extupload ;
                $way="../ngarticle/miniature/".$lastID.".".$Extupload;
                $way2 = "../ngarticle/miniature/40-40/".$lastID.".".$Extupload;
                $way3 = "../ngarticle/miniature/90-90/".$lastID.".".$Extupload;
                $way4 = "../ngarticle/miniature/640-640/".$lastID.".".$Extupload;

                $result = move_uploaded_file($_FILES['miniature']['tmp_name'],$way);

                if($result)
                {
                    Img::creerMIn($way,$way2,$img,40,40);
                    Img::creerMIn($way,$way3,$img,90,90);
                    Img::creerMIn($way,$way4,$img,640,640);


                    $_SESSION['msg'] ="votre article a bien été posté !";
                    $_SESSION['type'] = "alert-success";

                    $insert2=$base->prepare('UPDATE ngarticle  set miniature = ?  where id= ?');
                    $insert2->execute(array($name,$lastID));
                    header("location:gestion/gestion-articles.php");
                    
                }else{

                  $msg = "Erreur dans l'importation de la photo !";
                  $del = $base->prepare('DELETE from ngarticle where id= ?');
                  $del->execute(array($lastID));
                }
                
                
                
              }
              else{
                $msg="Votre photo doit être au format jpg ou jpeg";
                $type = "alert-danger";
              }
          
            } 
            else{
            $msg="L'article doit avoir une photo de couverture";
            $type = "alert-danger";
            }
          
            
            
          }
          else{
            $update=$base->prepare("update ngarticle set titre=?,contenu=?,date_edition= now() where id=?");
            
            $update->execute(array($titre,$contenu,$editID));

            $_SESSION['msg'] ="Votre article à bien été mis à jour";
            $_SESSION['type'] = "alert-success";
            header("location:gestion/gestion-articles.php");
            
          }
        }
        else{
          $msg="complétez tous les champs";
          $type = "alert-danger";
        }
      }

    
//publication des photos

      if(isset($_FILES['image']) and !empty($_FILES['image']['name']))
            {
               $tags = htmlspecialchars($_POST['tags']);
               $sizeMax = 10485760;
               $admitExt=array("jpg","jpeg","png","gif");
               
               if($_FILES['image']['size'] <= $sizeMax)
               {
                  $Extupload = end(explode(".",$_FILES['image']['name']));
                  
                  if(in_array($Extupload,$admitExt))
                  {
                     require '../php/class/imgClass.php';
                     $img = "Ngpictures_".$_FILES['image']['name'] ;
                     $way="../galerie/ngimages/miniature/Ngpictures_".$_FILES['image']['name'];
                     $way2 = "../galerie/ngimages/40-40/Ngpictures_".$_FILES['image']['name'];
                     $way3 = "../galerie/ngimages/90-90/Ngpictures_".$_FILES['image']['name'];
                     $way4 = "../galerie/ngimages/640-640/Ngpictures_".$_FILES['image']['name'];

                     $result= move_uploaded_file($_FILES['image']['tmp_name'],$way);
                     
                     if($result)
                     {
                        Img::creerMIn($way,$way2,$img,40,40);
                        Img::creerMIn($way,$way3,$img,90,90);
                        Img::creerMIn($way,$way4,$img,640,640);

                        $ins = $base ->prepare("INSERT INTO nggalerie(userID,date_pub,tags,nom) values(?,now(),?,?) ");
                        $ins->execute(array($_SESSION['id'],$tags,$img));

                        $_SESSION['msg'] = "Photo postée";
                        $_SESSION['type'] = "alert-success";
                        header("location:gestion/gestion-photos.php");
                         
                     }
                     else
                     {
                        $msg1="Erreur dans l'importation de la photo !";
                        $type="alert-danger";
                     }
                  }
                  else
                  {
                     $msg1="Votre photo doit être au format  jpg ou jpeg !";
                     $type="alert-danger"; 
                  }
               }
               else
               {
                  $msg1="Votre photo ne doit pas dépasser 10Mo";
                  $type="alert-danger";
               }
            } 


//publication verset...


if(isset($_POST['verset'],$_POST['ref']))
        {
            if(!empty($_POST['verset']) and !empty($_POST['ref']))
            {

                $verset= htmlspecialchars($_POST['verset']);
                $ref= htmlspecialchars($_POST['ref']);
                $insert = $base ->prepare("insert into verset (date_pub,ref,contenu) value(now(),?,?)");
                $insert->execute(array($ref,$verset));

                $_SESSION['msg'] = "Verset partagé! ";
                $_SESSION['type'] = "alert alert-success";

            }else
                {
                    $msg2 = "compléter tout les champs! ";
                    $type = "alert alert-danger";
                }
            
        }


// chat-general



if(isset($_POST['message']))
{

  if(!empty($_POST['message']))
  {

  $message =htmlspecialchars($_POST['message']);

  $insert = $base->prepare('INSERT into chat(message,userID,date_pub) values (?,?,NOW()) ');
  $insert->execute(array($message,$_SESSION['id']));

  }

}


// gestion general


//$fichier = "../bible verse/bible.txt";
//$bible = $base->exec("LOAD DATA INFILE '$fichier' INTO TABLE bible verse FIEL DS TERMINATED BY '|' ENCLOSED BY '//'  ");

 

        if(isset($_GET['type']) and $_GET['type'] == 'membre')
        {   
            if(isset($_GET['confirme']) and !empty($_GET['confirme']))
            {
                $Confirme = intval($_GET['confirme']);
    
                $req = $base ->prepare("update membres set confirme = 1 where id = ?");
                $req->execute(array($Confirme));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }

            if(isset($_GET['supprime']) and !empty($_GET['supprime']))
            {
                $supprime = intval($_GET['supprime']);
    
                $req = $base ->prepare("delete from membres where id =?");
                $req->execute(array($supprime));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
    
        }

        if(isset($_GET['type']) and $_GET['type'] == 'article')
        {   
            if(isset($_GET['aprouve']) and !empty($_GET['aprouve']))
            {
                $aprouve = intval($_GET['aprouve']);
    
                $req = $base ->prepare("update ngarticle set confirme = 1 where id = ?");
                $req->execute(array($aprouve));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
            if(isset($_GET['supprime']) and !empty($_GET['supprime']))
            {
                $supprime = intval($_GET['supprime']);
    
                $req = $base ->prepare("delete from ngarticle where id =?");
                $req->execute(array($supprime));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
    
        }


        if(isset($_GET['type']) and $_GET['type'] == 'photo')
        {   
            if(isset($_GET['p_aprouve']) and !empty($_GET['p_aprouve']))
            {
                $p_aprouve = intval($_GET['p_aprouve']);
    
                $req = $base ->prepare("update nggalerie set confirme = 1 where id = ?");
                $req->execute(array($p_aprouve));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
            if(isset($_GET['p_supprime']) and !empty($_GET['p_supprime']))
            {
                $p_supprime = intval($_GET['p_supprime']);
    
                $req = $base ->prepare("delete from nggalerie where id =?");
                $req->execute(array($p_supprime));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
    
        }

        if(isset($_GET['type']) and $_GET['type'] == 'event')
        {   
            if(isset($_GET['e_aprouve']) and !empty($_GET['e_aprouve']))
            {
                $e_aprouve = intval($_GET['e_aprouve']);
    
                $req = $base ->prepare("update event set confirme = 1 where id = ?");
                $req->execute(array($e_aprouve));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
            if(isset($_GET['e_supprime']) and !empty($_GET['e_supprime']))
            {
                $e_supprime = intval($_GET['e_supprime']);
    
                $req = $base ->prepare("delete from event where id =?");
                $req->execute(array($e_supprime));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
    
        }

        if(isset($_GET['type']) and $_GET['type'] == 'probleme')
        {   
            if(isset($_GET['regler']) and !empty($_GET['regler']))
            {
                $regler = intval($_GET['regler']);
    
                $req = $base ->prepare("UPDATE problemes set statut = 1 where id = ?");
                $req->execute(array($regler));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
            if(isset($_GET['supprime']) and !empty($_GET['supprime']))
            {
                $supprime = intval($_GET['supprime']);
    
                $req = $base ->prepare("DELETE from problemes where id =?");
                $req->execute(array($supprime));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
    
        }

        if(isset($_GET['type']) and $_GET['type'] == 'idee')
        {   
            if(isset($_GET['confirme']) and !empty($_GET['confirme']))
            {
                $confirme = intval($_GET['confirme']);
    
                $req = $base ->prepare("UPDATE idees set confirme = 1 where id = ?");
                $req->execute(array($confirme));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
            if(isset($_GET['supprime']) and !empty($_GET['supprime']))
            {
                $supprime = intval($_GET['supprime']);
    
                $req = $base ->prepare("DELETE from idees where id =?");
                $req->execute(array($supprime));
                header("location:".$_SERVER['HTTP_REFERER']);
    
            }
    
        }



// les requetes...


$all = $base->query("SELECT * from chat order by date_pub desc limit 0,10");


$membres = $base->query("SELECT * from membres order by date_ins desc limit 0,8");
$Nb_membres = $base->query('SELECT id from membres');
$Nb_membres = $Nb_membres->rowcount();

$Nb_article = $base->query("SELECT id from ngarticle");
$Nb_article = $Nb_article->rowcount();

$Nb_photo = $base->query("SELECT id from nggalerie");
$Nb_photo = $Nb_photo->rowcount();

$idee = $base->query("SELECT * from idees order by id desc limit 0,2");
$problemes = $base->query("SELECT * from problemes order by id desc limit 0,2");


?>