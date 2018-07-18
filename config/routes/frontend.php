<?php


$router->get("/", "home", "home");
$router->get("/home", "home", "home");

//users pages
$router->any("/login", "users#login", "users.login");
$router->any("/forgot", "users#forgot", "users.forgot");
$router->any("/reset/:id/:token", "users#reset", "users.reset");
$router->any("/sign", "users#sign", "users.sign");
$router->any("/settings/:token", "users#edit", "users.edit");
$router->get("/notifications/:id/:token", "nofications", "notification.index");
$router->any("/edit-post/:id/:token", "posts#edit", "posts.edit-article");
$router->any("/submit-photo", "posts#add", "posts.add");
$router->get("/confirm/:id/:token", "users#confirm", "users.confirmation");
$router->get("/logout", "users#logout", "users.logout");
$router->get("/my-posts/:token", "posts#showPosts", "posts.show-post");
$router->any("/my-posts/edit/:id/:token", "posts#edit", "posts.edit");
$router->any("/my-posts/delete/:id/:token", "posts#delete", "posts.delete");
$router->get("/my-followers/:token", "following#showFollowers", "users.show-followers");
$router->get("/my-following/:token", "following#showFollowing", "users.show-following");
$router->get('/my-collection/:token', 'users#collection', 'saves.index');
$router->get('/my-notifications/:token', "users#notification", 'notification.index');
$router->get("/my-notifications/delete/:token", "notifications#delete", "notification.delete");
$router->get("/my-notifications/clear/:token", "notifications#clear", "notification.clear");


//community pages
$router->get("/community", "community", "community.index");
$router->get("/community/search", "community#search", "community.search");
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
$router->get("/gallery/slider", "gallery#slider", "gallery.slider");
$router->get("/gallery/albums", "gallery#albums", "gallery.albums");
$router->get("/gallery/albums/:slug-:id", "gallery#album_show", "gallery.album_show");
$router->get("/gallery/:slug-:id","gallery#show","gallery.show");


//likes
$router->get("/likes/:type/:slug-:id","likes","likes");
$router->get("/likes/show/:type/:slug-:id", "likes#show", "likes.show");

//following
$router->get("/following/:name-:id","following","following");

//download
$router->get("/download/:type/:name", "download", "download");
$router->get("/download/show/:type/:name", "download#show", "download");

//comments
$router->get("/comments/:type/:slug-:id", "comments#show", "comments.show");
$router->post("/comments/:type/:slug-:id","comments#index","comments.add");
$router->post("/comments/edit/:id/:token", "comments#edit", "comments.edit");
$router->get("/comments/delete/:id/:token", "comments#delete", "comments.delete");

//search
$router->get("/search", "search", "search.index");
$router->get("/search/:q", "search", "search.index");

//rss
$router->get("/feed", "rss", "rss.index");

//others
$router->any("/ideas", "ideas", "ideas.index");
$router->any("/bugs", "bugs", "bugs.index");
$router->any("/contact", "contact", "contact.index");
$router->any("/report/:type/:slug-:id", 'reports', 'report.index');
$router->get("/about", "static#about", "static.about");
$router->get("/privacy", "static#privacy", "static.privacy");
$router->any("/app.offline", "static#offline", 'static.offline');
$router->any("/booking", 'booking', 'reservation');
$router->get('/saves/:type/:slug-:id', 'saves#add', 'saves.add');
$router->get("/maps", 'maps#show', 'maps.show');
$router->get("/maps/photographers", 'maps#photographers', 'maps.photographers');
$router->get("/htag/:tag", 'htag', 'htag.index');

//facebook routes
$router->get("/facebook/connect", "facebook#connect", "facebook.connect");


// AJAX ROUTES
/*****************************************************************************/
$router->get("/ajax/posts", "ajax#posts", "ajax.posts");
$router->get("/ajax/blog", "ajax#blog", "ajax.blog");
$router->get("/ajax/gallery", "ajax#gallery", "ajax.gallery");
$router->get("/ajax/albums", "ajax#albums", "ajax.albums");
$router->get("/ajax/categories", "ajax#categories", "ajax.categories");
$router->get("/ajax/community", "ajax#community", "ajax.community");

$router->get("/verses", "verses", "ajax.verses");


//ERROR ROUTES
/******************************************************************************/
$router->get("/error/not-found","error#e404","app.found");
$router->get("/error/internal","error#e500","app.internal-server-error");
$router->get("/error/forbidden","error#e403","app.forbidden");


$router->get("/:user-:id", "users#account", "users.account");
