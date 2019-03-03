<?php

use Application\Controllers\AjaxController;
use Application\Controllers\BookingController;
use Application\Controllers\CategoriesController;
use Application\Controllers\CollectionsController;
use Application\Controllers\CommentsController;
use Application\Controllers\CommunityController;
use Application\Controllers\ContactController;
use Application\Controllers\DownloadController;
use Application\Controllers\FollowingController;
use Application\Controllers\HomeController;
use Application\Controllers\LikesController;
use Application\Controllers\NotificationsController;
use Application\Controllers\PostsController;
use Application\Controllers\ReportsController;
use Application\Controllers\RssController;
use Application\Controllers\SavesController;
use Application\Controllers\SearchController;
use Application\Controllers\StaticController;
use Application\Controllers\UsersController;


return function (Framework\Router\Router $router) {
    $router->get("/", [HomeController::class], "home");

    auth_routes : {
        $router->any("/login", [UsersController::class, 'login'], "auth.login");
        $router->any("/forgot", [UsersController::class, 'forgot'], "auth.forgot");
        $router->any("/sign", [UsersController::class, 'sign'], "auth.sign");
        $router->post("/logout", [UsersController::class, 'logout'], "auth.logout");
        $router->any("/reset/:id/:token", [UsersController::class, 'reset'], "auth.reset");
        $router->get("/confirm/:id/:token", [UsersController::class, 'confirm'], "auth.confirmation");
    }

    users_routes : {
        $router->any("/:name-:id/settings", [UsersController::class, 'update'], "users.settings");
        $router->get("/:name-:id/posts", [PostsController::class, 'showPosts'], "users.posts");
        $router->get("/:name-:id/posts/update/:id", [PostsController::class, 'update'], "posts.update");
        $router->post("/:name-:id/posts/delete/:id", [PostsController::class, 'delete'], "posts.delete");
        $router->get("/:name-:id/followers", [FollowingController::class, 'showFollowers'], "users.followers");
        $router->get("/:name-:id/following", [FollowingController::class, 'showFollowing'], "users.following");
        $router->get('/:name-:id/collections', [UsersController::class, 'collection'], 'users.collections');
        $router->get("/:name-:id/notifications", [NotificationsController::class], "users.notifications");
        $router->post("/:name-:id/notifications/delete", [NotificationsController::class, 'delete'], "users.notifications.delete");
        $router->post("/:name-:id/notifications/clear", [NotificationsController::class, 'clear'], "users.notifications.clear");
    }

    community_routes : {
        $router->get("/community", [CommunityController::class], "community");
    }

    posts_routes : {
        $router->get("/posts", [PostsController::class, 'index'], "posts");
        $router->get("/posts/:slug-:id", [PostsController::class, 'show'], "posts.show");

        $router->get("posts/slider", [PostsController::class, 'slider'], "posts.slider");
        $router->get("/collections", [CollectionsController::class, 'index'], "collections");
        $router->get("/collections/:slug-:id", [CollectionsController::class, 'show'], "collections.show");

        $router->get("/categories", [CategoriesController::class], "categories");
        $router->get("/categories/:slug-:id", [CategoriesController::class, 'show'], "categories.show");
    }

    features_routes : {
        $router->get("/likes/:id", [LikesController::class, 'create'], "likes.create");
        $router->get('/saves/:id', [SavesController::class, 'create'], 'saves.create');
        $router->any("/reports/:id", [ReportsController::class], 'reports.create');
        $router->get("/following/:id", [FollowingController::class], "following.create");
        $router->post("/comments/:id", [CommentsController::class, 'create'], "comments.create");
        $router->get("/download/:id", [DownloadController::class], "download");

        $router->get("/download/show/:id", [DownloadController::class, 'show'], "download.show");
        $router->get("/likes/show/:id", [LikesController::class, 'show'], "likes.show");
        $router->get("/comments/:id", [CommentsController::class, 'show'], "comments.show");

        $router->post("/comments/update/:id", [CommentsController::class, 'update'], "comments.update");
        $router->get("/comments/delete/:id", [CommentsController::class, 'delete'], "comments.delete");

        $router->get("/search", [SearchController::class], "search");
        $router->any("/contact", [ContactController::class], "contact");
        $router->any('/booking', [BookingController::class], 'booking');
        $router->get("/feed", [RssController::class], "feed");
        $router->get("/about", [StaticController::class, 'about'], "about");
        $router->get("/privacy", [StaticController::class, 'privacy'], "privacy");
        $router->any("/app.offline", [StaticController::class, 'offline'], 'offline');
    }


    //todo: replace with a strong API
    ajax_routes : {
        $router->get("/api/posts", [AjaxController::class, 'posts'], "api.posts");
        $router->get("/api/gallery", [AjaxController::class, 'gallery'], "api.gallery");
        $router->get("/api/collections", [AjaxController::class, 'albums'], "api.collections");
        $router->get("/api/categories", [AjaxController::class, 'categories'], "api.categories");
        $router->get("/api/community", [AjaxController::class, 'community'], "api.community");
        $router->get("/api/users/posts", [AjaxController::class, 'users_posts'], "api.users.posts");
    }


    $router->any("/upload", [PostsController::class, 'create'], "posts.create");
    $router->get("/:name-:id", [UsersController::class, 'account'], "users.profile");
};
