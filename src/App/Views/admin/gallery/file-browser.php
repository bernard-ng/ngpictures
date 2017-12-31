<nav class="nav z-depth-2 mb-20">
    <div class="nav-wrapper">
        <ul>
            <li class="right"><a href="<?= ADMIN."/file-browser/blog" ?>">Photo blog</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/ngpictures" ?>">Photo site</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/pictures"?>">Photo membres</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/avatars/" ?>">Avatar membres</a></li>
            <li class="right"><a href="<?= ADMIN."/file-browser/articles"?>">Photo articles</a></li>
            <li><a href="<?= ADMIN ?>">Back-end</a></li>
            <li><a href="/home">front-end</a></li>
        </ul>
    </div>
</nav>
<table class="bordered striped">
    <thead>
        <tr>
            <td>No</td>
            <td>thumb</td>
            <td>name</td>
            <td>extension</td>
            <td>last edit</td>
            <td>size</td>
            <td>action</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($files as  $file) : ?>
           <tr>
               <td><?= $file->key() ?></td>
               <td>
                   <img src="<?= $relative_dos.'/'.$file->getBasename() ?>" width="80">
               </td>
               <td><?= $file->getFilename() ?></td>
               <td><?= $file->getExtension() ?></td>
               <td><?= date('d M-Y', $file->getMTime() ) ?></td>
               <td><?= round(($file->getSize() / 1024 ) / 1024  , 2) . "Mb" ?></td>
               <td>
                   <form method="POST" action="<?= ADMIN."/deleteFile/" ?>" style="display: inline-block !important;">
                       <input type="hidden" name="name" value="<?= $file->getBasename() ?>" >
                       <input type="hidden" name="dir" value="<?= $relative_dos ?>" >
                       <button type="submit" class="btn btn-small waves-effect waves-light red" >
                           <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                       </button>
                   </form>
               </td>
           </tr>
        <?php endforeach; ?>
    </tbody>
</table>