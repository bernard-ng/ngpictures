<table class="bordered grey dark-4">
    <thead>
        <tr>
            <th>id</th>
            <th>thumb</th>
            <th>name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($images as $image) : ?>
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
    let FileBrowserDialogue = {
        init : function () {},
        mySubmit : function (URL) {
            let win = tinyMCEPopup.getWindowArg("window");
            win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

            if (typeof(win.ImageDialog) !== "undefined") {
                if (win.ImageDialog.getImageData) {
                    win.ImageDialog.getImageData();
                }

                if (win.ImageDialog.showPreviewImage) {
                    win.ImageDialog.showPreviewImage(URL);
                }
            }
            tinyMCEPopup.close();
        }
    };
    tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
</script>
