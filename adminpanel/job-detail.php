<?php
require "session.php";
require "../koneksi.php";
require "function.php";

$id = $_GET['p'];

$query = mysqli_query($con, "SELECT a.*,b.nama AS nama_kategori FROM job a JOIN kategori b ON a.
id_kategori=b.id WHERE a.id='$id'");
$data = mysqli_fetch_array($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[id_kategori]'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Job</h2>
        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $dataKategori['id'] ?>"><?php echo $dataKategori['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="gaji">Gaji</label>
                    <input type="number" class="form-control" value="<?php echo $data['gaji']; ?>" name="gaji" required>
                </div>
                <div>
                    <label for="currentlogo">Logo Instansi</label>
                    <img src="../img/<?php echo $data['logo']; ?>" alt="" width="300px">
                </div>
                <div>
                    <label for="logo">Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>
                <div>
                    <label for="ketersediaan">Ketersediaan</label>
                    <select name="ketersediaan" id="ketersediaan" class="form-control">
                        <option value="<?php echo $data['ketersediaan'] ?>"><?php echo $data['ketersediaan'] ?></option>
                        <?php
                        if ($data['ketersediaan'] == 'tersedia') {
                        ?>
                            <option value="kosong">Tidak Tersedia</option>
                        <?php
                        } else {
                        ?>
                            <option value="tersedia">Tersedia</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="<?php echo $data['tanggal']; ?>" class="form-control" required>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <button class="btn btn-success" type="submit" name="simpan">Update</button>
                    <button class="btn btn-danger" type="submit" name="hapus">Hapus</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $gaji = htmlspecialchars($_POST['gaji']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan = htmlspecialchars($_POST['ketersediaan']);
                $tanggal = htmlspecialchars($_POST['tanggal']);

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
                    $queryUpdate = mysqli_query($con, "UPDATE job SET id_kategori='$kategori',
                    nama='$nama', gaji='$gaji', detail='$detail', ketersediaan='$ketersediaan',
                    tanggal='$tanggal' WHERE id=$id");

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

                                $queryUpdate = mysqli_query($con, "UPDATE job SET logo='$new_name' WHERE id='$id'");

                                if ($queryUpdate) {
                                ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Job berhasil terupdate!
                                    </div>

                                    <meta http-equiv="refresh" content="2; url=job.php" />
                    <?php
                                } else {
                                    echo mysqli_error($con);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['hapus'])) {
                $queryHapus = mysqli_query($con, "DELETE FROM job WHERE id='$id'");

                if ($queryHapus) {
                    ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Job berhasil dihapus!
                    </div>
                    <meta http-equiv="refresh" content="2; url=job.php" />
            <?php

                }
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>