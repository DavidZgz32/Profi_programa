
<?php

session_start();

$target_dir = "PDFS/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    }
}
// Si ya existia
if (file_exists($target_file)) {
    $_SESSION['subida'] = "El archivo ya existia";
    header("Location: index.php");
    $uploadOk = 0;
}
// Tamaño del archivo
if ($_FILES["fileToUpload"]["size"] > 50000000000000) {
    $_SESSION['subida'] = "Archivo subido correctamente";
    $uploadOk = 0;
    header("Location: index.php");
}

// 0 si hay un error
if ($uploadOk == 0) {
    echo "El archivo era demasiado grande";
} else {
	$target_file = "PDFS/".$_SESSION['producto'].".pdf";
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	$_SESSION['subida'] = "Archivo subido correctamente";
        header("Location: index.php");
    } else {
        $_SESSION['subida'] = "Ha habido un error";
        header("Location: index.php");
    }
}
?>
?>
