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
    $router->get("/likes/:slug-:id-:t","likes","likes");
    $router->get("/following/:name-:id","following#follow","following");
    $router->get("/download/:type/:name", "download", "download system");

    $router->post("/comments/:slug-:id-:t","comments","comment");
    $router->post("/comments/edit/:id", "comments#edit", "edit comment");
    $router->get("/comments/delete/:id", "comments#delete", "delete comment");


    $router->get("/chat/","chat","general chat");
    $router->get("/rss/", "rss-flux", "rss flux");


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
    $router->post(ADMIN."/delete/","admin#delete","blog articles deletion");

    $router->get(ADMIN."/articles/","admin#articles","articles");

    //gallery pages
    $router->get(ADMIN."/gallery","adminy#gallery","gallery adm");
    $router->post(ADMIN."/gallery/delete","gallery#delete","gallery deletion");
    $router->get(ADMIN."/nggallery/","nggallery#admIndex","nggallery");
    $router->get(ADMIN."/nggallery/add/:id","nggallery#add","nggallery add");
    $router->post(ADMIN."/nggallery/add/","nggallery#add","nggallery add");
    $router->get(ADMIN."/nggallery/edit/:id","ngallery#edit","nggallery edit");
    $router->get(ADMIN."/nggallery/edit/","ngallery#edit","ngallery");
    $router->post(ADMIN."/nggallery/delete/","nggallery#delete","nggallery deletion");


    //users pages
    $router->get(ADMIN."/users/","users#all","all users");
    $router->get(ADMIN."/users/edit/:id","users#admEdit","users edition");
    $router->post(ADMIN."/users/delete/","users#delete","users deletion");


    /***************************************************************************
    *
    *                           GENERAL ROUTES
    *
    ****************************************************************************/


    //error pages
    $router->get("/error-404","error#e404","page not found");
    $router->get("/error-500","error#e500","internal server error");
    $router->get("/error-403","error#e403","forbidden");


    $router->run(Ngpic::getInstance());

} else {
    Ngpic::redirect();
}
