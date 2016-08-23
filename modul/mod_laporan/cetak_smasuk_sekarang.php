<?php

error_reporting(0);

$timezone = "Asia/Jakarta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
error_reporting(0);
include "../../plugin/mpdf/mpdf.php";
include "../../config/koneksi.php";
$mpdf = new mPDF('utf-8','A4');

ob_start();

$t 	= (date("Y-m-d"));
$no = 1;
$sql=mysql_query("SELECT * FROM skeluar where tMasuk='$t' ");
?>

<html>
<head><title></title>
	<style type="text/css">
	p{
		text-align:center;
		font-size:12px;
		font-weight:bold;
		font-family:Arial, Helvetica, sans-serif;
		color:#000066;
	}
	body{
		font-size:10px;
		font-family:Arial, Helvetica, sans-serif;	
	}
	
	table{
		border-style:solid;
		border-width:thin;
		border-spacing:inherit;
	}
	
	tr{
		text-align:center;
		font-weight:bold;
	}
	
	td{


	}
	
	
	
	</style>
</head>
</body>

<?php

echo '<p>DAFTAR SURAT MASUK PER TANGGAL: '.$t.'</p>
<table border=1 repeat_header=1 width=100%>
<thead>
<tr>
<th style="text-align:center; font-weight:bold;">No.</td>
<th style="text-align:center; font-weight:bold;">Jenis</td>
<th style="text-align:center; font-weight:bold;">No. Agenda</td>
<th style="text-align:center; font-weight:bold;">Kontrol</td>
<th style="text-align:center; font-weight:bold;" width=10px>Sifat</td>
<th style="text-align:center; font-weight:bold;">Lampiran</td>
<th style="text-align:center; font-weight:bold;">Penerbit</td>
<th style="text-align:center; font-weight:bold;" width=200px>Kepada</td>
<th style="text-align:center; font-weight:bold;">Perihal</td>
<th style="text-align:center; font-weight:bold;">Keterangan</td>
</tr>
</thead>';


while($r=mysql_fetch_assoc($sql)){
	echo '<tr>
	<td align=right>'.$no.'</td>
	<td>'.$r[jSurat].'</td>
	<td>'.$r[nAgenda].'</td>
	<td>'.$r[nKontrol].'/'.[periode].'</td>
	<td>'.$r[uSifat].'</td>
	<td>'.$r[jLampiran].'</td>
	<td>'.$r[penerbit].'</td>
	<td>'.$r[kepada].'</td>
	<td>'.$r[hal].'</td>
	<td>'.$r[ket].'</td>	
	</tr>';
	$no++;
}
?>
</table>
</body>
</html>	

<?php
$html	= ob_get_contents();
ob_end_clean();
$mpdf->setFooter('Generate by: Aplikasi SPARTAN || Hal:{PAGENO}');
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf",'I');
exit;
}
?>
