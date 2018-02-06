<table class="bordered striped">
    <thead>
        <tr>
            <th>id</th>
            <th>thumb</th>
            <th>name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($images as $image): ?>
            <tr>
                <td><?= $image->id ?></td>
                <td>
                    <a href="#" onclick="FileBrowserDialogue.mySubmit('<?= $image->thumbUrl ?>')">
                        <img src="<?= $image->thumbUrl ?>" width="60" height="60">
                    </a>
                </td>
                <td><?= $image->name ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="/assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/assets/js/tinymce/tinymce_popup.js"></script>
<script type="text/javascript">

 var FileBrowserDialogue = {
    init : function () {
        // Here goes your code for setting your custom things onLoad.
    },
    mySubmit : function (URL) {
        var win = tinyMCEPopup.getWindowArg("window");

        // insert information now
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

        // are we an image browser
        if (typeof(win.ImageDialog) != "undefined") {
            // we are, so update image dimensions...
            if (win.ImageDialog.getImageData)
                win.ImageDialog.getImageData();

            // ... and preview if necessary
            if (win.ImageDialog.showPreviewImage)
                win.ImageDialog.showPreviewImage(URL);
        }

        // close popup window
        tinyMCEPopup.close();
    }
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
   




</script>