<?php
use Core\Router\Router;


define("ROOT", dirname(__DIR__));
define("WEBROOT", dirname(__FILE__));
define("CORE", ROOT."/src/Core");
define("APP", ROOT."/src/App");
define('UPLOAD', ROOT."/Public/uploads");

require ROOT."/vendor/autoload.php";
require APP."/Ngpic.php";

if (isset($_GET['url']) && !empty($_GET['url'])) {

    $router = new Router($_GET['url']);



    /* front end routes */
    $router->get("/", "home", "acceuil");
    $router->get("/home/", "home", "accueil");

    //user pages
    $router->get("/login/", "users#login", "login");
    $router->post("/login/", "users#login", "login");
    $router->get("/logout/", "users#logout", "logout");
    $router->get("/sign/", "users#sign", "sign");
    $router->post("/sign/", "users#sign", "sign");
    $router->get("/confirm/:id/:token", "users#confirm", "confirmation");
    $router->get("/account/", "users#account", "account");
    $router->get("/users/", "users", "users");
    $router->get("/account/edit/:user-:id", "users#edit", "edit account");
    $router->get("/users/posts/:user-:id", "users#posts", "users posts");


    //articles and blog pages
    $router->get("/blog/","ngarticles", "blog");
    $router->get('/blog/:slug-:id',"ngarticles#show", "blog articles");


    $router->get("/articles/","articles#index","articles");
    $router->get("/articles/post/","articles#post","article add");
    $router->get("/articles/edit/:slug-:id/","articles#edit","article edit");
    $router->get("/articles/:slug-:id","articles#show","article show");


    //gallery pages
    $router->get("/galery/","galery","galery");
    $router->get("/galery/:id","galery#show","galery show");


    //features
    $router->get("/likes/:slug-:id-:t-:m","likes","likes");
    $router->get("/dislikes/:slug-:id-:t-:m","likes","dislikes");
    $router->get("/following/:name-:id","following#follow","following");

    $router->post("/comments/:slug-:id-:t","comments","comment");
    $router->post("/comments/edit/:id", "comments#edit", "edit comment");
    $router->get("/comments/delete/:id", "comments#delete", "delete comment");


    $router->get("/chat/","chat","general chat");
    $router->get("/rss/", "rss-flux", "rss flux");


    /* back end routes */
    $router->get("/adm/",'admin',"administration");

    //articles and blog pages
    $router->get("/adm/blog/","admin#blog", "blog");
    $router->get('/adm/blog/edit/:id',"admin#edit", "blog articles edition");
    $router->get('/adm/blog/add/',"admin#add", "blog articles redaction");
    $router->post('/adm/blog/edit/:id',"admin#edit", "blog articles edition");
    $router->post('/adm/blog/add/',"admin#add", "blog articles redaction");
    $router->post('/adm/delete/',"admin#delete",'blog articles deletion');

    $router->get("/adm/articles/","admin#articles","articles");

    //gallery pages
    $router->get('/adm/gallery','gallery#admIndex','gallery adm');
    $router->post('/adm/gallery/delete','gallery#delete','gallery deletion');
    $router->get("/adm/nggallery/","nggallery#admIndex","nggallery");
    $router->get("/adm/nggallery/add/:id","nggallery#add","nggallery add");
    $router->post("/adm/nggallery/add/","nggallery#add","nggallery add");
    $router->get("/adm/nggallery/edit/:id","ngallery#edit","nggallery edit");
    $router->get('/adm/nggallery/edit/','ngallery#edit','ngallery');
    $router->post('/adm/nggallery/delete/','nggallery#delete','nggallery deletion');


    //users pages
    $router->get('/adm/users/','users#all','all users');
    $router->get('/adm/users/edit/:id','users#admEdit','users edition');
    $router->post('/adm/users/delete/','users#delete','users deletion');


    //error pages
    $router->get("/error-404","error#e404","page not found");
    $router->get("/error-500","error#e500","internal server error");
    $router->get("/error-403","error#e403","forbidden");


    $router->run();

} else {
    Ngpic::redirect();
}
