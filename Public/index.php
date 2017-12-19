<?php
use Ng\Core\Router\Router;
use Ngpictures\Ngpic;


define("ROOT", dirname(__DIR__));
define("WEBROOT", dirname(__FILE__));
define("CORE", ROOT."/src/Core");
define("APP", ROOT."/src/App");
define("UPLOAD", WEBROOT."/uploads");
define("ADMIN", "/adm");


require(ROOT."/vendor/autoload.php");


if (isset($_GET["url"]) && !empty($_GET["url"])) {

    $router = new Router($_GET["url"]);



    /***************************************************************************
    *
    *                           FRONT-END ROUTES
    *
    ****************************************************************************/

    $router->get("/", "home", "acceuil");
    $router->get("/home/", "home", "accueil");

    //user pages
    $router->get("/login/", "users#login", "login");
    $router->post("/login/", "users#login", "login");
    $router->get("/logout/", "users#logout", "logout");
    $router->get("/sign/", "users#sign", "sign");
    $router->post("/sign/", "users#sign", "sign");
    $router->get("/confirm/:id/:token", "users#confirm", "confirmation");
    $router->get("/account/:user-:id", "users#account", "account");
    $router->get("/users/", "users", "users");
    $router->get("/account/edit/:user-:id", "users#edit", "edit account");
    $router->get("/users/posts/:user-:id", "users#posts", "users posts");


    //articles and blog pages
    $router->get("/blog/","blog", "blog");
    $router->get("/blog/:slug-:id","blog#show", "blog articles");


    $router->get("/articles/","articles#index","articles");
    $router->get("/articles/post/","articles#post","article add");
    $router->get("/articles/edit/:slug-:id/","articles#edit","article edit");
    $router->get("/articles/:slug-:id","articles#show","article show");


    //gallery pages
    $router->get("/gallery/","gallery","gallery");
    $router->get("/gallery/:id","gallery#show","gallery show");


    //features
    $router->get("/likes/:t/:slug-:id","likes","likes");
    $router->get("/following/:name-:id","following#follow","following");
    $router->get("/download/:type/:name", "download", "download system");

    $router->post("/comments/:t/:slug-:id","comments","comment");
    $router->post("/comments/edit/:id", "comments#edit", "edit comment");
    $router->get("/comments/delete/:id", "comments#delete", "delete comment");


    $router->get("/chat/","chat","general chat");
    $router->get("/rss/", "rss-flux", "rss flux");



    //facebook routes
    $router->get("/facebook/connect/", "facebook#connect", "facebook connect");


    /***************************************************************************
    *
    *                           BACK-END ROUTES
    *
    ****************************************************************************/



    $router->get(ADMIN,"admin","administration");

    //articles and blog pages
    $router->get(ADMIN."/blog/","admin#blog", "blog");
    $router->get(ADMIN."/blog/edit/:id","admin#edit", "blog articles edition");
    $router->get(ADMIN."/blog/add/","admin#add", "blog articles redaction");
    $router->post(ADMIN."/blog/edit/:id","admin#edit", "blog articles edition");
    $router->post(ADMIN."/blog/add/","admin#add", "blog articles redaction");
    $router->get(ADMIN."/confirm/:t/:id","admin#confirm","post add online");
    $router->get(ADMIN."/remove/:t/:id","admin#remove","post remove online");
    $router->post(ADMIN."/delete/","admin#delete","blog articles deletion");


    $router->get(ADMIN."/articles/","admin#articles","articles");

    //gallery pages

    $router->get(ADMIN."/gallery/","admin#gallery","nggallery");
    $router->get(ADMIN."/gallery/add/","admin#addGallery","nggallery add");
    $router->post(ADMIN."/gallery/add/","admin#addGallery","nggallery add");
    $router->get(ADMIN."/gallery/edit/:id","admin#editGallery","nggallery edit");
    $router->get(ADMIN."/gallery/edit/","admin#editGallery","ngallery");
    $router->post(ADMIN."/gallery/delete","admin#deleteGallery","nggallery deletion");


    //users pages
    $router->get(ADMIN."/users/","users#all","all users");
    $router->get(ADMIN."/users/edit/:id","users#admEdit","users edition");
    $router->post(ADMIN."/users/delete/","users#delete","users deletion");



     /***************************************************************************
    *
    *                           AJAX ROUTES
    *
    ****************************************************************************/

    $router->post("/ajax/articles", "ajax#articles", "ajax load articles");
    $router->post("/ajax/blog", "ajax#blog", "ajax load blog");
    $router->get("/ajax/verset", "ajax#verset", "ajax load verses");




    /***************************************************************************
    *
    *                           GENERAL ROUTES
    *
    ****************************************************************************/


    //error pages
    $router->get("/error-404","error#e404","page not found");
    $router->get("/error-500","error#e500","internal server error");
    $router->get("/error-403","error#e403","forbidden");


    $router->run();

} else {
    Ngpic::redirect();
}
