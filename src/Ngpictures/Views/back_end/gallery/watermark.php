<nav class="nav">
    <div class="container">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= ADMIN."/file-browser/gallery/" ?>">Photo site</a></li>
                <li class="right"><a href="<?= ADMIN."/gallery/albums/"  ?>">Albums</a></li>
                <li class="right"><a href="<?= ADMIN."/gallery/albums/add" ?>">Ajouter un Album</a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="section container row">
    <section class="card-panel grey dark-4 col l12 m12 s12" style="padding: 20px;">
    <h2 class="ui header col s12">WaterMarker</h2>
        <div class="col l6">
            <img src="<?= $image ?>" alt="" class="responsive-img">
        </div>
        <div class="col l6 s12 m12">
        <form action="" method="POST">
            <fieldset>
                <legend><strong>Ecrire un watermark</strong></legend>
                <div class="input-field">
                    <label for="watermark">Watermark</label>
                    <input type="text" name="watermark" id="watermark">
                </div>
            </fieldset>
            <br>
            <fieldset>
                <legend><strong>Choisir un logo</strong></legend>
                <div class="col l12 m12 s12">
                    <select name = "logo" id="logo">
                        <option selected value="logo-white">logo-white</option>
                        <option value="logo">logo</option>
                        <option value="logo-black">logo-black</option>
                    </select>
                </div>
            </fieldset>
            <br>
            <div class="submit-button">
                <button type="submit" class="btn btn-flat waves-effect">Ajouter</button>
            </div>
        </form>
        </div>
    </section>
</section>
