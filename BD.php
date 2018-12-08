 <?php

 session_start();

class BD { 

	private $servername = "localhost";
	private $username = "user1";
	private $password = "pwd1";
	private $database = "u333999880_maq";

function conectar (){

	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	mysqli_set_charset($con, "windows-1252");

	if ($con->connect_error) {
	    die("Conexion fallida: " . $con->connect_error);
	}else{
		//echo "Bienvenido";
	}

	return $con;

}


function mostrarTablas (){

	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT table_name FROM information_schema.tables  WHERE table_schema = 'u333999880_maq' AND table_name NOT LIKE 'datos' AND table_name NOT LIKE 'datoscombinaciones' AND table_name NOT LIKE 'datoscombinacionesmultitienda' AND table_name NOT LIKE 'usuarios'";

	$result = mysqli_query($con, $query);

	$opciones = "";

	while ($row = mysqli_fetch_array($result)){
		$opciones = $opciones."<option value=$row[0]>$row[0]</option>";
	}

	echo $opciones;
}


function mostrarColumnas ($columna){

	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='u333999880_maq' AND `TABLE_NAME`='$columna'";

	$result = mysqli_query($con, $query);

	$columnas = [];

	while($row = mysqli_fetch_array($result)){
	    $columnas[] = $row;
	}

	return $columnas;

}


function contarColumnas ($columna){

	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT COUNT(`COLUMN_NAME`) FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='u333999880_maq' AND `TABLE_NAME`='$columna'";

	$result = mysqli_query($con, $query);

	$contador = mysqli_fetch_row($result);


	return $contador;

}






function mostrarSelect ($columna,$c){

	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT * FROM `$columna` GROUP BY `Nombre`";

	$result = mysqli_query($con, $query);

	$opciones = "";

	while($row = mysqli_fetch_array($result)){
	    $opciones = $opciones.'<option value="'.$row[$c].'">'.$row[$c].'</option>';
	}
		echo $opciones;
	}



function mostrarSelect2 ($columna,$tabla){ //bien

$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT `$columna` FROM `$tabla` WHERE `$columna` IS NOT NULL";

	$result = mysqli_query($con, $query);

	$opciones = "";

	while($row = mysqli_fetch_array($result)){
	    $opciones = $opciones."<option value=$row[0]>$row[0]</option>";
}
	echo $opciones;
}


function consulta($valor,$tabla){
	
	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT `Nombre` FROM `$tabla` WHERE `Nombre`='$valor' LIMIT 1";

	$result = mysqli_query($con, $query);

	$row = mysqli_fetch_assoc($result);

	echo $row['Nombre'];

}

function consultaPrecio($valor,$tabla){
	
	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT `Precio` FROM `$tabla` WHERE `Nombre`= '$_SESSION[producto]'";

	$result = mysqli_query($con, $query);

	$row = mysqli_fetch_assoc($result);

	echo $row['Precio'];

}

function consultaCategoria($valor,$tabla){
	
	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT `categoria` FROM `$tabla` WHERE `Nombre`= '$_SESSION[producto]'";

	$result = mysqli_query($con, $query);

	$row = mysqli_fetch_assoc($result);

	echo $row['categoria'];

}

function consultaIdProducto($valor,$tabla){
	
	$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

	$query = "SELECT `IdProducto` FROM `$tabla` WHERE `Nombre`= '$_SESSION[producto]'";

	$result = mysqli_query($con, $query);

	$row = mysqli_fetch_assoc($result);

	echo $row['IdProducto'];

}




function ultimoid(){
$con = new mysqli($this->servername, $this->username, $this->password, $this->database);


	$query = "SELECT idproducto FROM datos ORDER BY idproducto DESC LIMIT 1";

	$result = mysqli_query($con, $query);

	$opciones = "";

	while ($row = mysqli_fetch_array($result)){
		$opciones = $opciones."$row[0]";
	}

	echo $opciones+1;
}


	function displayTabla(){
$con = new mysqli($this->servername, $this->username, $this->password, $this->database);

mysqli_set_charset($con, "windows-1252");


		$query = "SELECT * FROM datos ORDER BY `id` DESC LIMIT 3 ";

		$result = mysqli_query($con, $query);



		if ($result->num_rows > 0) {
	    echo "<table class='table'>
	    <tr>
	    	<th>Id</th>
		    <th>Nombre</th>
		    <th>Act.</th>
		    <th>Categ.</th>
		    <th>Marca</th>
		    <th>Cant.</th>
		    <th>Disp. p.</th>
		    <th>Visib.</th>
		    <th>Resum.</th>
		    <th>Etiq.</th>
		    <th>Most. P.</th>
		    <th>Descripcion PDF</th>
		    <th>Precio</th>
		    <th>Meta Key.</th>
		    <th>Meta Tit.</th>
		    <th>Meta Desc.</th>
		    <th>Caracteristicas</th>
		    <th>Borrar</th>
	    </tr>";

	    while($row = $result->fetch_assoc()) {
	    	$id = $row["idproducto"];
	        echo "<tr>
	        		<td>" . $row["idproducto"]. "</td>
	        		<td>" . $row["nombre"]. "</td>
	        		<td>" . $row["activo"]. "</td>
	        		<td>" . $row["categoria"]. "</td>
	        		<td>" . $row["marca"]. "</td>
	        		<td>" . $row["cantidad"]. "</td>
	        		<td>" . $row["disponible para pedidos"]. "</td>
	        		<td>" . $row["visible"]. "</td>
	        		<td>" . $row["resumen"]. "</td>
	        		<td>" . $row["etiquetas"]. "</td>
	        		<td>" . $row["mostrar precio"]. "</td>
	        		<td>" . $row["descripcion"]. "</td>
	        		<td>" . $row["precio"]."</td>
	        		<td>" . $row["meta keywords"]. "</td>
	        		<td>" . $row["meta titulo"]. "</td>
	        		<td>" . $row["meta descripcion"]. "</td>
	        		<td><div style='height:100px';overflow:'hidden'>" . $row["caracteristicas"]. "</div></td>
	        		<td><form method='POST' action='BD.php'><input type='submit' class='btn btn-danger btn-xs' value='X' name='borrar'><input type='hidden' name='valor' value='$id'></form></td>
	        	</tr>";
	    }
	    echo "</table>";
	} else {
	    echo "Todavia no has insertado ninguna dato";
	}


}



}

if(isset($_POST['form1'])){

	$usuario = "pruebausuario";
	$idproducto = $_POST['inputId'];
	$nombre = $_POST['inputNombre'];
	$activo = $_POST['activo'];
	$categoria = $_POST['inputCategoria'];
	$marca = $_POST['inputMarca'];
	$cantidad = $_POST['inputCantidad'];
	$disponible = $_POST['inputDisponible'];
	$visible = $_POST['inputVisible'];

	$resumen = 
	"<p class=\"env\"><img src=\"http:\/\/pmaproduct.org/img/cms/envio.png\" alt=\"Plazo de entrega\" /><strong> Plazo de entrega:</strong></p>"
	."<p class=\"textProduct\"><b>"."- ".$_POST['selectPlazoDeEntrega']."</b></p>"
	."<p class=\"textProduct\"></p>"
	."<p class=\"env\"><img src=\"http:\/\/pmaproduct.org/img/cms/instalacion.png\" alt=\"Instalacion\" /><strong> Instalacion:</strong></p>"
	."<p class=\"textProduct\"><b>"."- ".$_POST['selectInstalacion']."</b></p>";

	$etiquetas = $_POST['inputEtiquetas'];
	$mostrarPrecio = $_POST['inputMostrarPrecio'];
	$descripcion = "<p>".$_POST['inputDescripcion']."</p>";
	$precio = $_POST['inputPrecio'];
	$mk = $_POST['inputMK'];
	$mt = $_POST['inputMT'];
	$md = $_POST['inputMD'];
	$caracteristicas = $_POST['caracteristicas'];

	

	

$con = new mysqli($servername, $username, $password, $database);

mysqli_set_charset($con, "windows-1252");



	$query = "INSERT INTO datos (`idproducto`, `nombre`, `activo`, `categoria`, `marca`, `cantidad`, `disponible para pedidos`, `visible`, `resumen`, `etiquetas`, `mostrar precio`, `descripcion`, `precio`, `meta keywords`, `meta titulo`, `meta descripcion`, `caracteristicas`, `usuario`)
	VALUES ('$idproducto', '$nombre', '$activo', '$categoria', '$marca', '$cantidad', '$disponible', '$visible', '$resumen', '$etiquetas', '$mostrarPrecio', '$descripcion', '$precio', '$mk', '$mt', '$md', '$caracteristicas', '$usuario')";

	$result = mysqli_query($con, $query);



	header("Location: index.php");

}

if(isset($_POST['valor'])){
		 $valor = $_POST['valor'];


	$con = new mysqli($servername, $username, $password, $database);

	$query = "DELETE FROM `datos` WHERE `idproducto`=$valor";

		$result = mysqli_query($con, $query);

		header('Location: index.php');

		alert("bien");
}






if(isset($_POST['submit_producto'])){
	 

	$tipo = $_POST['nombreProducto'];

	echo $tipo."<br>";

	$_SESSION["producto"] = $tipo;

	header('Location:index.php');

}


if(isset($_POST['submit_familia'])){

	$tipo2 = $_POST['nombreFamilia'];

	echo $tipo2."<br>";

	$_SESSION["familia"] = $tipo2;

	header('Location:index.php');

}

if(isset($_POST['subirCombinaciones'])){

	$query1 = $_POST['query1'];
	$query2 = $_POST['query2'];

	$con = new mysqli($servername, $username, $password, $database);

	/*$query1 = 
	"INSERT INTO `datoscombinaciones`(`idproducto`, `atributo`, `valor`, `impactoprecio`, `cantidad`) VALUES (32,'Modelo:select:0','330:0',46,999);".
	"INSERT INTO `datoscombinaciones`(`idproducto`, `atributo`, `valor`, `impactoprecio`, `cantidad`) VALUES (32,'Modelo:select:0','460:0',63,999);".
	"INSERT INTO `datoscombinaciones`(`idproducto`, `atributo`, `valor`, `impactoprecio`, `cantidad`) VALUES (32,'Modelo:select:0','660:0',95,999);";*/

	echo $query1;


	

	$result = mysqli_multi_query($con, $query1);



	header("Location: index.php");


}



?> 