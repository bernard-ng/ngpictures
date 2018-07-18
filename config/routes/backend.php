<?php

$router->get(ADMIN, "admin", "admin.index");
$router->any(ADMIN . "/reports", "admin\\reports#index", 'admin.reports.index');

//logs
$router->get(ADMIN . "/logs", "admin\logs", "admin.logs");
$router->get(ADMIN . "/logs/delete", "admin\logs#clear", "admin.deleteLogs");
$router->get(ADMIN . "/logs/send", "admin\logs#send", "admin.sendLogs");

//pages
$router->any(ADMIN . "/pages", "admin\pagesEditor#show", "admin.showPages");
$router->any(ADMIN . "/pages/:name", "admin\pagesEditor#edit", "admin.editPages");

//posts and blog pages
$router->any(ADMIN . "/blog/edit/:id", "admin\blog#edit", "admin.blog-edit");
$router->any(ADMIN . "/blog/add", "admin\blog#add", "admin.blog-add");
$router->any(ADMIN . "/blog/categories/add", "admin\categories#add", "admin.categories-add");
$router->any(ADMIN . "/blog/categories/edit/:id", "admin\categories#edit", "admin.categories-edit");
$router->get(ADMIN . "/blog", "admin\blog", "admin.blog");
$router->get(ADMIN . "/blog/categories", "admin\categories", "admin.categories");
$router->get(ADMIN . "/confirm/:t/:id", "admin#confirm", "admin.confirm");
$router->get(ADMIN . "/posts", "admin\posts", "admin.posts");
$router->post(ADMIN . "/delete", "admin#delete", "admin.delete");

//photographers and location pages
$router->get(ADMIN . "/photographers", "admin\photographers", "admin.photographers");
$router->get(ADMIN . "/locations", "admin\locations", "admin.location");
$router->any(ADMIN . "/locations/add", "admin\locations#add", "admin.location");
$router->any(ADMIN . "/locations/edit/:id", "admin\locations#edit", "admin.location");

//gallery pages
$router->any(ADMIN . "/gallery/add", "admin\gallery#add", "admin.gallery-add");
$router->any(ADMIN . "/gallery/edit/:id", "admin\gallery#edit", "admin.gallery-edit");
$router->any(ADMIN . "/gallery/albums/edit/:id", "admin\albums#edit", "admin.album-edit");
$router->any(ADMIN . "/gallery/albums/add", "admin\albums#add", "admin.album-add");
$router->any(ADMIN . "/gallery/watermark/:type/:filename", "admin\gallery#watermark", "admin.watermarker");
$router->get(ADMIN . "/gallery", "admin\gallery", "admin.gallery");
$router->get(ADMIN . "/gallery/albums", "admin\albums", "admin.gallery.album");
$router->get(ADMIN . "/media-browser", "admin\gallery#mediaBrowser", "admin.gallery-mediaBrowser");
$router->get(ADMIN . "/file-browser/:dirname", "admin\gallery#fileBrowser", "admin.fileBrowser");
$router->post(ADMIN . "/deleteFile", "admin#deleteFile", "admin.gallery-deletefile");

//users pages
$router->get(ADMIN . "/users", "admin\users", "admin.users");
$router->get(ADMIN . "/users/permissions/:id", "admin\users#permissions", "admin.permissions");
$router->get(ADMIN . "/users/bugs", "admin\users#bugs", "admin.bugs");
$router->get(ADMIN . "/users/ideas", "admin\users#ideas", "admin.ideas");
