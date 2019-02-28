<?php


use Phinx\Seed\AbstractSeed;

class SeedGalleryTableToPostsTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $stmt = $this->query('SELECT * FROM gallery');
        $rows = $stmt->fetchAll();
        $data = [];

        foreach($rows as $row) {
            $data[] = [
                'name' => $row['name'],
                'slug' => $row['slug'],
                'description' => $row['description'],
                'thumb' => null,
                'thumb_old' => $row['thumb'],
                'exif' => $row['exif'],
                'location' => $row['location'],
                'color' => $row['color'],
                'downloads' => $row['downloads'],
                'online' => $row['online'],
                'created_at' => $row['date_created'],
                'updated_at' => null,
                'categories_id' => $row['categories_id'],
                'albums_id' => $row['albums_id'],
                'users_id' => $row['users_id'],
                'tags' => $row['tags'],
                'type' => '2'
            ];
        }

        $this->insert('posts', $data);
    }
}
