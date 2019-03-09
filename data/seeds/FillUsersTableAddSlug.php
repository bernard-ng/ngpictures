<?php


use Framework\Managers\StringHelper;
use Phinx\Seed\AbstractSeed;

class FillUsersTableAddSlug extends AbstractSeed
{
    public function run()
    {
        $users = $this->query("SELECT * FROM users");
        $users = $users->fetchAll();

        foreach ($users as $user) {
            $id  = $user['id'];
            $slug = StringHelper::slugify($user['name']);
            $this->execute("UPDATE `users` SET `users`.`slug` = '{$slug}' WHERE `users`.`id` =  '{$id}' ");
        }
    }
}
