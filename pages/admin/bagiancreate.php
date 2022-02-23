<?php
if (isset($_POST['button_create'])) {
    
    $database = new Database();
    $db = $database->getConnection();

    $validateSql = "SELECT * FROM bagian WHERE nama_bagian = ?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['nama_bagian']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            Nama Bagian sama sudah ada
        </div>
    <?php
    } else {
        $insertSql = "INSERT INTO bagian SET nama_bagian = ?";
        $stmt = $db->prepare($insertSql);
        $stmt->bindParam(1, $_POST['nama_bagian']);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil ubah data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal ubah data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                    <li class="breadcrumb-item acive">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Bagian</h3>
        </div>
        <div class="card-body">
            <form method="POST">
        <div class="form-group">
            <label for="nama_bagian">Nama Bagian</label>
            <input type="text" class="form-control" name="nama_bagian">
        </div>
        <div class="form-group">
            <label for="karyawan_id">Kepala Bagian</label>
            <select class="form-control" name="karyawan_id">
                <option value="">-- Pilih Kepala Bagian --</option>
                <?php
                       
                    
                
                ?>
            </select>
        </div>      
        <div class="form-group">
            <label for="lokasi_id">Lokasi</label>
            <select class="form-control" name="lokasi_id">
                <option value="">-- Pilih Lokasi --</option>
                <?php
                $selectSQL = "SELECT * FROM lokasi";
                $stmt_lokasi = $db->prepare($selectSQL);
                $stmt_lokasi->execute();

                while ($row_lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) {
                    $selected = $row_lokasi["id"] == $row["lokasi_id"] ? " selected" : "";
                    echo "<option value=\"" . $row_lokasi["id"] . "\" " . $selected . ">" . $row_lokasi["nama_lokasi"] . "</option>";
                }
                ?>
            </select>
        </div>  

        <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
            <i class="fa fa-times"></i> Batal
        </a>
        <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
            <i class="fa fa-save"></i> Simpan
        </button>
    </form>
</div>

    </div>
</section>
<?php include_once "partials/scripts.php" ?>