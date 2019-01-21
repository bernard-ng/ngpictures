<?php

function CacheBusting(string $filename): string
{
    if (CACHE_BUSTING) {
        $file = WEBROOT . "/{$filename}";
        if (is_file($file)) {
            $last_edit = filemtime($file);
            $extension = pathinfo($file)['extension'];
            $name = pathinfo($file)['filename'];
            $tag = strtolower(md5($last_edit));
            $basedir = str_replace("/{$name}.{$extension}", '', $filename);

            return "{$basedir}/{$name}_{$tag}.{$extension}";
        }
        return $filename;
    } else {
        return $filename;
    }
}
