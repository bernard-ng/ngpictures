<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\Mailer\Mailer;
use Psr\Container\ContainerInterface;

class PhotographersController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->loadModel(['photographers', 'users']);
    }


    public function sign()
    {
        $exist = $this->photographers->findWith('users_id', $this->authService->isLogged()->id);
        if (!$exist) {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule("label", ['required', "alpha_dash", "min_length[3]"]);
                $this->validator->setRule("email", 'valid_email', 'required');
                $this->validator->setRule("location", ['required', "min_length[6]"]);
                $this->validator->setRule('phone', ['required', "min_length[6]"]);

                if ($this->validator->isValid()) {
                    $this->validator->unique("label", $this->photographers, $this->flash->msg['photographers_userlabel_token']);
                    $this->validator->unique("email", $this->photographers, $this->flash->msg['photographers_mail_token']);

                    if ($this->validator->isValid()) {
                        $label = $this->str->escape($post->get('label'));
                        $email = $this->str->escape($post->get('email'));
                        $location = $this->str->escape($post->get('location'));
                        $phone = $this->str->escape($post->get('phone'));
                        $users_id = $this->authService->isLogged()->id;

                        $this->photographers->create(compact("label", "email", "location", "phone", "users_id"), false);
                        $this->container->get(Mailer::class)->photographerConfirmation($email);

                        $this->flash->set('success', $this->flash->msg['form_photographers_submitted'], false);
                        $this->redirect("/login");
                    } else {
                        $this->sendFormError();
                    }
                } else {
                    $this->sendFormError();
                }
            }

            $this->turbolinksLocation("/photographers/sign");
            $this->pageManager::setTitle("Création compte photographe");
            $this->view('frontend/photographers/sign', compact('post', 'errors'));
        } else {
            $this->redirect("/photographers/profile/{$exist->label}-{$exist->id}");
        }
    }



    public function profile($label, $id)
    {
        $photographer = $this->photographers->find($id);
        if ($photographer) {
            $user = $this->users->find($photographer->users_id);
            $last = $this->loadModel('posts')->findWith('users_id', $user->id, 0, 4);
            $albums = $this->loadModel('albums')->findWith(
                "photographers_id",
                $this->photographers->findWith('users_id', $this->authService->isLogged()->id)->id,
                false
            );

            $this->turbolinksLocation("/photographers/{$label}-{$id}");
            $this->pageManager::setTitle('Photographe : ' .$photographer->label);
            $this->view('frontend/photographers/profil', compact('user', 'photographer', 'last', 'albums'));
        }
    }




    public function add($token)
    {
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->categories->all();
        $albums = $this->albums->findWith(
            "photographers_id",
            $this->photographers->findWith('users_id', $this->authService->isLogged()->id)->id,
            false
        );

        if (!empty($_FILES)) {
            $name = $this->str->escape($post->get('name'));
            $tags = $this->str->escape($post->get('tags')) ?? null;
            $description = $this->str->escape($post->get('description')) ?? null;
            $categories_id = ($post->get('category') == 0) ? 1 : intval($post->get('category'));
            $albums_id = ($post->get('album') == 0) ? 1 : intval($post->get('album'));
            $slug = empty($name) ? 'ngpictures-photo' : "ngpictures-" . $this->str->slugify($name);

            if (!empty($file->get('thumb'))) {
                $this->gallery->create(compact('name', 'slug', 'description', 'tags', 'categories_id', 'albums_id'));
                $last_id = $this->gallery->lastInsertId();
                if ($last_id) {
                    $isUploaded = $this->container->get(ImageManager::class)->upload($file, 'gallery', "{$slug}-{$last_id}", 'ratio');

                    if ($isUploaded) {
                        $this->container->get(ImageManager::class)->upload($file, 'gallery-thumbs', "{$slug}-{$last_id}", 'small');
                        $exif = $this->container->get(ImageManager::class)->getExif($file);
                        $color = $this->container->get(ImageManager::class)->getColor($file);

                        $this->gallery->update(
                            $last_id,
                            [
                                "thumb" => "{$slug}-{$last_id}.jpg",
                                'exif' => $exif,
                                'color' => $color,
                            ]
                        );

                        $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                        $this->redirect(ADMIN . "/gallery", false);
                    } else {
                        $this->flash->set('danger', $this->flash->msg['files_not_uploaded'], false);
                        $this->gallery->delete($last_id, false);
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['post_requires_picture'], false);
                $this->redirect(true, false);
            }
        }

        $this->pageManager::setTitle('Ajouter une photo');
        $this->view("frontend/photographers/add", compact('post', 'categories', 'albums'));
    }


    public function edit($id, $token)
    {
        $photo = $this->gallery->find(intval($id));

        if ($photo) {
            $post = new Collection($_POST);
            $categories = $this->categories->all();
            $albums = $this->albums->all();

            if (isset($_POST) && !empty($_POST)) {
                $name = $this->str->escape($post->get('name')) ?? $photo->name;
                $tags = $this->str->escape($post->get('tags')) ?? $photo->tags;
                $description = $this->str->escape($post->get('description')) ?? $photo->description;
                $categories_id = intval($post->get('category')) ?? $photo->categories_id ?? 1;
                $albums_id = intval($post->get('album')) ?? $photo->albums_id ?? 1;

                $this->gallery->update($id, compact('name', 'tags', 'description', 'categories_id', 'albums_id'));
                $this->flash->set("success", $this->flash->msg['post_edit_success'], false);
                $this->redirect(ADMIN . "/gallery", false);
            }

            $this->pageManager::setTitle('Adm - gallery.edit');
            $this->view("backend/gallery/edit", compact('photo', 'categories', 'albums'));
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found'], false);
            $this->redirect(true, false);
        }
    }


    public function albums_add($token)
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('title', 'required');
            $this->validator->setRule('description', 'required');

            if ($this->validator->isValid()) {
                $photographers_id = $this->photographers->findWith('users_id', $this->authService->isLogged()->id)->id;
                $title = $this->str->escape($post->get('title'));
                $slug = $this->str->slugify($title);
                $description = $post->get('description');
                $code = $this->str->setToken(5);

                $this->albums->create(compact('title', 'description', 'slug', 'code', 'photographers_id'));
                $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                $this->redirect(ADMIN . "/gallery/albums", false);
            } else {
                $this->sendFormError();
            }
        }

        $this->turbolinksLocation("/photographers/add/albums/{$token}");
        $this->pageManager::setTitle('Créer un album');
        $this->pageManager::setDescription("Les albums public sont visible pour tout le monde");
        $this->view('frontend/photographers/albums.add', compact('post', 'errors'));
    }


    public function albums_edit($id, $token)
    {
        $post = new Collection($_POST);
        $album = $this->albums->find(intval($id));
        $errors = new Collection();

        if ($album) {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('description', 'required');

                if ($this->validator->isValid()) {
                    $title = $this->str->escape($post->get('title')) ?? $album->title;
                    $slug = $this->str->slugify($title);
                    $description = $post->get('description') ?? $album->description;

                    $this->albums->update($album->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->flash->msg['post_edit_success']);
                    $this->redirect(ADMIN . "/gallery/albums");
                } else {
                    $this->sendFormError();
                }
            }

            $this->pageManager::setTitle('admin album.edit');
            $this->view('frontend/photographers/albums.edit', compact('post', 'album', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }


    public function bookings($token)
    {

    }


    public function delete($token)
    {

    }

}
