<?php include(APP."/Views/includes/admin-menu.php"); ?>
<nav class="nav z-depth-3">
    <div class="nav-wrapper">
        <ul>
            <li class="right"><a href="<?= ADMIN."/file-browser/blog" ?>">Photo blog</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/gallery" ?>">Photo site</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/avatars" ?>">Avatar membres</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/posts"?>">Photo posts</a></li>
            <li><a href="<?= ADMIN ?>">Back-end</a></li>
            <li><a href="/home">front-end</a></li>
        </ul>
    </div>
</nav>
<div class="container row">
    <table class="bordered grey dark-4">
        <thead>
        <tr>
            <td>N<sup>o</sup></td>
            <td>thumb</td>
            <td>name</td>
            <td>extension</td>
            <td>last edit</td>
            <td>size</td>
            <td>action</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file) : ?>
            <?php if($file->getFilename() !== '.' && $file->getFilename() !== '..'): ?>
                <tr>
                    <td><?= $file->key() ?></td>
                    <td>
                        <?php if($file->getFilename() === 'thumbs'): ?>
                            <i class="icon icon-doc"></i>
                        <?php else: ?>
                            <?php if (is_dir(WEBROOT."/{$relative_dos}/thumbs")): ?>
                                <img src="<?= $relative_dos.'/thumbs/'.$file->getBasename() ?>" class="materialboxed" width="80">
                            <?php else: ?>
                                <img src="<?= $relative_dos.'/'.$file->getBasename() ?>" class="materialboxed" width="80">
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $file->getFilename() ?></td>
                    <td><?= $file->getExtension() ?></td>
                    <td><?= date('d M-Y', $file->getMTime()) ?></td>
                    <td><?= round(($file->getSize() / 1024 ) / 1024, 2) . "Mb" ?></td>
                    <td>
                        <form method="POST" action="<?= ADMIN."/deleteFile/" ?>" style="display: inline-block !important;">
                            <input type="hidden" name="name" value="<?= $file->getBasename() ?>" >
                            <input type="hidden" name="dir" value="<?= $relative_dos ?>" >
                            <button type="submit" class="btn btn-small waves-effect waves-light red" id="deleteFile">
                                <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
