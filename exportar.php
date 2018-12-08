<?php  
//export.php  
$connect = mysqli_connect("localhost", "user1", "pwd1", "u333999880_maq");


$output = '';
if(isset($_POST["exportar"])){
 $query = "SELECT * FROM datos";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0){
  $output .= '<table class="table" bordered="1">  
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
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
              <td>' . $row["idproducto"]. '</td>
              <td>' . $row["nombre"]. '</td>
              <td>' . $row["activo"]. '</td>
              <td>' . $row["categoria"]. '</td>
              <td>' . $row["marca"]. '</td>
              <td>' . $row["cantidad"]. '</td>
              <td>' . $row["disponible para pedidos"]. '</td>
              <td>' . $row["visible"]. '</td>
              <td>' . $row["resumen"]. '</td>
              <td>' . $row["etiquetas"]. '</td>
              <td>' . $row["mostrar precio"]. '</td>
              <td>' . $row["descripcion"]. '</td>
              <td>' . $row["precio"].'</td>
              <td>' . $row["meta keywords"]. '</td>
              <td>' . $row["meta titulo"]. '</td>
              <td>' . $row["meta descripcion"]. '</td>
              <td>' . $row["caracteristicas"]. '</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=productos.xls');
  echo $output;
 }
}
?>