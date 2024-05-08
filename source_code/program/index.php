<?php

/******************************************
Asisten Pemrogaman 13
 ******************************************/

include("model/Template.class.php");
include("model/DB.class.php");
include("model/Pasien.class.php");
include("model/TabelPasien.class.php");
include("view/TampilPasien.php");


$tp = new TampilPasien();
if (isset($_GET['tambah'])) {
    $data =$tp->tambah(); 
} elseif (isset ($_GET['ubah'])) {
    $id = $_GET['ubah'];
    $data = $tp->ubah($id);
} else {
    $data = $tp->tampil();
}