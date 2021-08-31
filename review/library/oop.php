<?php 

class oop{
	function login($con, $tabel, $username, $password, $redirect){ #parameter
		session_start();
		$sql =" SELECT * FROM $tabel WHERE username = '$username' and password = '$password' ";
		$jalan = mysqli_query($con, $sql);
		#mengetahui berapa jumlah baris di dalam tabel database yang dipanggil oleh perintah mysql_query()
		#sehingga nilai dapat ditampilkan dalam bentuk angka numerik.
		$cek = mysqli_num_rows($jalan);

		if ($cek > 0){ #jika datanya ada / benar maka
			$_SESSION['user'] = $username; #dia akan buat variabel user isinya username
			echo "<script>alert('Selamat datang $username');document.location.href = '$redirect' </script>";
		}else{
			echo "<script>alert('Username & Password salah !');document.location.href = 'index.php' </script>";
		}
	}

	function simpan($con, $tabel, array $field, $redirect){
		$sql = "INSERT INTO $tabel SET ";

		foreach($field as $key =>$value){
			$sql.=" $key = '$value',";
		}
		$sql = rtrim($sql,',');
		$jalan = mysqli_query($con,$sql);

		if($jalan){
			echo "<script>alert('Data Berhasil Disimpan');document.location.href='$redirect'</script>";
		}else{
			echo "<script>alert('Data Gagal Disimpan');document.location.href='$redirect'</script>";
		}
	}

	function tampil($con, $tabel){
		$sql ="SELECT * FROM $tabel";
		$jalan = mysqli_query($con, $sql);
		while($data = mysqli_fetch_assoc($jalan))
			$isi[] = $data;
		return @$isi;
	}

	function hapus($con, $tabel, $where, $redirect){
		$sql = "DELETE FROM $tabel WHERE $where";
		$jalan = mysqli_query($con, $sql); #eksekusi
		if($jalan){
			echo "<script>alert('Data Berhasil Dihapus');document.location.href='$redirect'</script>";
		}else{
			echo "<script>alert('Data Gagal Dihapus');document.location.href='$redirect'</script>";
		}
	}
	
	function edit($con, $tabel, $where){
		$sql = "SELECT * FROM $tabel WHERE $where";
		$jalan = mysqli_query($con, $sql); #eksekusi
		$tampung = mysqli_fetch_assoc($jalan); #assoc itu asosiatif harus nama field,
		return $tampung; #kalo fetch_array itu indexnya
	}

	function ubah($con,$tabel, array $field, $where, $redirect){
		$sql = "UPDATE $tabel SET ";
		foreach($field as $key => $value){ #melakukan perulangan 
			$sql.=" $key = '$value',"; # . untuk menggabungkan
		}
		$sql = rtrim($sql,','); #rtrim membuang atau menghapus karakter khusus
		$sql.=" WHERE $where";
		$jalan = mysqli_query($con,$sql);

		if($jalan){
			echo "<script>alert('Data berhasil diubah');document.location.href='$redirect'</script>";
		}else{
			echo "<script>alert('Data gagal diubah');document.location.href='$redirect'</script>";
		}
	}

	function upload($foto,$tempat){
		$alamat = $foto['tmp_name'];
		$namafile = $foto['name'];
		move_uploaded_file($alamat,"$tempat/$namafile");
		return $namafile;
	}

}

 ?>