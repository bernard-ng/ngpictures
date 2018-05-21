<?php
/**
 * Created by PhpStorm.
 * User: BERNQRD NG
 * Date: 20/05/2018
 * Time: 22:50
 */

namespace Ng\Core\Managers;


class CacheBustingManager
{

    /**
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

            $cached = "{$basedir}/{$name}_{$tag}.{$extension}";
            return $cached;
        }
        return $filename;
    }
}