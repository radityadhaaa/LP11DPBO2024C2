<?php


include ("KontrakView.php");
include ("presenter/ProsesPasien.php");

class TampilPasien implements KontrakView
{
    private $prosespasien; 
    private $tpl;

    function __construct()
    {
        //konstruktor
        $this->prosespasien = new ProsesPasien();
    }

    function tampil()
    {
        if (isset($_POST['tambah'])) {
            $result = $this->prosespasien->tambahDataPasien($_POST);
        }

        if (isset($_GET['hapus'])) {
            $id = $_GET['hapus'];
            $result = $this->prosespasien->hapusDataPasien($id);
        }

        if (isset($_POST['ubah'])) {
            $result = $this->prosespasien->ubahDataPasien($_POST);
        }
        $this->prosespasien->prosesDataPasien();
        $data = null;

        //semua terkait tampilan adalah tanggung jawab view
        for ($i = 0; $i < $this->prosespasien->getSize(); $i++) {
            $no = $i + 1;
            $data .= "<tr>
			<td>" . $no . "</td>
			<td>" . $this->prosespasien->getNik($i) . "</td>
			<td>" . $this->prosespasien->getNama($i) . "</td>
			<td>" . $this->prosespasien->getTempat($i) . "</td>
			<td>" . $this->prosespasien->getTl($i) . "</td>
			<td>" . $this->prosespasien->getGender($i) . "</td>
			<td>" . $this->prosespasien->getEmail($i) . "</td>
			<td>" . $this->prosespasien->getTelp($i) . "</td>
            <td>
            <a href='index.php?ubah=" . $this->prosespasien->getId($i) . "'>Update</a>
            </br>
            <a href='index.php?hapus=" . $this->prosespasien->getId($i) . "'>Delete</a>
            </td>";
        }
        // Membaca template skin.html
        $this->tpl = new Template("templates/skin.html");

        // Mengganti kode Data_Tabel dengan data yang sudah diproses
        $this->tpl->replace("DATA_TABEL", $data);

        // Menampilkan ke layar
        $this->tpl->write();


    }

    function tambah()
    {
        $data = ' <label for="nik">NIK:</label><br>
        <input type="text" id="nik" name="nik"><br>
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama"><br>
        <label for="tempat">Tempat:</label><br>
        <input type="text" id="tempat" name="tempat"><br>
        <label for="tl">Tanggal Lahir:</label><br>
        <input type="date" id="tl" name="tl"><br>
        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender">
          <option value="laki-laki">Laki - Laki</option>
          <option value="perempuan">Perempuan</option>
        </select><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="telp">Telepon:</label><br>
        <input type="telp" id="telp" name="telp"><br>
        <input type="submit" name="tambah">';

        $this->tpl = new Template("templates/tambah.html");
        $this->tpl->replace("TAMBAH_DATA", $data);
        $this->tpl->write();

    }

    function ubah($id)
    {
        $gender = $this->prosespasien->getGender(0);
        $lakiSelected = '';
        $perempuanSelected = '';

        if ($gender == 'lakilaki') {
            $lakiSelected = 'selected';
        } else if ($gender == 'perempuan') {
            $perempuanSelected = 'selected';
        }

        $data = null;
        $this->prosespasien->prosesDataPasienByID($id);
        $data = ' <input type="hidden" name="id" value="' . $this->prosespasien->getId(0). '" class="form-control"> <br>
        <label for="nik">NIK:</label><br>
        <input type="text" id="nik" name="nik" value="' . $this->prosespasien->getNik(0) . '"><br>
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" value="' . $this->prosespasien->getNama(0) . '"><br>
        <label for="tempat">Tempat:</label><br>
        <input type="text" id="tempat" name="tempat" value="' . $this->prosespasien->getTempat(0) . '"><br>
        <label for="tl">Tanggal Lahir:</label><br>
        <input type="date" id="tl" name="tl" value="' . $this->prosespasien->getTl(0) . '"><br>
        <label for="gender">Gender:</label><br> 
        
        <select id="gender" name="gender">
        <option value="laki-laki" '.$lakiSelected.' >Laki - Laki</option>
        <option value="perempuan" '.$perempuanSelected.'>Perempuan</option>
        </select><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="' . $this->prosespasien->getEmail(0) . '"><br>
        <label for="telp">Telepon:</label><br>
        <input type="telp" id="telp" name="telp" value="' . $this->prosespasien->getTelp(0) . '"><br>
        <input type="submit" name="ubah">';

        $this->tpl = new Template("templates/edit.html");
        $this->tpl->replace("UBAH_DATA", $data);
        $this->tpl->write();

    }

    function hapus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Proses data POST dari formulir
            $id = $_POST['id'];
            $this->prosespasien->hapusDataPasien($id);
        } else {
            $this->tpl = new Template("templates/hapus.html");
            $this->tpl->write();
        }
    }
}
