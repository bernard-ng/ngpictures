<?php
namespace Ng\Core\Managers;

class CacheBustingManager
{

    /**
     * invalidation du cache navigateur
     * @param string $filename
     * @return string
     */
    public static function get(string $filename)
    {
        $file = WEBROOT."/{$filename}";
        if (is_file($file)) {
            $last_edit = filemtime($file);
            $extension = pathinfo($file)['extension'];
            $name = pathinfo($file)['filename'];
            $tag = strtolower(md5($last_edit));
            $basedir = str_replace("/{$name}.{$extension}", '', $filename);

            return "{$basedir}/{$name}_{$tag}.{$extension}";
        }
        return $filename;
    }
}
