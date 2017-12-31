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
                    <a href="#">
                        <img src="<?= $image->thumbUrl ?>" width="60" height="60">
                    </a>
                </td>
                <td><?= $image->name ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="/assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

</script>