<br>
<br> <br>
<br>
<div class="container">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $banermin = $con->query("SELECT * FROM `tblecombanner` ORDER BY Ecombanner_id ASC")->fetch_assoc();
            $baner = $con->query("SELECT * FROM `tblecombanner`");
            while ($rows_baner = $baner->fetch_assoc()) {

            ?>
                <?php if ($rows_baner['Ecombanner_id'] == $banermin['Ecombanner_id']) { ?>
                    <div class="carousel-item active">
                        <img class="d-block w-100" height="600px" src="./admin/assets/images/banner/<?= $rows_baner['Ecombanner_path'] ?>">
                    </div>
                <?php } else { ?>
                    <div class="carousel-item">
                        <img class="d-block w-100" height="600px" src="./admin/assets/images/banner/<?= $rows_baner['Ecombanner_path'] ?>">
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>