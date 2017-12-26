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


$router = new Router($_GET["url"] ?? $_SERVER['REQUEST_URI'] ?? "/home");


/***************************************************************************
 *                           FRONT-END ROUTES
 ****************************************************************************/
$router->get("/", "home", "home");
$router->get("/home/", "home", "home");

//user pages
$router->get("/login/", "users#login", "users.login");
$router->post("/login/", "users#login", "users.login");
$router->get("/logout/", "users#logout", "users.logout");
$router->get("/sign/", "users#sign", "users.sign");
$router->post("/sign/", "users#sign", "users.sign");
$router->get("/confirm/:id/:token", "users#confirm", "users.confirmation");
$router->get("/account/:user-:id", "users#account", "users.account");
$router->get("/users/", "users", "users");
$router->get("/account/edit/:user-:id/:token", "users#edit", "users.editAccount");
$router->post("/account/edit/:user-:id/:token", "users#edit", "users.editAccount");


//articles and blog pages
$router->get("/blog/","blog", "blog.index");
$router->get("/blog/:slug-:id","blog#show", "blog.show");
$router->get("/articles/","articles#index","articles.index");
$router->get("/articles/post/","articles#post","articles.add");
$router->get("/articles/edit/:slug-:id/","articles#edit","articles.edit");
$router->get("/articles/:slug-:id","articles#show","articles.show");
$router->get("/categories/", "categories", "categories.index");
$router->get("/categories/:name-:id", "categories#show", "categories.show");


//gallery pages
$router->get("/gallery/","gallery","gallery.index");
$router->get("/gallery/:id","gallery#show","gallery.show");


//features
$router->get("/likes/:t/:slug-:id","likes","likes");
$router->get("/following/:name-:id","following#follow","following");
$router->get("/download/:type/:name", "download", "download");
$router->post("/comments/:t/:slug-:id","comments","comments.show");
$router->post("/comments/edit/:id", "comments#edit", "comments.edit");
$router->get("/comments/delete/:id", "comments#delete", "comments.delete");
$router->get("/rss/", "rss", "rss.index");



//facebook routes
$router->get("/facebook/connect/", "facebook#connect", "facebook.connect");


/***************************************************************************
 *                           BACK-END ROUTES
 ****************************************************************************/
$router->get(ADMIN,"admin","admin.index");

//articles and blog pages
$router->get(ADMIN."/blog/","admin#blog", "admin.blog");
$router->get(ADMIN."/blog/edit/:id","admin#edit", "admin.blog-edit");
$router->get(ADMIN."/blog/add/","admin#add", "admin.blog-add");
$router->post(ADMIN."/blog/edit/:id","admin#edit", "admin.blog-edit");
$router->post(ADMIN."/blog/add/","admin#add", "admin.blog-add");
$router->get(ADMIN."/confirm/:t/:id","admin#confirm","admin.confirm");
$router->post(ADMIN."/delete/","admin#delete","admin.delete");
$router->get(ADMIN."/articles/","admin#articles","admin.articles");

//gallery pages
$router->get(ADMIN."/gallery/","admin#gallery","admin.gallery");
$router->get(ADMIN."/gallery/add/","admin#addGallery","admin.gallery-add");
$router->post(ADMIN."/gallery/add/","admin#addGallery","admin.gallery-add");
$router->get(ADMIN."/gallery/edit/:id","admin#editGallery","admin.gallery-edit");
$router->get(ADMIN."/gallery/edit/","admin#editGallery","admin.gallery-edit");

//users pages
$router->get(ADMIN."/users/","admin#users","admin.users");
$router->get(ADMIN."/users/permissions/:id", "admin#permissions", "admin.permissions");


/***************************************************************************
 *                           AJAX ROUTES
 ****************************************************************************/
$router->post("/ajax/articles", "ajax#articles", "ajax.articles");
$router->post("/ajax/blog", "ajax#blog", "ajax.blog");
$router->get("/ajax/verset", "ajax#verset", "ajax.verses");


/***************************************************************************
 *                           GENERAL ROUTES
 ****************************************************************************/
//error pages
$router->get("/error-404","error#e404","app.found");
$router->get("/error-500","error#e500","app.internal-server-error");
$router->get("/error-403","error#e403","app.forbidden");


$router->run();
