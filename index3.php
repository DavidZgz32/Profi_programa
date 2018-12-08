
 <?php 

session_start();

require_once 'BD2.php';
require_once 'jquery.html';

header("Content-Type: text/html;charset=windows-1252");

$objeto = new BD2();

$objeto->conectar();

   $servername = "localhost";
  $username = "user1pr";
  $password = "pwd1";
  $database = "u333999880_prest";

  $con = new mysqli($servername, $username, $password, $database);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Inseccion de productos</title>

	<!-- select picker -->


	<meta http-equiv="Content-type" content="text/html;charset=windows-1252" />

	<!-- bootstrap y jquery-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- jquery modal -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

	<link rel="stylesheet" href="estilos.css" />

</head>
<body style="background-color:#FBFAF3">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Profi</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Insertar</a></li>
      <li><a href="index2.php">Administracion productos</a></li>
      <li class="active"><a href="index3.php">Administracion familias</a></li>
      <li><a href="#modal1" rel="modal:open">FAQ</a></li>
    </ul>

  </div>
</nav>

<!-- Modal, ventana de dialogo -->
<div id="modal1" class="modal">
  <table>

<tr><td><b>Meta keywords</b></td><td>Palabras para la busqueda de google</td></tr>
<tr><td><b>Meta descripcion</b></td><td>Descripcion del producto cuando lo buscas en google</td></tr>
<tr><td><b>Visible en</b></td><td>Los sitios de la pagina donde se quiere mostrar (both)</td></tr>
<tr><td><b>Cantidad</b></td><td>Etiquetas para el buscador de la pagina</td></tr>
<tr><td><b>Resumen</b></td><td>Plazo de entrega, instalacion</td></tr>
<tr><td><b>Descripcion</b></td><td>Descripcion del pdf</td></tr>

  </table>
  <a href="#" rel="modal:close">Cerrar</a>
</div>

 <button class="btn btn-primary btn-sm" style="position:fixed;bottom:5px;right:5px;margin:0;padding:5px 3px;" onclick="window.scrollTo(0,document.body.scrollHeight);"> &darr; &darr; </button>
 <button class="btn btn-primary btn-sm" style="position:fixed;top:5px;right:5px;margin:0;padding:5px 3px;" onclick="window.scrollTo(0,document.body.scrollTo(0,0));"> &uarr; &uarr; </button>



<div class="container">
	
	


<!-- Seleccionar el valor de maquinaria o consumible -->

<table width="60%">
  <tr>
  		<td width="25%"><form method="POST" action="index3.php" id="inputSubfamilias" >Root: </td>
  			<td width="40%"><select name="value_familia" id="select">
  				<option value="">Selecciona....</option>
  				<option value="3">Maquinaria</option>
  				<option value="4"> Consumible</option>
  			</select></td>
  			<td><input type="submit" name="submit_familia">
  		</form></td>
   </tr>
</table>




<?php 

if(isset($_POST['submit_familia'])){
  $familia = $_POST['value_familia'];
}

//Consulta para ver los hijos de maquinaria o consumible

if(isset($familia)){

  $query2 = "SELECT * FROM ps_category WHERE id_parent=$familia";
 $result2 = mysqli_query($con, $query2);
 $columnas2 = [];
  while($row2 = mysqli_fetch_array($result2)){
      $columnas2[] = $row2;
  } 
}

?>

<?php

//Meto en el select los valores de la subfamilia seleccionada
echo "<table width='60%'><tr><td width='25%'><form method='POST' action='index3.php'>";
echo "Subfamilia1: "."</td><td width='40%'><select name='value_subfamilia'>";

//PARA CAMBIAR LOS ID POR NOMBRE //SUBFAMILIA1
for ($x=0; $x < count($columnas2); $x++) { 
  $query = "SELECT name FROM ps_category_lang WHERE id_category= '".$columnas2[$x]["id_category"]."'";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)){
       echo "<option value=".$columnas2[$x]["id_category"].">$row[0]</option>";
  }
}
    
echo "</td><td><input type='submit' name='submit_subfamilia'></select></form></td></tr></table>";


//Cuando se ha seleccionado en el select de subcatgoria1

if(isset($_POST['submit_subfamilia'])){

$subfamilia = $_POST['value_subfamilia'];

  $query3 = "SELECT * FROM ps_category WHERE id_parent=$subfamilia";
 $result3 = mysqli_query($con, $query3);
 $columnas3 = [];
  while($row3 = mysqli_fetch_array($result3)){
      $columnas3[] = $row3;
  } 
}

echo "<table width='60%'>"."<tr>"."<td width='25%'>";
echo "<form method='POST' action='index3.php'>";
echo "Subfamilia2: ";
echo "</td>";

echo "<td width='40%'>";
echo "<select name='value_subfamilia2'>";


//PARA CAMBIAR LOS ID POR NOMBRE //SUBFAMILIA2
for ($x=0; $x < count($columnas3); $x++) { 
  $query = "SELECT name FROM ps_category_lang WHERE id_category= '".$columnas3[$x]["id_category"]."'";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)){
       echo "<option value=".$columnas3[$x]["id_category"].">$row[0]</option>";
  }
}

echo "</td>";
echo "<td>";
echo "<input type='submit' name='submit_subfamilia2'>";
echo "</select>";
echo "</form>";
echo "</td></tr></table>";

//Ahora puede haber mas subcategorias o no
//EN CASO DE QUE NO HAYA MAS SUBCATEGORIAS ( MOSTRAR PRODUCTOS )

if(isset($_POST['submit_subfamilia2'])){

$subfamilia2 = $_POST['value_subfamilia2'];
$_SESSION["subfamilia22"] = $subfamilia2;

}





//MIRO SI HAY RESULTADOS

 $query4 = "SELECT * FROM ps_product WHERE id_category_default=$subfamilia2";
 $result4 = mysqli_query($con, $query4);
 $columnas4 = [];
  while($row4 = mysqli_fetch_array($result4)){
      $columnas4[] = $row4;
  } 


//Si ha interactuado con los select, mostrar los productos encontrados

if(isset($_POST["submit_subfamilia2"])){
  $_SESSION["productos_totales"] = count($columnas4);
}


    echo "Se han encontrado ". $_SESSION["productos_totales"]. " productos";




//EN CASO DE QUE HAYA MAS SUBCATEGORIAS ( MOSTRAR OTRAS CATEGORIAS )














  
  

 ?>




<br><br>

  <p>> Selecciona lo que quieres ver:</p>

  <form method="POST" action="index3.php">

  <table width="100%">
  <tr>
      <td><input type="checkbox" id="nombre" value="nombre" name="check[]">
      <label for="nombre">Nombre</label></td>

      <td><input type="checkbox" id="categorias" value="categorias" name="check[]">
      <label for="categorias">Categorias</label></td>

      <td><input type="checkbox" id="cantidad" value="cantidad" name="check[]">
      <label for="cantidad">Cantidad</label></td>

      <td><input type="checkbox" id="resumen" value="resumen" name="check[]">
      <label for="resumen">Resumen</label></td>

      <td><input type="checkbox" id="etiquetas" value="etiquetas" name="check[]">
      <label for="etiquetas">Etiquetas</label></td>
</tr>
<tr>
      <td><input type="checkbox" id="metaDescripcion" value="metaDescripcion" name="check[]">
      <label for="metaDescripcion">Meta Descripcion</label></td>

      <td><input type="checkbox" id="metaKeywords" value="metaKeywords" name="check[]">
      <label for="metaKeywords">Meta Keywords</label></td>

      <td><input type="checkbox" id="metaTitulo" value="metaTitulo" name="check[]">
      <label for="metaTitulo">Meta titulo</label></td>

      <td><input type="checkbox" id="caracteristicas" value="caracteristicas" name="check[]">
      <label for="caracteristicas">Caracteristicas</label></td>

      <td><input type="checkbox" id="descripcion" value="descripcion" name="check[]">
      <label for="descripcion">Descripcion</label></td>
</tr>
<tr>
      <td><input type="checkbox" id="marca" value="marca" name="check[]">
      <label for="marca">Marca</label></td>

       <td><input type="checkbox" id="precio" value="precio" name="check[]">
      <label for="precio">Precio</label></td>

       <td><input type="checkbox" id="youtube" value="youtube" name="check[]">
      <label for="youtube">Youtube</label></td>

      <td></td>

      <td></td>
 </tr>

 <tr>
 <td></td><td></td><td></td><td></td>
 <td><input style="padding: 5px;border-radius: 5px;width: 70%;" class="btn-success" type="submit" name="formularioCheckbox" value="Enviar consulta"></td>
 </tr>
</table>

  </form>

<p style="display:inline">> <b>Mostrando:</b></p>

<?php


//En este array tengo todos los ID de los productos que necesito
$arrayValores = [];

for ($z=0; $z < count($columnas4); $z++) { 
  $arrayValores[$z] = $columnas4[$z]["id_product"];
}


	if(isset($_POST['formularioCheckbox'])){


$query5 = "SELECT * FROM ps_product WHERE id_category_default='".$_SESSION["subfamilia22"]."'";
 $result5 = mysqli_query($con, $query5);
 $columnas5 = [];
  while($row5 = mysqli_fetch_array($result5)){
      $columnas5[] = $row5;
  } 

		foreach($_POST['check'] as $check) {
        echo "{$check}, ";
    }


    $listaCheck = implode(', ', $_POST['check']);
    //separo las palabras de la lista
    $lista_separada = explode (",", $listaCheck);

    //PONER LOS CHECKS MARCADOS EN UNA COOKIE
    $_SESSION['checks'] = $lista_separada;

echo "<br>";

//Formulario para actualizar
echo "<form method='POST' action='index3.php'>";
    
    //Recorro el for tantas veces coomo productos encontrados
  for ($i=1; $i <= $_SESSION["productos_totales"]; $i++) {
    echo "________________________________________________________________________________"."[ ".$i." ]";
    echo "<br>"."<br>";
    //Recorro otro for tantas veces como caracteristicas seleccionadas
    //PRECIO
    for ($x=0; $x < count($lista_separada); $x++) {
      if ($lista_separada[$x] == "precio" || $lista_separada[$x] == " precio" || $lista_separada[$x] == "precio "){
        $query = "SELECT price FROM ps_product_shop WHERE id_product= '".$columnas5[$i-1]["id_product"]."'";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            echo $lista_separada[$x].": <input id='inputFamilias' name='inputPrecio$i' value='".htmlspecialchars($row[0])."'></input>"."<br>"; //////////////
        }
      }
    }
    //NOMBRE
    for ($x=0; $x < count($lista_separada); $x++) {
      if ($lista_separada[$x] == "nombre" || $lista_separada[$x] == " nombre" || $lista_separada[$x] == "nombre "){
        $query = "SELECT name FROM ps_product_lang WHERE id_product= '".$columnas5[$i-1]["id_product"]."'";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            echo $lista_separada[$x].": <input id='inputFamilias' name='inputNombre$i' value='".htmlspecialchars($row[0])."'></input>"."<br>";
        }
      }
    }
    //CATEGORIAS
    for ($x=0; $x < count($lista_separada); $x++) {
      if ($lista_separada[$x] == "categorias" || $lista_separada[$x] == " categorias" || $lista_separada[$x] == "categorias "){
        $query = "SELECT id_category_default FROM ps_product WHERE id_product= '".$columnas5[$i-1]["id_product"]."'";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            echo $lista_separada[$x].": <input  id='inputFamilias' name='inputCategorias$i' value='".htmlspecialchars($row[0])."'></input>"."<br>";
        }
      }
    }
    //CANTIDAD
    for ($x=0; $x < count($lista_separada); $x++) {
      if ($lista_separada[$x] == "cantidad" || $lista_separada[$x] == " cantidad" || $lista_separada[$x] == "cantidad "){
        $query = "SELECT quantity FROM ps_stock_available WHERE id_product= '".$columnas5[$i-1]["id_product"]."'";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            echo $lista_separada[$x].": <input  id='inputFamilias' name='inputCantidad$i' value='".htmlspecialchars($row[0])."'></input>"."<br>";
        }
      }
    }
    //RESUMEN
    for ($x=0; $x < count($lista_separada); $x++) {
      if ($lista_separada[$x] == "resumen" || $lista_separada[$x] == " resumen" || $lista_separada[$x] == "resumen "){
        $query = "SELECT description_short FROM ps_product_lang WHERE id_product= '".$columnas5[$i-1]["id_product"]."'";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            echo $lista_separada[$x].": <input  id='inputFamilias' name='inputResumen$i' value='".htmlspecialchars($row[0])."'></input>"."<br>";
        }
      }
    }
    //ETIQUETAS
    for ($x=0; $x < count($lista_separada); $x++) {
      if ($lista_separada[$x] == "etiquetas" || $lista_separada[$x] == " etiquetas" || $lista_separada[$x] == "etiquetas "){
        $query = "SELECT name FROM ps_tag WHERE id_tag= 1";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            echo $lista_separada[$x].": <input  id='inputFamilias' name='inputEtiquetas$i' value='".htmlspecialchars($row[0])."'></input>"."<br>";
        }
      }
    }
   }//final for 1
	}else{
		echo "Ningun elemento seleccionado";
	}

  echo "<br>";
  echo "<input type='submit' class='btn-success' name='actualizarProductos' value='ACTUALIZAR'>";
  echo "</form>";

/*ACTUALIZAR PRODUCTOS*/

if(isset($_POST["actualizarProductos"])){

  //Saber que campos han sido seleccionados en el check



  $query = "SELECT * FROM ps_product WHERE id_category_default='".$_SESSION["subfamilia22"]."'";
  $result = mysqli_query($con, $query);
  $columnas = [];
  while($row = mysqli_fetch_array($result)){
      $columnas[] = $row;
  } 

  echo "<br><br>";
  echo "<div class='success'>Productos actualizados correctamente<br><br></div>";









  //PRECIO
  for ($i=1; $i <= $_SESSION["productos_totales"]; $i++) {
    $precio[$i] = $_POST["inputPrecio$i"];
    //echo "Precio $i: ".$precio[$i]."<br>";
    $query = "UPDATE ps_product SET price ='$precio[$i]' WHERE id_product = '".$columnas[$i-1]["id_product"]."'";
    $query2 = "UPDATE ps_product_shop SET price ='$precio[$i]' WHERE id_product = '".$columnas[$i-1]["id_product"]."'";
    $query3 = "UPDATE ps_layered_price_index SET price ='$precio[$i]' WHERE id_product = '".$columnas[$i-1]["id_product"]."'";
    echo "<br>";
    $result = mysqli_query($con, $query);
    $result = mysqli_query($con, $query2);
    $result = mysqli_query($con, $query3);
  }
  //NOMBRE
  for ($i=1; $i <= $_SESSION["productos_totales"]; $i++) { 
    $nombre[$i] = $_POST["inputNombre$i"];
    $query = "UPDATE ps_product_lang SET name ='$nombre[$i]' WHERE id_product = '".$columnas[$i-1]["id_product"]."'";
    echo "<br>";
    $result = mysqli_query($con, $query);
  }





}//Final if actualizar productos

//Que los checks marcados sigan marcados

for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == "nombre"){
    echo "<script>$('#nombre').prop('checked', true);</script>";
  }
  }

  for ($q=0; $q < count($_SESSION['checks']); $q++) {   
  if($_SESSION['checks'][$q] == " precio"){
    echo "<script>$('#precio').prop('checked', true);</script>";
  }
  }

  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " categorias" ){
    echo "<script>$('#categorias').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " cantidad" ){
    echo "<script>$('#cantidad').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " resumen" ){
    echo "<script>$('#resumen').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " metaDescripcion" ){
    echo "<script>$('#metaDescripcion').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " metaKeywords" ){
    echo "<script>$('#metaKeywords').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " metaTitulo" ){
    echo "<script>$('#metaTitulo').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " caracteristicas" ){
    echo "<script>$('#caracteristicas').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " descripcion" ){
    echo "<script>$('#descripcion').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " marca" ){
    echo "<script>$('#marca').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " precio" ){
    echo "<script>$('#precio').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " youtube" ){
    echo "<script>$('#youtube').prop('checked', true);</script>";
  }
  }
  for ($i=0; $i < count($_SESSION['checks']); $i++) {   
  if($_SESSION['checks'][$i] == " etiquetas" ){
    echo "<script>$('#etiquetas').prop('checked', true);</script>";
  }
  }



	?>



	<br>
	<br>

</div> <!-- DIV CONTAINER -->


<!--Footer-->
<footer class="page-footer font-small blue pt-4 mt-4" style="background-color: #4d4dff;color:white">

    <!--Footer Links-->
    <div class="container-fluid text-center text-md-left">
        <div class="row">

            <!--First column-->
            <div class="col-md-6">
                <h5 class="text-uppercase">Web realizada por David Marco</h5>
                <p>Esta web ha sido creada para la empresa Profi</p>
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-6" id="links">
                <h5 class="text-uppercase">Links</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="#">Profi</a>
                    </li>
                    <li>
                        <a href="#!">AML</a>
                    </li>
                    <li>
                        <a href="#!">PMA Product</a>
                    </li>
                    <li>
                        <a href="#!">Maquinaria post impresion</a>
                    </li>
                </ul>
            </div>
            <!--/.Second column-->
        </div>
    </div>
    <!--/.Footer Links-->

    <!--Copyright-->
    <div class="footer-copyright py-3 text-center" id="footer">
        &copy; 2018 Copyright:
        <a href=""> David Marco Garcia </a>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->


                      
                 

</body>
</html>