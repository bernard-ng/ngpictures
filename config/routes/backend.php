<?php

use Ngpictures\Controllers\Admin\AlbumsController;
use Ngpictures\Controllers\Admin\BlogController;
use Ngpictures\Controllers\Admin\CategoriesController;
use Ngpictures\Controllers\Admin\GalleryController;
use Ngpictures\Controllers\Admin\LocationsController;
use Ngpictures\Controllers\Admin\LogsController;
use Ngpictures\Controllers\Admin\PagesEditorController;
use Ngpictures\Controllers\Admin\PhotographersController;
use Ngpictures\Controllers\Admin\ReportsController;
use Ngpictures\Controllers\Admin\UsersController;
use Ngpictures\Controllers\AdminController;


/** @var \Ng\Core\Router\Router $router */
$router->get(ADMIN, [AdminController::class], "admin.index");
$router->any(ADMIN . "/reports", [ReportsController::class], 'admin.reports.index');

logs_routes : {
    $router->get(ADMIN . "/logs", [LogsController::class], "admin.logs");
    $router->get(ADMIN . "/logs/delete", [LogsController::class, 'clear'], "admin.deleteLogs");
    $router->get(ADMIN . "/logs/send", [LogsController::class, 'send'], "admin.sendLogs");
}

pages_routes : {
    $router->any(ADMIN . "/pages", [PagesEditorController::class, 'show'], "admin.showPages");
    $router->any(ADMIN . "/pages/:name", [PagesEditorController::class, 'edit'], "admin.editPages");
}

posts_routes : {
    $router->any(ADMIN . "/blog/edit/:id", [BlogController::class, 'edit'], "admin.blog-edit");
    $router->any(ADMIN . "/blog/add", [BlogController::class, 'add'], "admin.blog-add");
    $router->any(ADMIN . "/blog/categories/add", [CategoriesController::class, 'add'], "admin.categories-add");
    $router->any(ADMIN . "/blog/categories/edit/:id", [CategoriesController::class, 'edit'], "admin.categories-edit");
    $router->get(ADMIN . "/blog", [BlogController::class], "admin.blog");
    $router->get(ADMIN . "/blog/categories", [CategoriesController::class], "admin.categories");
    $router->get(ADMIN . "/confirm/:t/:id", [AdminController::class, 'confirm'], "admin.confirm");
    $router->get(ADMIN . "/posts", [\Ngpictures\Controllers\Admin\PostsController::class], "admin.posts");
    $router->post(ADMIN . "/delete", [AdminController::class, 'delete'], "admin.delete");
}

photographers_routes : {
    $router->get(ADMIN . "/photographers", [PhotographersController::class], "admin.photographers");
    $router->get(ADMIN . "/locations", [LocationsController::class], "admin.location");
    $router->any(ADMIN . "/locations/add", [LocationsController::class, 'add' ], "admin.location");
    $router->any(ADMIN . "/locations/edit/:id", [LocationsController::class, 'edit' ], "admin.location");
}

gallery_routes : {
    $router->any(ADMIN . "/gallery/add", [GalleryController::class, 'add' ], "admin.gallery-add");
    $router->any(ADMIN . "/gallery/edit/:id", [GalleryController::class, 'edit' ], "admin.gallery-edit");
    $router->any(ADMIN . "/gallery/albums/edit/:id", [AlbumsController::class, 'edit' ], "admin.album-edit");
    $router->any(ADMIN . "/gallery/albums/add", [AlbumsController::class, 'add' ], "admin.album-add");
    $router->any(ADMIN . "/gallery/watermark/:type/:filename", [GalleryController::class, 'watermark' ], "admin.watermarker");
    $router->get(ADMIN . "/gallery", [GalleryController::class], "admin.gallery");
    $router->get(ADMIN . "/gallery/albums", [AlbumsController::class], "admin.gallery.album");
    $router->get(ADMIN . "/media-browser", [GalleryController::class, 'mediaBrowser' ], "admin.gallery-mediaBrowser");
    $router->get(ADMIN . "/file-browser/:dirname", [GalleryController::class, 'fileBrowser' ], "admin.fileBrowser");
    $router->post(ADMIN . "/deleteFile", [AdminController::class, 'deleteFile'], "admin.gallery-deletefile");
}

users_routes : {
    $router->get(ADMIN . "/users", [UsersController::class], "admin.users");
    $router->get(ADMIN . "/users/permissions/:id", [UsersController::class, 'permissions' ], "admin.permissions");
    $router->get(ADMIN . "/users/bugs", [UsersController::class, 'bugs' ], "admin.bugs");
    $router->get(ADMIN . "/users/ideas", [UsersController::class, 'ideas' ], "admin.ideas");
}
