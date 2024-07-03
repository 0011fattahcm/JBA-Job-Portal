<?php
require "session.php";
require "../koneksi.php";
require "function.php";

$query = mysqli_query($con, "SELECT a.*,b.nama AS nama_kategori FROM job a JOIN kategori b ON a.
id_kategori=b.id");
$jumlahJob = mysqli_num_rows($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Job
                </li>
            </ol>
        </nav>

        <!-- tambah job -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Job</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="gaji">Gaji</label>
                    <input type="number" class="form-control" name="gaji" required>
                </div>
                <div>
                    <label for="logo">Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="ketersediaan">Ketersediaan</label>
                    <select name="ketersediaan" id="ketersediaan" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="kosong">Tidak Tersedia</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-success" type="submit" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $gaji = htmlspecialchars($_POST['gaji']);
                $tanggal = htmlspecialchars($_POST['tanggal']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan = htmlspecialchars($_POST['ketersediaan']);

                $target_dir = "../img/";
                $nama_file = basename($_FILES["logo"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["logo"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($nama == '' || $kategori == '' || $gaji == '' || $tanggal == '') {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, Kategori, Gaji, dan Tanggal wajib diisi!
                    </div>
                    <?php

                } else {
                    if ($nama_file != '') {
                        if ($image_size > 10000000) {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Ukuran file tidak boleh lebih dari 10 MB!
                            </div>

                            <?php
                        } else {
                            if ($imageFileType != 'jpg' && $imageFileType != 'png') {
                            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Format file wajib jpg atau png!
                                </div>
                        <?php
                            } else {
                                move_uploaded_file($_FILES["logo"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }

                    $queryTambah = mysqli_query($con, "INSERT INTO job (nama, id_kategori ,gaji, logo, detail, ketersediaan, tanggal) 
                    VALUES ('$nama', '$kategori', '$gaji', '$new_name', '$detail', '$ketersediaan', '$tanggal')");

                    if ($queryTambah) {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Job berhasil tersimpan!
                        </div>

                        <meta http-equiv="refresh" content="2; url=job.php" />
            <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-5">
            <h2>List Job</h2>
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Gaji</th>
                            <th>Ketersediaan</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahJob == 0) {
                        ?>
                            <tr>
                                <td colspan=7 class="text-center">Tidak ada data Job</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td><?php echo $data['gaji']; ?></td>
                                    <td><?php echo $data['ketersediaan']; ?></td>
                                    <td><?php echo $data['tanggal']; ?></td>
                                    <td>
                                        <a href="job-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>