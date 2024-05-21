<?php

    function getSingleImage($package_id){
        include 'koneksi.php';
        //getting multiple image from database..
        $stmt = $pdo->prepare('SELECT place_images FROM packages WHERE package_id = :package_id');
        $stmt->execute([':package_id' => $package_id]);
        $img = $stmt->fetchColumn();
        //convert string to array
        $img = explode(',', $img);
        //replace the special character to space
        $search = ["(", "'", ")" ];
        $place_img = str_replace($search, '', $img[0]);

        return $place_img;
    }

    function readPackage($package_id){
        include 'koneksi.php';
        
        //Package Name Read Query
        $stmt = $pdo->prepare('SELECT * FROM tb_paket WHERE id_paket = :id_paket');
        $stmt->execute([':id_paket' => $package_id]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);

        return $package;
    }

    function readAgency($agency_id){
        include 'koneksi.php';
        //read Specific agency data
        $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_id = :agency_id');
        $stmt->execute([':agency_id'   => $agency_id ]);
        $agency = $stmt->fetch(PDO::FETCH_ASSOC);

        return $agency;
    }

    function readTourist($tourist_id){
        include 'koneksi.php';

        //read tourist name
        $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE id_user = :id_user');
        $stmt->execute([':id_user' => $tourist_id]);
        $tourist = $stmt->fetch(PDO::FETCH_ASSOC);

        return $tourist;
    }

    function readBook($book_id){
        include 'koneksi.php';

        //read tourist name
        $stmt = $pdo->prepare('SELECT * FROM tb_pesanan WHERE id_pesanan = :id_pesanan');
        $stmt->execute([':id_pesanan' => $book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book;
    }

    
?>