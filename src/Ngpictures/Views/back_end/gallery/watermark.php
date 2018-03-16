<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card">
            <center>
                <img src="<?= $image ?>" alt="" width="800" height="auto">
                <br>
            </center>
        </div>
        <div class="card col l12 s12 m12">
        <form action="" method="POST" class="ml-10 mr-10 mb-30" >
            <div class="col l6 m6 s12">
                <select name = "logo" id="logo">
                    <option selected value="logo-white">logo-white</option>
                    <option value="logo">logo</option>
                    <option value="logo-black">logo-black</option>
                </select>
            </div>
            <div class="submit-button">
                <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
            </div>
        </form>
        </div>
    </section>
</main>
