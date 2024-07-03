<?php
require "koneksi.php";
$queryJob = mysqli_query($con, "SELECT id, nama, gaji, logo, detail FROM job LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- Banner Start -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Japan Bridge Academy</h1>
            <h2>Job Portal</h2>
            <div class="col-md-8 offset-md-2">
                <form action="job.php" method="get">
                    <div class="input-group input-group-lg my-5">
                        <input type="text" class="form-control" placeholder="Cari Job" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna3">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Highlight Start -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h2>Kategori Job</h2>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-magang d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="job.php?kategori=Ginou Jisshu"> Ginou Jisshuu (技能実習) - Pemagangan </a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-tokutei d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="job.php?kategori=Tokutei Ginou">Tokutei Ginou (特定技能) - Pekerja Berkeahlian Khusus</a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-engineer d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="job.php?kategori=Engineering">Engineering (エンジニア) - Insinyur</a></h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Highlight End -->

    <!-- Tentang Start -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h1>Tentang Kami</h1>
            <p class="fs-5 mt-3">JAPAN BRIDGE ACADEMY menciptakan wadah pengembangan
                dan pengetahuan untuk memenuhi kebutuhan era globalisasi.
                Baik dalam dunia pendidikan maupun dunia pekerjaan.
                Untuk mencapai era globalisasi, siswa berlatih di
                Jepang dan kemudian dapat mencari pekerjaan pada
                perusahaan Jepang di Republik Indonesia. Banyak
                perusahaan yang didirikan di Indonesia, namun pada
                umumnya perusahaan Jepang didirikan pada masa ini
                membutuhkan kemampuan membaca, menulis, keterampilan,
                dan waktu</p>
        </div>
    </div>
    <!-- Tentang End -->

    <!-- Job Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <h1 class="text-center">Job</h1>
            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryJob)) { ?>
                    <div class="col-sm-6 col-md-4 mb-3 text-left">
                        <div class="card mb-3 " style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="img/<?php echo $data['logo']; ?>" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $data['nama']; ?></h4>
                                        <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                                        <p class="card-text"><span>Gaji: Rp.</span><?php echo $data['gaji']; ?></p>
                                        <a href="job-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna2 text-white">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center">
                <a class="btn btn-outline-warning mt-3 p-3" href="job.php">Lihat lainnya</a>
            </div>
        </div>
    </div>
    <!-- Job End -->

    <?php require "footer.php" ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>