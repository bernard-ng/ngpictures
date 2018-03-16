<?php

//  FRONT-END ROUTES
/***************************************************************************/
$router->get("/", "home", "home");
$router->get("/home", "home", "home");

//users pages
$router->get("/login", "users#login", "users.login");
$router->post("/login", "users#login", "users.login");
$router->get("/logout", "users#logout", "users.logout");
$router->get("/forgot", "users#forgot", "users.forgot");
$router->post("/forgot", "users#forgot", "users.forgot");
$router->get("/reset/:id/:token", "users#reset", "users.reset");
$router->post("/reset/:id/:token", "users#reset", "users.reset");
$router->get("/sign", "users#sign", "users.sign");
$router->post("/sign", "users#sign", "users.sign");
$router->get("/confirm/:id/:token", "users#confirm", "users.confirmation");

$router->get("/:user-:id", "users#account", "users.account");
$router->get("/u/edit/:user-:id/:token", "users#edit", "users.edit");
$router->post("/u/edit/:user-:id/:token", "users#edit", "users.edit");
$router->get("/u/followers/:user-:id/:token", "following#showFollowers", "users.show-followers");
$router->get("/u/following/:user-:id/:token", "following#showFollowing", "users.show-following");
$router->get("/u/posts/:user-:id/:token", "posts#showPosts", "posts.show-post");
$router->get("/u/post", "posts#add", "posts.add");
$router->post("/u/post", "posts#add", "posts.add");
$router->get("/u/post/edit/:id/:token", "posts#edit", "posts.edit-article");
$router->post("/u/post/edit/:id/:token", "posts#edit", "posts.edit");
$router->post("/u/post/delete/:token", "posts#delete", "posts.delete");


//community pages
$router->get("/community", "community", "community.index");
$router->get("/community/designers", "community#designers", "community.designers");
$router->get("/community/photographers", "community#photographers", "community.photographers");


//posts and blog pages
$router->get("/blog","blog", "blog.index");
$router->get("/blog/:slug-:id","blog#show", "blog.show");
$router->get("/posts","posts#index","posts.index");
$router->get("/posts/post","posts#post","posts.add");
$router->get("/posts/edit/:slug-:id","posts#edit","posts.edit");
$router->get("/posts/:slug-:id","posts#show","posts.show");
$router->get("/categories", "categories", "categories.index");
$router->get("/categories/:name-:id", "categories#show", "categories.show");


//gallery pages
$router->get("/gallery","gallery","gallery.index");
$router->get("/gallery/:slug-:id","gallery#show","gallery.show");
$router->get("/gallery/albums", "gallery#albums", "gallery.albums");


//likes
$router->get("/likes/:type/:slug-:id","likes","likes");
$router->get("/likes/show/:type/:slug-:id", "likes#show", "likes.show");

//following
$router->get("/following/:name-:id","following","following");

//download
$router->get("/download/:type/:name", "download", "download");
$router->get("/download/show/:type/:name", "download#show", "download");

//comments
$router->post("/comments/:type/:slug-:id","comments","comments.show");
$router->post("/comments/edit/:id/:token", "comments#edit", "comments.edit");
$router->get("/comments/delete/:id/:token", "comments#delete", "comments.delete");

//search
$router->get("/search", "search", "search.index");
$router->get("/search/:q", "search", "search.index");

//rss
$router->get("/rss", "rss", "rss.index");

//contact
$router->get("/ideas", "ideas", "ideas.index");
$router->post("/ideas", "ideas", "ideas.index");
$router->get("/bugs", "bugs", "bugs.index");
$router->post("/bugs", "bugs", "bugs.index");
$router->get("/contact", "contact", "contact.index");



//facebook routes
$router->get("/facebook/connect", "facebook#connect", "facebook.connect");


//BACK-END ROUTES
/***************************************************************************/
$router->get(ADMIN,"admin","admin.index");

//logs
$router->get(ADMIN."/logs","admin#showLogs","admin.logs");
$router->get(ADMIN."/logs/delete", "admin#deleteLogs", "admin.deleteLogs");
$router->get(ADMIN."/logs/send", "admin#sendLogs", "admin.sendLogs");

//pages
$router->get(ADMIN."/pages", "admin#showPages", "admin.showPages");
$router->get(ADMIN."/pages/:name", "admin#editPages", "admin.editPages");
$router->post(ADMIN."/pages/:name", "admin#editPages", "admin.editPages");

//posts and blog pages
$router->get(ADMIN."/blog","admin#blog", "admin.blog");
$router->get(ADMIN."/blog/edit/:id","admin#edit", "admin.blog-edit");
$router->get(ADMIN."/blog/add","admin#add", "admin.blog-add");
$router->post(ADMIN."/blog/edit/:id","admin#edit", "admin.blog-edit");
$router->post(ADMIN."/blog/add","admin#add", "admin.blog-add");
$router->get(ADMIN."/blog/categories", "admin#categories", "admin.categories");
$router->get(ADMIN."/blog/categories/add", "admin#addCategory", "admin.categories-add");
$router->post(ADMIN."/blog/categories/add", "admin#addCategory", "admin.categories-add");
$router->get(ADMIN."/blog/categories/edit/:id", "admin#editCategory", "admin.categories-edit");
$router->post(ADMIN."/blog/categories/edit/:id", "admin#editCategory", "admin.categories-edit");
$router->get(ADMIN."/confirm/:t/:id","admin#confirm","admin.confirm");
$router->post(ADMIN."/delete","admin#delete","admin.delete");
$router->get(ADMIN."/posts","admin#posts","admin.posts");

//gallery pages
$router->get(ADMIN."/gallery","admin#gallery","admin.gallery");
$router->get(ADMIN."/gallery/add","admin#addGallery","admin.gallery-add");
$router->post(ADMIN."/gallery/add","admin#addGallery","admin.gallery-add");
$router->get(ADMIN."/gallery/edit/:id","admin#editGallery","admin.gallery-edit");
$router->post(ADMIN."/gallery/edit/:id","admin#editGallery","admin.gallery-edit");
$router->get(ADMIN."/gallery/albums", "admin#album", "admin.gallery.album");
$router->get(ADMIN."/gallery/albums/edit/:id", "admin#editAlbum", "admin.album-edit");
$router->post(ADMIN."/gallery/album/edit/:id", "admin#editAlbum", "admin.album-edit");
$router->get(ADMIN."/gallery/albums/add", "admin#addAlbum", "admin.album-add");
$router->post(ADMIN."/gallery/albums/add", "admin#addAlbum", "admin.album-add");
$router->get(ADMIN."/gallery/watermark/:type/:filename", "admin#watermark", "admin.watermarker");
$router->post(ADMIN."/gallery/watermark/:type/:filename", "admin#watermark", "admin.watermarker");
$router->get(ADMIN."/media-browser", "admin#mediaBrowser", "admin.gallery-mediaBrowser");
$router->get(ADMIN."/file-browser/:dirname", "admin#fileBrowser", "admin.fileBrowser");
$router->post(ADMIN."/deleteFile", "admin#deleteFile", "admin.gallery-deletefile");

//users pages
$router->get(ADMIN."/users","admin#users","admin.users");
$router->get(ADMIN."/users/permissions/:id", "admin#permissions", "admin.permissions");
$router->get(ADMIN."/users/bugs", "admin#bugs", "admin.bugs");
$router->get(ADMIN."/users/ideas", "admin#ideas", "admin.ideas");


// AJAX ROUTES
/*****************************************************************************/
$router->post("/ajax/posts", "ajax#posts", "ajax.posts");
$router->post("/ajax/blog", "ajax#blog", "ajax.blog");
$router->get("/ajax/verset", "ajax#verset", "ajax.verses");


//ERROR ROUTES
/******************************************************************************/
$router->get("/error-404","error#e404","app.found");
$router->get("/error-500","error#e500","app.internal-server-error");
$router->get("/error-403","error#e403","app.forbidden");
