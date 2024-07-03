<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryJob = mysqli_query($con, "SELECT * FROM job WHERE nama='$nama'");
$job = mysqli_fetch_array($queryJob);

$queryJobTerkait = mysqli_query($con, "SELECT * FROM job WHERE id_kategori='$job[id_kategori]' AND id!='$job[id]'LIMIT 4");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Job</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="img/<?php echo $job['logo']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h5 class="card-text"><span>Tanggal Job: </span><?php echo $job['tanggal']; ?></h5>
                    <h1> <?php echo $job['nama']; ?></h1>
                    <p class="fs-5">
                        <?php echo $job['detail']; ?>
                    </p>

                    <p class="text-gaji">
                        Rp. <?php echo $job['gaji']; ?>
                    </p>

                    <p class="fs-5">
                        Status Ketersediaan <strong><?php echo $job['ketersediaan']; ?></strong>
                    </p>
                    <div class="mt-5 d-flex justify-content-between">
                        <a href="job.php" class="btn btn-primary" name="BackBtn">Kembali</a>
                        <button href="" class="btn btn-success" name="ApplyBtn">Apply Job</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5"> JOB TERKAIT </h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryJobTerkait)) { ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="job-detail.php?nama=<?php echo $data['nama']; ?>">
                            <img src="img/<?php echo $data['logo']; ?>" class="img-fluid img-thumbnail job-terkait-image" alt="">
                        </a>
                        <h1 class="text-white fs-5 mt-3"> <?php echo $data['nama']; ?> </h1>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>


    <?php require "footer.php"; ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>