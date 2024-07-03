<?php
require "koneksi.php";

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

//get job nama job/keyword
if (isset($_GET['keyword'])) {
    $queryJob = mysqli_query($con, "SELECT * FROM job WHERE nama LIKE '%$_GET[keyword]%'");
}

//get job kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    $queryJob = mysqli_query($con, "SELECT * FROM job WHERE id_kategori='$kategoriId[id]'");
}

//get job default
else {
    $queryJob = mysqli_query($con, "SELECT * FROM job");
}

$countData = mysqli_num_rows($queryJob);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- Banner Start -->
    <div class="container-fluid banner-job d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Job Jepang</h1>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Body Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3 class="mb-3">Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a href="job.php?kategori=<?php echo $kategori['nama'] ?>">
                            <li class="list-group-item"><?php echo $kategori['nama']; ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>


            <div class="col-lg-9">
                <h3 class="text-center mb-3">Job</h3>
                <div class="row">
                    <?php
                    if ($countData < 1) {
                    ?>
                        <h3 class="text-center my-5">"JOB YANG ANDA CARI TIDAK TERSEDIA"</h3>
                    <?php
                    }
                    ?>

                    <?php while ($job = mysqli_fetch_array($queryJob)) { ?>
                        <div class="col-md-4 mb-3">
                            <div class="card mb-3 " style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="img/<?php echo $job['logo']; ?>" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-text"> <?php echo $job['tanggal']; ?> </h5>
                                            <h5 class="card-title"><?php echo $job['nama']; ?></h5>
                                            <p class="card-text text-truncate"><?php echo $job['detail']; ?></p>
                                            <p class="card-text"><span>Gaji: Rp.</span><?php echo $job['gaji']; ?></p>
                                            <a href="job-detail.php?nama=<?php echo $job['nama']; ?>" class="btn warna2 fs-6 text-white">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Body End -->

    <!-- Footer -->

    <?php require "footer.php"; ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>