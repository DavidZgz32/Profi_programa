<?php 

require_once 'BD.php';
require_once 'jquery.html';

header("Content-Type: text/html;UTF-8");

$objeto = new BD();

$objeto->conectar();

if(!isset($_SESSION["producto"])){
	$_SESSION["producto"] = "";
	}

	//Numero de columnas antes de la columna modelo

	$servername = "localhost";
	$username = "user1";
	$password = "pwd1";
	$database = "u333999880_maq";
	$con = new mysqli($servername, $username, $password, $database);
	$query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='u333999880_maq' AND `TABLE_NAME`='".$_SESSION["familia"]."'";
	$result = mysqli_query($con, $query);
	$c = 0;
	while ($row = mysqli_fetch_array($result)){
		if($row[0] == "Nombre" || $row[0] == "nombre"){
			break;
		}
		$c++;
	}
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<title><?php  echo strtoupper($_SESSION['producto']) ?></title>

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
      <li class="active"><a href="#">Insertar</a></li>
      <li><a href="index2.php">Administracion productos</a></li>
      <li><a href="index3.php">Administracion familias</a></li>
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
<b>¿Con qué propósito ha sido creada la web?</b>
<p>La web ha sido creada para gestionar.....</p>
<b>¿En que lenguajes de programación está escrita?</b>
<p>En php....</p>

  </table>
  <a href="#" rel="modal:close">Cerrar</a>
</div>

 <button class="btn btn-primary btn-sm" style="position:fixed;bottom:5px;right:5px;margin:0;padding:5px 3px;" onclick="window.scrollTo(0,document.body.scrollHeight);"> &darr; &darr; </button>
 <button class="btn btn-primary btn-sm" style="position:fixed;top:5px;right:5px;margin:0;padding:5px 3px;" onclick="window.scrollTo(0,document.body.scrollTo(0,0));"> &uarr; &uarr; </button>

<div class="container">
		<h3>Inserci&oacute;n de datos [ Usuario: ]</h3><br>


		Elige una familia: 
		<form method="POST" action="BD.php">
			<select name="nombreFamilia" >
				<option value="">Selecciona....</option>
				<?php $objeto->mostrarTablas(); ?>
			</select>
			<input type="submit" name="submit_familia">
		</form>
		<br>
		Producto: 
		<form method="POST" action="BD.php">
			<select name="nombreProducto" >
				<option value="">Selecciona....</option>
				<?php 

				if(isset($_SESSION["familia"])){

				$objeto->mostrarSelect($_SESSION["familia"],$c); 

				}else{

				}

				?>
			</select>
			<input type="submit" name="submit_producto">
		</form>


		<br>

		<form action="subir_archivo.php" method="post" enctype="multipart/form-data">
    Selecciona el pdf para subir:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Subir pdf" name="submit">
</form>


<?php 
	//si existe la sesion muestro mensaje y la desrtuyo para que no se muestre todo el rato 
	if(isset($_SESSION['subida'])){
	echo "<p style='color:green'>".$_SESSION['subida']."</p>";
	unset($_SESSION['subida']);
	} ?>

<div class="caracteristicasF">





<?php

	if(isset($_SESSION["familia"])){




	//$columnas = $objeto->mostrarColumnas("guillotinas");
	//$contador = $objeto->contarColumnas("guillotinas"); 
    $columnas = $objeto->mostrarColumnas($_SESSION["familia"]);
	$contador = $objeto->contarColumnas($_SESSION["familia"]); 

	$contador = $contador[0]-1; 

	$servername = "localhost";
	$username = "user1";
	$password = "pwd1";
	$database = "u333999880_maq";

	$con = new mysqli($servername, $username, $password, $database);



	echo "<h3><b>A&ntilde;adiendo: ".$_SESSION["familia"]." > ".strtoupper($_SESSION['producto'])."</b></h3>";

	if(isset($_SESSION['producto'])){ //Si no se ha seleccionado un producto no muestra nada

	?>

	<table class="table" id="tablaPrueba">

		<?php



		$caracteristicas = "";	//el campo de caracteristicas
		$numero = 0; //la posicion que tendra la caracteristica
		//CONTADOR es el nunmero de tablas
		//COLUMNAS es el nombre de cada columna ($columnas[nombre][posicion])
		//$i es 2 porque cojo desde Modelo e ignora los 2 siguientes campos, precio y categoria
		for ($i=2; $i < $contador-$c; $i++) { 
			
		//imprimo el nombre de cada columna
		echo "<tr><td> ".$columnas[$i+$c+1][0]."</td>";

		//Selecciono el nombre de la columna from familia(select) where nodelo(select) GROUP BY nombre de la columna 
		$query = "SELECT `".$columnas[$i+$c+1][0]."` FROM `".$_SESSION['familia']."` WHERE `Nombre`='".$_SESSION['producto']."' GROUP BY `".$columnas[$i+$c+1][0]."`";

		$result = mysqli_query($con, $query);

		echo '<td><select id="select_dato'.$i.'" name="select_dato'.$i.'">';

				while($row = mysqli_fetch_array($result)){

					//Le sumo a $opcion el valor de los campos 
					$opcion=$row[$columnas[$i+$c+1][0]];

					if($opcion == "-"){ //si la opcion es vacia se rompe el while
						break;
					}


				    echo '<option value="'.$i.'">'.$opcion.'</option>';

				    //Le sumo a caracteristicas ( NombreColumna : Select : Posicion )
				    $caracteristicas.=$columnas[$i+$c+1][0].":".$opcion.":".$numero.",";

				    $numero++;
					}
				echo '</select></td></tr>';
				

		} //final for

		}else{
			echo "Selecciona un producto";
		}


		?>

	</table>


	<?php
		$caracteristicas = substr($caracteristicas, 0, -1);

		echo "<textarea class='form-control' style='min-width: 100%''>$caracteristicas</textarea>";

	}else{ //isset de familia

	}
?>
</div> <!-- div caracteristicas2 -->


<br>


<form method="POST" action="BD.php">


	<div class="form-group row">
	    <label class="col-lg-2 col-form-label">Id</label>
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputId" placeholder="Id" value="<?php $objeto->consultaIdProducto($_SESSION['producto'],$_SESSION['familia']); ?>">
	    </div>

	    <label class="col-lg-2 col-form-label text-right">Activo</label>
	    <div class="col-lg-2">
	       <input type="text" class="form-control" name="activo" placeholder="Nombre" value="1">
	    </div>

	    <label class="col-lg-2 col-form-label text-right">Disponible para pedidos</label> 
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputDisponible" value="1">
	    </div>
	</div>
	<div class="form-group row">
	  	   
	    <label class="col-lg-2 col-form-label">Mostrar precio</label>
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputMostrarPrecio" value="1">
	    </div>

	   
	    <label class="col-lg-2 col-form-label text-right">Cantidad</label>
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputCantidad" placeholder="Cantidad del producto" value="9999">
	    </div>

		<label class="col-lg-2 col-form-label text-right">Nombre</label>
	    <div class="col-lg-2">
	       <input type="text" class="form-control" name="inputNombre" placeholder="Nombre" value="<?php $objeto->consulta($_SESSION['producto'],$_SESSION['familia']); ?>">
	    </div>


	</div>
	<div class="form-group row">
			<label class="col-lg-2 col-form-label">Visible</label>
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputVisible" value="both">
	    </div>

	    <label class="col-lg-2 col-form-label text-right">Precio</label>
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputPrecio" value="<?php $objeto->consultaPrecio($_SESSION['producto'],$_SESSION['familia']); ?>">
	    </div>

	    <label class="col-lg-2 col-form-label text-right">Categoria</label>
	    <div class="col-lg-2">
	      <input type="text" class="form-control" name="inputCategoria" value="<?php $objeto->consultaCategoria($_SESSION['producto'],$_SESSION['familia']); ?>">
	    </div>
	   

	</div>
	<div class="form-group row">
	    

	   
	    <label class="col-lg-2 col-form-label">Caracteristicas</label>
	    <div class="col-lg-10">
	      <input type="text" class="form-control" name="caracteristicas" value="<?php echo $caracteristicas ?>">
	    </div>
	   
	    <label class="col-lg-2 col-form-label">Descripcion</label>
	    <div class="col-lg-10">
	      <input type="text" class="form-control" name="inputDescripcion" placeholder="Descripcion del pdf">
	    </div>

	   
	    <label class="col-lg-2 col-form-label">Marca</label>
	    <div class="col-lg-10">

	      <select class="form-control" name="inputMarca">

	      <optgroup label="Mas usadas"></optgroup>
		      <option value="PMA Product">PMA Product</option>
		      <option value="Cyklos">Cyklos</option>
		      <option value="Neolt">Neolt</option>
		      <option value="Grafcut">Grafcut</option>
	      </optgroup>

	      	<optgroup label="Alfabeticamente">
		      	<option value="Boway">Boway</option>
		      	<option value="Champion">Champion</option>
		      	<option value="Graphtec">Graphtec</option>
		    	<option value="GMP">GMP</option>
			    <option value="Heat Press">Heat Press</option>
			    <option value="Loches">Loches</option>
			    <option value="Neofold">Neofold</option>
			    <option value="Onglematic">Onglematic</option>
				<option value="Qupa">Qupa</option>
	 			<option value="Rapid">Rapid</option>
	 			<option value="Sopu">Sopu</option>
	 			<option value="Smipack">Smipack</option>
	 			<option value="Secabo">Secabo</option>
				<option value="Stago">Stago</option>
				<option value="Tauler">Tauler</option>
				<option value="Vansda">Vansda</option>
			    <option value="Wire-o Binder">Wire-o Binder</option>     
		  </optgroup>



	      </select>
	    </div>

	   
	    <label class="col-lg-2 col-form-label">Meta Keywords</label>
	    <div class="col-lg-10">
	      <input type="text" class="form-control" name="inputMK"  value="<?php $objeto->consulta($_SESSION['producto'],$_SESSION['familia']); ?>">
	    </div>

	   
	    <label class="col-lg-2 col-form-label">Meta titulo</label>
	    <div class="col-lg-10">
	      <input type="text" class="form-control" name="inputMT" placeholder="Palabras no tecnicas para el producto">
	    </div>

	   
	    <label class="col-lg-2 col-form-label">Meta descripcion</label>
	    <div class="col-lg-10">
	      <input type="text" class="form-control" name="inputMD" placeholder="Descripcion que sale en google al buscar el producto">
	    </div>


	</div>
	<div class="form-group row">
	    <label class="col-lg-2 col-form-label">Plazo de entrega</label>
	    <div class="col-lg-4">
	      <select class="form-control" name="selectPlazoDeEntrega">
	      	 	<option value="Disponible">Disponible</option>
  				<option value="Consultar">Consultar</option>
	      </select>
	    </div>
	    <label class="col-lg-2 col-form-label text-right">Instalacion</label>
	    <div class="col-lg-4">
	      <select class="form-control" name="selectInstalacion">
	      	 	<option value="Incluida">Incluida</option>
  				<option selected value="No requiere">No requiere</option>
  				<option value="Telefonica">Telefonica</option>
  				<option value="Consultar">Consultar</option>
	      </select>
	    </div>
	</div>
	<div class="form-group row">


	    
	    <label class="col-lg-2 col-form-label">Etiquetas</label>
	    <div class="col-lg-10">
	      <input type="text" class="form-control" name="inputEtiquetas" placeholder="Palabras para el buscador" value="">
	    </div>


	   

	 <div class="form-group row">
	 	<div class="col-lg-1">
		<input type="submit" class="btn btn-primary" value="A&ntilde;adir bbdd y vista previa" name="form1">
		</div>
	</div>

</form>


<?php


		//COMBINACIONES
		//Nombres de las columnas de combinaciones

		$tabla = $_SESSION['familia'];
		$producto = $_SESSION['producto'];

		$query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA`='u333999880_maq' AND `TABLE_NAME`='$tabla' LIMIT $c";

		//"SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='u333999880_maq' AND `TABLE_NAME`='$columna'";
		$result = mysqli_query($con, $query);
		$colCombinacion = [];
		$idproducto = [];
		while($row = mysqli_fetch_array($result)){
			$colCombinacion[] = $row;
		}

		//Nombres de las tablas de combinaciones
		//echo $colCombinacion[0][0];


		$query2 = "SELECT COUNT(`idProducto`) FROM `$tabla` WHERE `Nombre` = '$producto'";

		$result2 = mysqli_query($con, $query2);

		$contador2 = mysqli_fetch_row($result2);

		//echo $contador2[0]." ..... ";


		//Numero de resultados de combinaciones de un producto
		$query = "SELECT `idProducto` FROM `$tabla` WHERE `Nombre` = '$producto'";

		$result = mysqli_query($con, $query);

		while($row = mysqli_fetch_array($result)){
			$idproducto[] = $row;
		}

	
		//imprimir todos los productos cuyo id es el que
		
			$valoresCombinacionProducto = [];

			//descartar errores
			if(isset($idproducto[0][0])){


		for ($i=0; $i < $c; $i++) { 

			//Si el precio de combinacion es 0 no hace la consulta
			$query = "SELECT * FROM `".$tabla."` WHERE `idProducto` = ".$idproducto[0][0]." AND `PrecioCombinacion` NOT LIKE 0";

			//echo $query;
			

			$result = mysqli_query($con, $query);
			
			

			while($row = mysqli_fetch_array($result)){

				//array desordenador
				$valoresCombinacionProducto[] = $row[$i];
			}
		
		}
		
			}else{
				
			}



		$numcombinaciones=$contador2[0];
		$combinaciones=count($valoresCombinacionProducto)/$contador2[0];

	for ($i=0; $i < $numcombinaciones; $i++) { 
			for ($a=0; $a < $combinaciones ; $a++) { 
			$z=$i+($a*$numcombinaciones);
			//echo "matriz[$i][$a]=array[$z]";

			$matriz[$i][$a] = $valoresCombinacionProducto[$z];

			//echo $matriz[$i][$a]." / ";
		}

//		echo "<br>";

	}

	$sentenciaAtributo = "";
	$sentenciaValor = "";
	$nombreTienda = "";
	$queryResultado = "";
	$queryResultadoMultitienda = "";

	for ($i=0; $i < $numcombinaciones; $i++) { 
		//Saco el ID
		$idProducto = $matriz[$i][$c-1];
		
		$precio = $matriz[$i][$c-2];

		$contador = 0;


		//C es el numero de combinaciones que hay, pongo -2 porque quito id y precio
		for ($z=0; $z < $c-2; $z++) { 
			if($matriz[$i][$z] != "-"){

				//echo $idProducto."<br>";
				//echo $precio."<br>";

				//saco el nombre de la columna
				$atributo = $colCombinacion[$z][0].":select:".$contador.",";

				$valor = $matriz[$i][$z].":".$contador.",";



				$sentenciaAtributo = $sentenciaAtributo.$atributo;

				$sentenciaValor = $sentenciaValor.$valor;

				$contador++;

				
			}

			
		}
			$sentenciaAtributo = substr($sentenciaAtributo, 0, -1);

			$sentenciaValor = substr($sentenciaValor, 0, -1);

			//echo $sentenciaAtributo."<br>";
			//echo $sentenciaValor."<br><br>";

			//PARA UNA TIENDA
			$query = "INSERT INTO `datoscombinaciones`(`idproducto`, `atributo`, `valor`, `impactoprecio`, `cantidad`) VALUES ($idProducto,'$sentenciaAtributo','$sentenciaValor',$precio,999)";

			$queryResultado = $queryResultado.$query.";";

			//echo $query."<br>";

			//$result = mysqli_query($con, $query);


			for ($p=0; $p < 3; $p++) { 

			if ($p == 0){
				$nombreTienda = "PMA Product";
			}else if($p == 1){
				$nombreTienda = "AML";
			}else if($p == 2){
				$nombreTienda = "Profi";
			}

			//PARA MULTITIENDA
			$query2 = "INSERT INTO `datoscombinacionesMultitienda`(`idproducto`, `atributo`, `valor`, `impactoprecio`, `cantidad`,`idtienda`) VALUES ($idProducto,'$sentenciaAtributo','$sentenciaValor',$precio,999,'$nombreTienda')";

			$queryResultadoMultitienda = $queryResultadoMultitienda.";".$query2;
			
			//$result = mysqli_query($con, $query2);
			
			//echo $query2."<br>";
			
			}


	$sentenciaAtributo = "";
	$sentenciaValor = "";

		
			
		}

		echo $queryResultado."<br>";

		echo $queryResultadoMultitienda;

	



?>


	

	  </div>

<form action="BD.php" method="POST" >
    <input type='hidden' name='query1' value="<?php echo $queryResultado; ?>"/>
    <input type='hidden' name='query2' value="<?php echo $queryResultadoMultitienda; ?>"/>
    <input type="submit" name="subirCombinaciones" value="subir combinaciones" >
</form>


<?php 





 ?>


<br><br>



		<div class="form-group row">
	    <label class="col-lg-1 col-form-label">Mostrar</label>
	    <div class="col-lg-2">
	      <select class="form-control" name="selectInstalacion">
	      	 	<option value="3">3</option>
  				<option value="10">10</option>
  				<option value="25">25</option>
  				<option value="50">50</option>
	      </select>
	    </div>
	    </div>




<!-- valor campo 1 -->


<div class="table-responsive">

	<table class="table">
		<?php $objeto->displayTabla(); ?>
	</table>

</div>

<form method="post" action="exportar.php">
     <input type="submit" name="exportar" class="btn btn-success" value="Exportar" />
    </form>

<br>

	</div> <!-- DIV CONTAINER -->

<!--Footer-->
<footer class="page-footer font-small blue pt-4 mt-4" style="background-color: #4d4dff;color:white">

    <!--Footer Links-->
    <div class="container-fluid text-center text-md-left">
        <div class="row">

            <!--First column-->
            <div class="col-md-6">
                <h5 class="text-uppercase">Web realizada por David</h5>
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
                        <a href="#!">u333999880_maq post impresion</a>
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