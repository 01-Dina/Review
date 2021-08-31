<?php 
//manggil file koneksi.php yg ada di dlm folder config
include "config/koneksi.php";

//manggil file oop.php yg ada di dlm folder library
include "library/oop.php";

//$go mewakili kelas oop
$go = new oop();
$tabel ='product';
$tanggal = date('Y-m-d');
$redirect = '?menu=product';
@$where = "productID = $_GET[id]";
$tempat = "foto";
//simpan
if(isset($_POST['simpan'])){ #post untuk mengirimkan data/nilai langsung ke action, untuk dtmpng
  //$foto mewakili inputan foto
  $foto = $_FILES['foto'];
  //menjalankan fungsi upload
  $upload = $go->upload($foto,$tempat);
  
  if(empty($_FILES['foto']['name'])){
      $field = array('nama'=> @$_POST['nama'], 
               'jenisID' => @$_POST['jenis'], 
               'tglInput' => $tanggal, 
               'ket' => @$_POST['ket']);
      $go->simpan($con, $tabel, $field, $redirect);               
  }else{
      $field = array('nama'=> @$_POST['nama'], 
               'jenisID' => @$_POST['jenis'],
               'foto' => '$upload', 
               'tglInput' => $tanggal, 
               'ket' => @$_POST['ket']);
      $go->simpan($con, $tabel, $field, $redirect);
  }
}

if(isset($_GET['hapus'])){ #get untuk mnmpilkn data/nilai pada url 
	$go->hapus($con, $tabel, $where, $redirect);
}

if(isset($_GET['edit'])){
	$edit = $go->edit($con, $tabel, $where);
}

if(isset($_POST['update'])){
	$go->ubah($con,$tabel, $field, $where, $redirect); #memanggil function
	#ubah itu variabel
	#mengambil variabel
}


?>
<form method="post">

<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" value="<?php echo @$edit['nama'] ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Jenis</label>
    <select name="jenis" class="form-control">
        <option></option>

        <?php
            $sql = mysqli_query($con, "SELECT * FROM jenis");
            while($r=mysqli_fetch_assoc($sql)){
        ?>    
        <option value="<?php echo $r['jenisID']?>"><?php echo $r['jenis'] ?></option>
        <?php } ?>

    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Foto</label>
    <input type="file" name="foto" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea name="ket" class="form-control"><?php echo @$edit['ket'] ?></textarea>
  </div>

  <?php if(@$_GET['id']==""){ ?>
    <button type="submit" class="btn btn-primary" name="simpan">SIMPAN</button>
  <?php }else{ ?>
  <button type="submit" class="btn btn-success" name="update">UPDATE</button>
  <?php } ?>
</form>


<br>
<table id="example" class="display" style="width:100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Jenis</th>
			<th>Aksi</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		$a = $go->tampil($con, $tabel); #a mewakili data 
		$no = 0;

		if($a == ""){
			echo "<tr> <td colspan='5' align='center'>No Record</td> </tr>";
		}else{

		foreach($a as $r){
		$no++; #onclik untuk mengecek even, ddan menkorfirmasi
	?>
	
	<tr>
		<td><?php echo $no ?></td> 
		<td><?php echo $r['jenis'] ?></td> 
		<td><a href="?menu=jenis&hapus&id=<?php echo $r['jenisID'] ?>" onclick="return confirm('Hapus data <?php echo $r['jenis']?> ?')">Hapus</a></td>
		<td><a href="?menu=jenis&edit&id=<?php echo $r['jenisID'] ?>">Edit</a></td>
	</tr>
	<?php } }?>

	</tbody>
</table>
