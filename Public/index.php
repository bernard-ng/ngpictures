<?php
use Ng\Core\Router\Router;
use Ngpictures\Ngpic;


define("ROOT", dirname(__DIR__));
require(ROOT."/config/ApplicationConfig.php");
require(ROOT."/vendor/autoload.php");

$router = new Router($_GET["url"] ?? $_SERVER['REQUEST_URI'] ?? "/home");


//  FRONT-END ROUTES
/***************************************************************************/
$router->get("/", "home", "home");
$router->get("/home/", "home", "home");

//users pages
$router->get("/login/", "users#login", "users.login");
$router->post("/login/", "users#login", "users.login");
$router->get("/logout/", "users#logout", "users.logout");
$router->get("/forgot/", "users#forgot", "users.forgot");
$router->post("/forgot/", "users#forgot", "users.forgot");
$router->get("/reset/:id/:token", "users#reset", "users.reset");
$router->post("/reset/:id/:token", "users#reset", "users.reset");
$router->get("/sign/", "users#sign", "users.sign");
$router->post("/sign/", "users#sign", "users.sign");
$router->get("/confirm/:id/:token", "users#confirm", "users.confirmation");

$router->get("/account/:user-:id", "users#account", "users.account");
$router->get("/account/edit/:user-:id/:token", "users#edit", "users.edit");
$router->post("/account/edit/:user-:id/:token", "users#edit", "users.edit");
$router->get("/account/my-posts/:user-:id/", "users#showPosts", "users.show-post");
$router->get("/account/my-friends/:user-:id/:token", "users#showFriends", "users.show-friends");
$router->get("/account/post/", "users#post", "users.post");
$router->get("/account/post/articles/", "users#postArticle", "users.post-article");
$router->post("/account/post/articles/", "users#postArticle", "users.post-article");
$router->get("/account/post/articles/edit/:token", "users#editArticle", "users.edit-article");
$router->post("/account/post/articles/edit/:token", "users#editArticle", "users.edit-article");
$router->get("/account/post/delete/:id/:token", "users#delete", "users.delete");


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
$router->get("/gallery/:slug-:id","gallery#show","gallery.show");


//features
$router->get("/likes/:t/:slug-:id","likes","likes");
$router->get("/following/:name-:id","following#follow","following");
$router->get("/download/:type/:name", "download", "download");
$router->post("/comments/:type/:slug-:id","comments","comments.show");
$router->post("/comments/edit/:id", "comments#edit", "comments.edit");
$router->get("/comments/delete/:id", "comments#delete", "comments.delete");
$router->get("/rss/", "rss", "rss.index");
$router->get("/ideas", "ideas", "ideas.index");
$router->post("/ideas", "ideas", "ideas.index");
$router->get("/bugs", "bugs", "admin.bugs.index");
$router->post("/bugs", "bugs", "admin.bugs.index");
$router->get("/contact", "admin#contact", "admin.contact.index");



//facebook routes
$router->get("/facebook/connect/", "facebook#connect", "facebook.connect");


//BACK-END ROUTES
/***************************************************************************/
$router->get(ADMIN,"admin","admin.index");

//articles and blog pages
$router->get(ADMIN."/blog/","admin#blog", "admin.blog");
$router->get(ADMIN."/blog/edit/:id","admin#edit", "admin.blog-edit");
$router->get(ADMIN."/blog/add/","admin#add", "admin.blog-add");
$router->post(ADMIN."/blog/edit/:id","admin#edit", "admin.blog-edit");
$router->post(ADMIN."/blog/add/","admin#add", "admin.blog-add");
$router->get(ADMIN."/blog/categories", "admin#categories", "admin.categories");
$router->get(ADMIN."/blog/categories/add", "admin#addCategory", "admin.categories-add");
$router->post(ADMIN."/blog/categories/add", "admin#addCategory", "admin.categories-add");
$router->get(ADMIN."/blog/categories/edit/:id", "admin#editCategory", "admin.categories-edit");
$router->post(ADMIN."/blog/categories/edit/:id", "admin#editCategory", "admin.categories-edit");
$router->get(ADMIN."/confirm/:t/:id","admin#confirm","admin.confirm");
$router->post(ADMIN."/delete/","admin#delete","admin.delete");
$router->get(ADMIN."/articles/","admin#articles","admin.articles");

//gallery pages
$router->get(ADMIN."/gallery/","admin#gallery","admin.gallery");
$router->get(ADMIN."/gallery/add/","admin#addGallery","admin.gallery-add");
$router->post(ADMIN."/gallery/add/","admin#addGallery","admin.gallery-add");
$router->get(ADMIN."/gallery/edit/:id","admin#editGallery","admin.gallery-edit");
$router->post(ADMIN."/gallery/edit/:id","admin#editGallery","admin.gallery-edit");
$router->get(ADMIN."/gallery/albums", "admin#album", "admin.gallery.album");
$router->get(ADMIN."/gallery/albums/edit/:id", "admin#editAlbum", "admin.album-edit");
$router->post(ADMIN."/gallery/album/edit/:id", "admin#editAlbum", "admin.album-edit");
$router->get(ADMIN."/gallery/albums/add/", "admin#addAlbum", "admin.album-add");
$router->post(ADMIN."/gallery/albums/add/", "admin#addAlbum", "admin.album-add");
$router->get(ADMIN."/media-browser", "admin#mediaBrowser", "admin.gallery-mediaBrowser");
$router->get(ADMIN."/file-browser/:dirname", "admin#fileBrowser", "admin.fileBrowser");
$router->post(ADMIN."/deleteFile/", "admin#deleteFile", "admin.gallery-deletefile");

//users pages
$router->get(ADMIN."/users/","admin#users","admin.users");
$router->get(ADMIN."/users/permissions/:id", "admin#permissions", "admin.permissions");
$router->get(ADMIN."/users/bugs/", "admin#bugs", "admin.bugs");
$router->get(ADMIN."/users/ideas/", "admin#ideas", "admin.ideas");


// AJAX ROUTES
/*****************************************************************************/
$router->post("/ajax/articles", "ajax#articles", "ajax.articles");
$router->post("/ajax/blog", "ajax#blog", "ajax.blog");
$router->get("/ajax/verset", "ajax#verset", "ajax.verses");


//ERROR ROUTES
/******************************************************************************/
$router->get("/error-404","error#e404","app.found");
$router->get("/error-500","error#e500","app.internal-server-error");
$router->get("/error-403","error#e403","app.forbidden");


$router->run();
