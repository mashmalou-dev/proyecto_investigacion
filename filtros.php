<?php
  $nombre = $_POST['id'];
  function consultarLineas(){
    try {
      //importamos la conexion a la base de datos
      require_once('includes/funciones/bdconexion.php');
      //Se genera y envia la consulta
      $query = "SELECT nombre_linea FROM lineas_investigacion";
      $resultado = mysqli_query($conn, $query);

      //los datos son almacenados en un arreglo y se retorna test
      while($row = mysqli_fetch_assoc($resultado))
        $test[] = $row;
      return $test;
    } catch(Exception $e) {
      echo $e->getMessage();
      return $e;
    }
  }
  //Se lee la variable enviada del js
  switch ($nombre) {
    case 1:
      $respuesta = consultarLineas();
      break;

    default:
      $respuesta = "Error al cargar la lineas";
      break;
  }
  //Se llama a la funcion consultarLineas


  //se envia al cliente la consulta
  echo json_encode($respuesta);
 ?>
