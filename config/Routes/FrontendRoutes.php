<?php

//  FRONT-END ROUTES
/***************************************************************************/
$router->get("/", "home", "home");
$router->get("/home", "home", "home");

//users pages
$router->any("/login", "users#login", "users.login");
$router->any("/forgot", "users#forgot", "users.forgot");
$router->any("/reset/:id/:token", "users#reset", "users.reset");
$router->any("/sign", "users#sign", "users.sign");
$router->any("/settings/:token", "users#edit", "users.edit");
$router->any("/edit-post/:id/:token", "posts#edit", "posts.edit-article");
$router->any("/submit-photo", "posts#add", "posts.add");
$router->get("/confirm/:id/:token", "users#confirm", "users.confirmation");
$router->get("/logout", "users#logout", "users.logout");
$router->get("/:user-:id", "users#account", "users.account");
$router->get("/my-posts/:token", "posts#showPosts", "posts.show-post");
$router->get("/my-followers/:token", "following#showFollowers", "users.show-followers");
$router->get("/my-following/:token", "following#showFollowing", "users.show-following");
$router->get('/my-saves/:token', 'saves#add', 'saves.index');
$router->post("/delete-post/:token", "posts#delete", "posts.delete");


//community pages
$router->get("/community", "community", "community.index");

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
$router->get("/gallery/:id","gallery#show","gallery.show");


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
$router->get("/feed", "rss", "rss.index");

//others
$router->any("/ideas", "ideas", "ideas.index");
$router->any("/bugs", "bugs", "bugs.index");
$router->any("/contact", "contact", "contact.index");
$router->get("/about", "static#about", "static.about");
$router->get("/privacy", "static#privacy", "static.privacy");
$router->get("/booking", 'booking', 'reservation');
$router->get('/saves/:type/:slug-:id', 'saves#add', 'saves.add');
$router->get("/maps", 'maps#show', 'maps.show');



//facebook routes
$router->get("/facebook/connect", "facebook#connect", "facebook.connect");


// AJAX ROUTES
/*****************************************************************************/
$router->post("/ajax/posts", "ajax#posts", "ajax.posts");
$router->post("/ajax/blog", "ajax#blog", "ajax.blog");
$router->get("/verses", "verses", "ajax.verses");


//ERROR ROUTES
/******************************************************************************/
$router->get("/error/not-found","error#e404","app.found");
$router->get("/error/internal","error#e500","app.internal-server-error");
$router->get("/error/forbidden","error#e403","app.forbidden");
