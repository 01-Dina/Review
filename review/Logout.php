<?php
    @session_start();    //untuk memulai session
    @session_destroy(); //untuk menghancurkan session
    echo "<script>alert('Selamat tinggal');document.location.href='index.php'</script>"; #setelah session
    # destroy lalu diarahkan ke sini
?>