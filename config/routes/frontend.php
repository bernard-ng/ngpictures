<?php

use Application\Controllers\AjaxController;
use Application\Controllers\BlogController;
use Application\Controllers\BookingController;
use Application\Controllers\BugsController;
use Application\Controllers\CategoriesController;
use Application\Controllers\CommentsController;
use Application\Controllers\CommunityController;
use Application\Controllers\ContactController;
use Application\Controllers\DownloadController;
use Application\Controllers\ErrorController;
use Application\Controllers\FollowingController;
use Application\Controllers\GalleryController;
use Application\Controllers\HomeController;
use Application\Controllers\HtagController;
use Application\Controllers\IdeasController;
use Application\Controllers\LikesController;
use Application\Controllers\MapsController;
use Application\Controllers\NotificationsController;
use Application\Controllers\PhotographersController;
use Application\Controllers\PostsController;
use Application\Controllers\ReportsController;
use Application\Controllers\RssController;
use Application\Controllers\SavesController;
use Application\Controllers\SearchController;
use Application\Controllers\StaticController;
use Application\Controllers\UsersController;

/** @var \Framework\Router\Router $router */
$router->get("/", [HomeController::class], "home");
$router->get("/home", [HomeController::class], "home");

users_pages : {
    $router->any("/login", [UsersController::class, 'login'], "users.login");
    $router->any("/forgot", [UsersController::class, 'forgot'], "users.forgot");
    $router->any("/reset/:id/:token", [UsersController::class, 'reset'], "users.reset");
    $router->any("/sign", [UsersController::class, 'sign'], "users.sign");
    $router->any("/settings/:token", [UsersController::class, 'edit'], "users.edit");
    $router->get("/notifications/:id/:token", [NotificationsController::class], "notification.index");
    $router->any("/edit-post/:id/:token", [PostsController::class, 'edit'], "posts.edit-article");
    $router->any("/submit-photo", [PostsController::class, 'add'], "posts.add");
    $router->get("/confirm/:id/:token", [UsersController::class, 'confirm'], "users.confirmation");
    $router->get("/logout", [UsersController::class, 'logout'], "users.logout");
    $router->get("/my-posts/:token", [PostsController::class, 'showPosts'], "posts.show-post");
    $router->any("/my-posts/edit/:id/:token", [PostsController::class, 'edit'], "posts.edit");
    $router->any("/my-posts/delete/:id/:token", [PostsController::class, 'delete'], "posts.delete");
    $router->get("/my-followers/:token", [FollowingController::class, 'showFollowers'], "users.show-followers");
    $router->get("/my-following/:token", [FollowingController::class, 'showFollowing'], "users.show-following");
    $router->get('/my-collection/:token', [UsersController::class, 'collection'], 'saves.index');
    $router->get('/my-notifications/:token', [UsersController::class, 'notification'], 'notification.index');
    $router->get("/my-notifications/delete/:token", [NotificationsController::class, 'delete'], "notification.delete");
    $router->get("/my-notifications/clear/:token", [NotificationsController::class, 'clear'], "notification.clear");
}

community_routes : {
    $router->get("/community", [CommunityController::class], "community.index");
    $router->get("/community/search", [CommunityController::class, 'search'], "community.search");
    $router->get("/community/photographers", [CommunityController::class, 'photographers'], "community.photographers");
}

posts_routes : {
    $router->get("/posts", [PostsController::class, 'index'], "posts.index");
    $router->get("/posts/post", [PostsController::class, 'post'], "posts.add");
    $router->get("/posts/edit/:slug-:id", [PostsController::class, 'edit'], "posts.edit");
    $router->get("/posts/:slug-:id", [PostsController::class, 'show'], "posts.show");
    $router->get("/categories", [CategoriesController::class], "categories.index");
    $router->get("/categories/:name-:id", [CategoriesController::class, 'show'], "categories.show");
}

gallery_routes : {
    $router->get("/gallery", [GalleryController::class], "gallery.index");
    $router->get("/gallery/slider", [GalleryController::class, 'slider'], "gallery.slider");
    $router->get("/gallery/albums", [GalleryController::class, 'albums'], "gallery.albums");
    $router->get("/gallery/albums/:slug-:id", [GalleryController::class, 'album_show'], "gallery.album_show");
    $router->get("/gallery/:slug-:id", [GalleryController::class, 'show'], "gallery.show");
}

features_routes : {
    $router->get("/likes/:type/:slug-:id", [LikesController::class], "likes");
    $router->get("/likes/show/:type/:slug-:id", [LikesController::class, 'show'], "likes.show");
    $router->get("/following/:name-:id", [FollowingController::class], "following");
    $router->get("/download/:type/:name", [DownloadController::class], "download");
    $router->get("/download/show/:type/:name", [DownloadController::class, 'show'], "download");
    $router->get("/comments/:type/:slug-:id", [CommentsController::class, 'show'], "comments.show");
    $router->post("/comments/:type/:slug-:id", [CommentsController::class, 'index'], "comments.add");
    $router->post("/comments/edit/:id/:token", [CommentsController::class, 'edit'], "comments.edit");
    $router->get("/comments/delete/:id/:token", [CommentsController::class, 'delete'], "comments.delete");

    $router->any("/contact", [ContactController::class], "contact.index");
    $router->any("/report/:type/:slug-:id", [ReportsController::class], 'report.index');
    $router->get("/about", [StaticController::class, 'about'], "static.about");
    $router->get("/privacy", [StaticController::class, 'privacy'], "static.privacy");
    $router->any("/app.offline", [StaticController::class, 'offline'], 'static.offline');
    $router->any("/booking", [BookingController::class], 'reservation');
    $router->get('/saves/:type/:slug-:id', [SavesController::class, 'add'], 'saves.add');
    $router->get("/maps", [MapsController::class, 'show'], 'maps.show');
    $router->get("/maps/photographers", [MapsController::class, 'photographers'], 'maps.photographers');
}

search_routes : {
    $router->get("/search", [SearchController::class], "search.index");
    $router->get("/search/:q", [SearchController::class], "search.index");
}

$router->get("/feed", [RssController::class], "rss.index");

//todo: replace with a strong API
ajax_routes : {
    $router->get("/ajax/posts", [AjaxController::class, 'posts'], "ajax.posts");
    $router->get("/ajax/gallery", [AjaxController::class, 'gallery'], "ajax.gallery");
    $router->get("/ajax/albums", [AjaxController::class, 'albums'], "ajax.albums");
    $router->get("/ajax/categories", [AjaxController::class, 'categories'], "ajax.categories");
    $router->get("/ajax/community", [AjaxController::class, 'community'], "ajax.community");
    $router->get("/ajax/photographers", [AjaxController::class, 'photographers'], "ajax.photographers");
    $router->get("/ajax/users_posts", [AjaxController::class, 'users_posts'], "ajax.users_posts");
}

errors_routes : {
    $router->get("/error/not-found", [ErrorController::class, 'e404'], "app.found");
    $router->get("/error/internal", [ErrorController::class, 'e500'], "app.internal-server-error");
    $router->get("/error/forbidden", [ErrorController::class, 'e403'], "app.forbidden");
}

$router->get("/:user-:id", [UsersController::class, 'account'], "users.account");
