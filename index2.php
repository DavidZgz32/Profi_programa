<?php 

require_once 'BD.php';
require_once 'jquery.html';

$objeto = new BD();

$objeto->conectar();

 ?>

<!DOCTYPE html>
<html>
<head>

	<!-- bootstrap y jquery-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- jquery modal -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

	<link rel="stylesheet" href="estilos.css" />

</head>

<?php


   $servername = "localhost";
  $username = "user1pr";
  $password = "pwd1";
  $database = "u333999880_prest";

	$con = new mysqli($servername, $username, $password, $database);

	

	if ($con->connect_error) {
	    die("Conexion fallida: " . $con->connect_error);
	}else{
		//echo "bien";
	}


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Administracion de productos</title>
 </head>
<body style="background-color:#FBFAF3">












<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Profi</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Insertar</a></li>
      <li class="active"><a href="index2.php">Administracion productos</a></li>
      <li><a href="index3.php">Administracion familias</a></li>
      <li><a href="#modal1" rel="modal:open">FAQ</a></li></li>
    </ul>

  </div>
</nav>


<div class="container">

 <h3>Administración de productos</h3>
<form method="POST" action="index2.php">

<input type="text" name="nombre" placeholder="nombre producto a buscar">
<input type="submit" name="submit">

</form>

<?php 



if(isset($_POST['nombre'])){
	$nombre = $_POST['nombre'];
	echo "<h3>Mostrando el producto: ".$nombre."</h3>";
}else{
  echo "<br>Introduce el nombre del producto a buscar....";
}



?>

<br>

<?php 

if(isset($_POST['nombre'])){

$query = "SELECT * FROM ps_product_lang WHERE name='$nombre'";

$result = mysqli_query($con, $query);

	$columnas = [];

	while($row = mysqli_fetch_array($result)){
	    $columnas[] = $row;
	}

}

?>


<?php 

if(isset($_POST['nombre'])){

 ?>

<form>

  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas[0]["name"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Descripcion</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas[0]["description"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Resumen</label>
    <div class="col-sm-10">
      <textarea class="form-control"><?php echo $columnas[0]["description_short"]; ?></textarea>
    </div>
  </div>


  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Meta descripcion</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas[0]["meta_description"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Meta keywords</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas[0]["meta_keywords"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Meta titulo</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas[0]["meta_title"]; ?>">
    </div>
  </div>






<?php

 $query2 = "SELECT * FROM ps_product WHERE id_product=".$columnas[0]["id_product"]."";
 $result2 = mysqli_query($con, $query2);
 $columnas2 = [];
  while($row2 = mysqli_fetch_array($result2)){
      $columnas2[] = $row2;
  } 

$query3 = "SELECT * FROM ps_product_videos WHERE id_product=".$columnas[0]["id_product"]."";
 $result3 = mysqli_query($con, $query3);
 $columnas3 = [];
  while($row3 = mysqli_fetch_array($result3)){
      $columnas3[] = $row3;
  } 

  $query4 = "SELECT * FROM ps_stock_available WHERE id_product=".$columnas[0]["id_product"]."";
 $result4 = mysqli_query($con, $query4);
 $columnas4 = [];
  while($row4 = mysqli_fetch_array($result4)){
      $columnas4[] = $row4;
  } 




  ?>



  <div class="form-group row">
    <label for="inputPrecio" class="col-sm-2 col-form-label">Precio</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas2[0]["price"]; ?>">
    </div>
  </div>
   <div class="form-group row">
    <label for="inputReferencia" class="col-sm-2 col-form-label">Referencia</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas2[0]["reference"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputCantidad" class="col-sm-2 col-form-label">Cantidad</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas4[0]["quantity"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputVideo" class="col-sm-2 col-form-label">Video youtube</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" value="<?php echo $columnas3[0]["video_url"]; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputVideo" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <?php
       $video = $columnas3[0]["id_video"]; 
       $video2 = "https://www.youtube.com/embed/".$video;
        ?> 
       <iframe width="420" height="315" src="<?php echo $video2 ?>"></iframe>
    </div>

    <?php
         $pdf = "http://www.pmaproduct.org/PDF/".$columnas[0]["name"].".pdf";
       ?>
<div class="form-group row">
    <label for="inputVideo" class="col-sm-2 col-form-label">PDF:</label>
    <div class="col-sm-10">
      <object id="pdf-producto" data="<?php echo $pdf ?>" width="100%" height="250px"></object>
    </div>
  </div>

  </div>
  <div class="form-group row">
      <input type="submit" class="form-control btn btn-success" id="" value="Actualizar">
  </div>
</form>

<?php 

}else{

}

 ?>


</div> <!-- DIV CONTAINER -->
 </body>
 </html>