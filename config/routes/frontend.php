<?php

use Ngpictures\Controllers\AjaxController;
use Ngpictures\Controllers\BlogController;
use Ngpictures\Controllers\BookingController;
use Ngpictures\Controllers\BugsController;
use Ngpictures\Controllers\CategoriesController;
use Ngpictures\Controllers\CommentsController;
use Ngpictures\Controllers\CommunityController;
use Ngpictures\Controllers\ContactController;
use Ngpictures\Controllers\DownloadController;
use Ngpictures\Controllers\ErrorController;
use Ngpictures\Controllers\FollowingController;
use Ngpictures\Controllers\GalleryController;
use Ngpictures\Controllers\HomeController;
use Ngpictures\Controllers\HtagController;
use Ngpictures\Controllers\IdeasController;
use Ngpictures\Controllers\LikesController;
use Ngpictures\Controllers\MapsController;
use Ngpictures\Controllers\NotificationsController;
use Ngpictures\Controllers\PhotographersController;
use Ngpictures\Controllers\PostsController;
use Ngpictures\Controllers\ReportsController;
use Ngpictures\Controllers\RssController;
use Ngpictures\Controllers\SavesController;
use Ngpictures\Controllers\SearchController;
use Ngpictures\Controllers\StaticController;
use Ngpictures\Controllers\UsersController;

/** @var \Ng\Core\Router\Router $router */
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

    $router->any("/ideas", [IdeasController::class], "ideas.index");
    $router->any("/bugs", [BugsController::class], "bugs.index");
    $router->any("/contact", [ContactController::class], "contact.index");
    $router->any("/report/:type/:slug-:id", [ReportsController::class], 'report.index');
    $router->get("/about", [StaticController::class, 'about'], "static.about");
    $router->get("/privacy", [StaticController::class, 'privacy'], "static.privacy");
    $router->any("/app.offline", [StaticController::class, 'offline'], 'static.offline');
    $router->any("/booking", [BookingController::class], 'reservation');
    $router->get('/saves/:type/:slug-:id', [SavesController::class, 'add'], 'saves.add');
    $router->get("/maps", [MapsController::class, 'show'], 'maps.show');
    $router->get("/maps/photographers", [MapsController::class, 'photographers'], 'maps.photographers');
    $router->get("/htag/:tag", [HtagController::class], 'htag.index');
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
    $router->get("/verses", [\Ngpictures\Controllers\VersesController::class], "ajax.verses");
}

photographers_routes : {
    $router->any('/photographers/sign', [PhotographersController::class, 'sign'], "photographers.sign");
    $router->get('/photographers/profile/:name-:id', [PhotographersController::class, 'profile'], "photographers.profile");
    //$router->any("/photographers/add/albums/:token", "photographers#albums_add", "photographers.albums_add");
    //$router->any("/photographers/edit/albums/:id/:token", "photographers#albums_edit", "photographers.albums_edit");
    //$router->any("/photographers/add/pictures/:token", "photographers#add", "photographers.add");
    //$router->any("/photographers/edit/pictures/:id/:token", "photograpers#edit", "photographes.edit");
    $router->get("/photographers/bookings/:token", [PhotographersController::class, 'bookings'], "photographers.bookings");
    //$router->any("/photographers/edit/profile/:name-:id/:token", "photographers#edit_profile", "photographers.edit_profile");
    //$router->post("/photographers/detele/:token", "photographers#delete", "photographers.delete");
}

errors_routes : {
    $router->get("/error/not-found", [ErrorController::class, 'e404'], "app.found");
    $router->get("/error/internal", [ErrorController::class, 'e500'], "app.internal-server-error");
    $router->get("/error/forbidden", [ErrorController::class, 'e403'], "app.forbidden");
}

$router->get("/:user-:id", [UsersController::class, 'account'], "users.account");
