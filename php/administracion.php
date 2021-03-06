<?php
    include 'conexion.php';

    $ruta_congresos='img/congresos';
    $ruta_investigadores='img/investigadores';
    $ruta_proyectos='img/proyectos';
    $ruta_publicaciones='docs/publicaciones';



    $funcion = $_REQUEST["funcion"];
    
    //consultas a la base de datos administrador
    //como patametro recibe la funcion que realiza
    //el resultado que devuelve es el resultado de la accion en el caso de sentencia y un jsonobjet en caso de consutla
    switch ($funcion){
        //consulta de proyectos
        case 'consulta_proyectos_adm':
            $palabra_clave=$_REQUEST["palabra_clave"];
            $id_inv=$_REQUEST["id_inv"];
            $id_linea_investigacion=$_REQUEST["id_linea_investigacion"];
            $activo=$_REQUEST["activo"];
            $respuesta = consultaSQL("SELECT id_proyecto, linea_investigacion, link_imagen, titulo_proyecto, lider_proyecto, DATE_FORMAT(fecha_inicio,'%d/%m/%Y') AS fecha_inicio, DATE_FORMAT(fecha_fin,'%d/%m/%Y') AS fecha_fin, nombre_linea, resumen, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo, financiamiento FROM proyectos AS P INNER JOIN lineas_investigacion AS L ON P.linea_investigacion=L.id_linea INNER JOIN investigadores AS I ON I.id_investigador=P.lider_proyecto WHERE titulo_proyecto LIKE '%".$palabra_clave."%' AND lider_proyecto LIKE '%".$id_inv."%' AND linea_investigacion LIKE'%".$id_linea_investigacion."%' AND P.status=".$activo.";");
            echo json_encode($respuesta);
        break;
        //consulta de invetigadores
        case 'consulta_investigadores_adm':
            $palabra_clave=$_REQUEST["palabra_clave"];
            //$id_linea_investigacion=$_REQUEST["id_linea_investigacion"];
            $activo=$_REQUEST["activo"];
            $respuesta = consultaSQL("SELECT * FROM investigadores WHERE (nombre LIKE '%".$palabra_clave."%' OR apellido_paterno LIKE '%".$palabra_clave."%' OR apellido_materno LIKE '%".$palabra_clave."%') AND status=".$activo.";");
            echo json_encode($respuesta);
        break;
        //consulta de publicaciones
        case 'consulta_publicaciones_adm':
            $palabra_clave=$_REQUEST["palabra_clave"];
            $id_linea_investigacion=$_REQUEST["id_linea_investigacion"];
            $activo=$_REQUEST["activo"];
            $respuesta = consultaSQL("SELECT * , DATE_FORMAT(fecha_publicacion,'%d/%m/%Y') AS fecha_chida FROM publicaciones AS P INNER JOIN lineas_investigacion AS L ON P.linea_invetigacion=L.id_linea WHERE titulo_publicacion LIKE '%".$palabra_clave."%' AND linea_invetigacion LIKE'%".$id_linea_investigacion."%' AND status=".$activo.";");
            echo json_encode($respuesta);
        break;
        //consulta de congresos
        case 'consulta_congresos_adm':
            $palabra_clave=$_REQUEST["palabra_clave"];
            $id_linea_investigacion=$_REQUEST["id_linea_investigacion"];
            $respuesta = consultaSQL("SELECT * FROM congresos as C INNER JOIN lineas_investigacion AS L ON C.linea_investigacion=L.id_linea  WHERE nombre_evento LIKE '%".$palabra_clave."%' AND linea_investigacion LIKE'%".$id_linea_investigacion."%';");
            echo json_encode($respuesta);
        break;
        //consulta de anuncios
        case 'consulta_anuncios_adm':
            $respuesta = consultaSQL("SELECT * FROM anuncios AS A INNER JOIN proyectos AS P ON A.id_proyecto=P.id_proyecto;");
            echo json_encode($respuesta);
        break;
        //consulta solo el id y nombre de los investigadores
        case 'consulta_lista_usuarios':
            $respuesta = consultaSQL("SELECT id_investigador, CONCAT(nombre, ' ', apellido_paterno) AS nombre FROM investigadores;");
            echo json_encode($respuesta);
        break;
        //consulta solo el id y nombre de las lineas de investigacion
        case 'consulta_lista_lineas':
            $respuesta = consultaSQL("SELECT id_linea, nombre_linea FROM lineas_investigacion");
            echo json_encode($respuesta);
        break;
        //consluta colboradores proyecto
        case 'consulta_lista_colaboradores':
            $id_proyecto=$_REQUEST["id_proyecto"];
            $respuesta = consultaSQL("SELECT CONCAT(I.nivel_estudios, ' ', I.nombre, ' ', I.apellido_paterno, ' ', I.apellido_materno) AS nombre , id_proyecto, C.id_investigador FROM colaboradores AS C INNER JOIN investigadores AS I ON C.id_investigador=I.id_investigador WHERE id_proyecto=".$id_proyecto.";");
            echo json_encode($respuesta);
        break;
        //Cunsulta las lineas de investigacion multiples de un investigadoras
        case 'consultar_lineas_investigador':
            $id_investigador=$_REQUEST["id_investigador"];
            $respuesta = consultaSQL("SELECT * FROM lineas_investigadores as I INNER JOIN lineas_investigacion as L on I.id_linea=L.id_linea  WHERE id_investigador=".$id_investigador.";");
            echo json_encode($respuesta);
        break;
        //Elimina proyectos (de forma logica)
        case 'eliminar_proyectos':
            $id_proyecto=$_REQUEST["id_proyecto"];
            $status=$_REQUEST["status"];
            $respuesta = querySQL("UPDATE proyectos SET status=".$status." WHERE id_proyecto=".$id_proyecto.";");
            echo $respuesta;
        break;
        //Elimina investigadores (de forma logica)
        case 'eliminar_investigador':
            $id_investigador=$_REQUEST["id_investigador"];
            $status=$_REQUEST["status"];
            $respuesta = querySQL("UPDATE investigadores SET status=".$status." WHERE id_investigador=".$id_investigador.";");
            echo $respuesta;
        break;
        //Elimina publicacione (de forma logica)
        case 'eliminar_publicacion':
            $id_publicacion=$_REQUEST["id_publicacion"];
            $status=$_REQUEST["status"];
            $respuesta = querySQL("UPDATE publicaciones SET status=".$status." WHERE id_publicaciones=".$id_publicacion.";");
            echo $respuesta;
        break;
        //Elimina congresos
        case 'eliminar_congreso':
            $id_congreso=$_REQUEST["id_congreso"];
            $respuesta = querySQL("DELETE FROM congresos WHERE id_evento=".$id_congreso.";");
            echo $respuesta;
        break;
        //Elimina un anuncio
        case 'eliminar_anuncio':
            $id_anuncio=$_REQUEST["id_anuncio"];
            $respuesta = querySQL("DELETE FROM anuncios WHERE id_anuncio=".$id_anuncio.";");
            echo $respuesta;
        break;
        //Editar un anuncio
        case 'editar_anuncio':
            $id_anuncio=$_REQUEST["id_anuncio"];
            $cantidad=$_REQUEST["cantidad"];
            $semestre=$_REQUEST["semestre"];
            $id_proyecto=$_REQUEST["id_proyecto"];
            $recompensa=$_REQUEST["recompensa"];
            $perfil=$_REQUEST["perfil"];
            $respuesta = querySQL("UPDATE anuncios SET Cantidad_alumnos=".$cantidad.", Perfil='".$perfil."' , Recompensa='".$recompensa."' , Semestre=".$semestre.", id_proyecto=".$id_proyecto." WHERE id_anuncio=".$id_anuncio.";");
            echo $respuesta;
        break;
        //Registrar un anuncio
        case 'registrar_anuncio':
            $cantidad=$_REQUEST["cantidad"];
            $semestre=$_REQUEST["semestre"];
            $id_proyecto=$_REQUEST["id_proyecto"];
            $recompensa=$_REQUEST["recompensa"];
            $perfil=$_REQUEST["perfil"];
            $respuesta = querySQL("INSERT INTO anuncios (Cantidad_alumnos, Perfil, Semestre, Recompensa, id_proyecto) VALUES (".$cantidad.", '".$perfil."', ".$semestre.", '".$recompensa."', ".$id_proyecto.");");
            echo $respuesta;
        break;
        case 'registrar_lineas_inv':
            $id_linea=$_REQUEST["id_linea"];
            $id= consultaSQL("SELECT COUNT(*) AS total from investigadores");
            $respuesta = querySQL("INSERT INTO lineas_investigadores (id_linea, id_investigador) VALUES ('".$id_linea."', '".$id[0]["total"]."');");
            echo $respuesta;
            break;
        case 'registrar_colaboradores':
            $id_investigador=$_REQUEST["id_investigador"];
            $id= consultaSQL("SELECT COUNT(*) AS total from proyectos");
            $respuesta = querySQL("INSERT INTO colaboradores (id_investigador, id_proyecto) VALUES ('".$id_investigador."', '".$id[0]["total"]."');");
            echo $respuesta;
            break;
        case 'editar_colaboradores':
            $id_investigador=$_REQUEST["id_investigador"];
            $id_proyecto=$_REQUEST["id_proyecto"];
            //$respuesta = querySQL("DELETE FROM colaboradores WHERE id_proyecto = ".$id_proyecto.";");
            $respuesta = querySQL("INSERT INTO colaboradores (id_investigador, id_proyecto) VALUES ('".$id_investigador."', '".$id_proyecto."');");
            echo $respuesta;
            break;
        case 'eliminar_colaboradores':
            $id_proyecto=$_REQUEST["id_proyecto"];
            $respuesta = querySQL("DELETE FROM colaboradores WHERE id_proyecto = ".$id_proyecto.";");
            //$respuesta = querySQL("INSERT INTO colaboradores (id_investigador, id_proyecto) VALUES ('".$id_investigador."', '".$id[0]["total"]."');");
            echo $respuesta;
            break;
        case 'editar_lineas_inv':
            $id_linea=$_REQUEST["id_linea"];
            $id_investigador= $_REQUEST["id_investigador"];
            //$respuesta = querySQL("DELETE FROM lineas_investigadores WHERE id_investigador =".$id_investigador." ;");
            $respuesta = querySQL("INSERT INTO lineas_investigadores (id_linea, id_investigador) VALUES ('".$id_linea."', '".$id_investigador."');");
            echo $respuesta;
            break;
        case 'eliminar_lineas_inv':
            $id_investigador= $_REQUEST["id_investigador"];
            $respuesta = querySQL("DELETE FROM lineas_investigadores WHERE id_investigador =".$id_investigador." ;");
            //$respuesta = querySQL("INSERT INTO lineas_investigadores (id_linea, id_investigador) VALUES ('".$id_linea."', '".$id_investigador."');");
            echo $respuesta;
            break;
        case 'registrar_publicacion':
        if($_POST["titulo_publicacion"] != "" && $_POST["foro_publicacion"] != "" && $_POST["fecha_publicacion"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                    if($_FILES["archivo"]["type"]=="application/pdf"){
                        $nombre_archivo = date("dmY_Hms").".pdf";
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_publicaciones . "/" . $nombre_archivo;
                        $link_publicacion=$ruta_publicaciones . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            //echo "El fichero es válido y se subió con éxito.\n";
                            $titulo_publicacion= $_POST["titulo_publicacion"];
                            $id_investigador= $_POST["id_investigador"];
                            $foro_publicacion= $_POST["foro_publicacion"];
                            $fecha_publicacion= $_POST["fecha_publicacion"];
                            $linea_invetigacion= $_POST["linea_invetigacion"];
                            $respuesta = querySQL("INSERT INTO publicaciones (titulo_publicacion, id_investigador, foro_publicacion, fecha_publicacion, linea_invetigacion, link_publicacion, status) VALUES ('".$titulo_publicacion."', '".$id_investigador."', '".$foro_publicacion."', DATE_FORMAT(STR_TO_DATE('".$fecha_publicacion."', '%d/%m/%Y'), '%Y-%m-%d'), ".$linea_invetigacion.", '".$link_publicacion."', 1);");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'editar_publicacion_con':
        if($_POST["titulo_publicacion"] != "" && $_POST["foro_publicacion"] != "" && $_POST["fecha_publicacion"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                    if($_FILES["archivo"]["type"]=="application/pdf"){
                        $nombre_archivo = date("dmY_Hms").".pdf";
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_publicaciones . "/" . $nombre_archivo;
                        $link_publicacion=$ruta_publicaciones . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            $titulo_publicacion= $_POST["titulo_publicacion"];
                            $id_publicaciones= $_POST["id_publicaciones"];
                            $id_investigador= $_POST["id_investigador"];
                            $foro_publicacion= $_POST["foro_publicacion"];
                            $fecha_publicacion= $_POST["fecha_publicacion"];
                            $linea_invetigacion= $_POST["linea_invetigacion"];
                            $respuesta = querySQL("UPDATE publicaciones SET titulo_publicacion = '".$titulo_publicacion."', fecha_publicacion = DATE_FORMAT(STR_TO_DATE('".$fecha_publicacion."', '%d/%m/%Y'), '%Y-%m-%d'), foro_publicacion = '".$foro_publicacion."', linea_invetigacion = '".$linea_invetigacion."', link_publicacion= '".$link_publicacion."' WHERE id_publicaciones = ".$id_publicaciones.";");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'editar_publicacion_sin':
        if($_POST["titulo_publicacion"] != "" && $_POST["foro_publicacion"] != "" && $_POST["fecha_publicacion"] != ""){
                $titulo_publicacion= $_POST["titulo_publicacion"];
                $id_publicaciones= $_POST["id_publicaciones"];
                $id_investigador= $_POST["id_investigador"];
                $foro_publicacion= $_POST["foro_publicacion"];
                $fecha_publicacion= $_POST["fecha_publicacion"];
                $linea_invetigacion= $_POST["linea_invetigacion"];
                $respuesta = querySQL("UPDATE publicaciones SET titulo_publicacion = '".$titulo_publicacion."', fecha_publicacion = DATE_FORMAT(STR_TO_DATE('".$fecha_publicacion."', '%d/%m/%Y'), '%Y-%m-%d'), foro_publicacion = '".$foro_publicacion."', linea_invetigacion = '".$linea_invetigacion."' WHERE id_publicaciones = ".$id_publicaciones.";");
                echo $respuesta;
            }else{
                echo "Llena todos los campos porfavor";
            }
        break;
        case 'registrar_investigador':
        if($_POST["nivel_estudios"] != "" && $_POST["nombre"] != "" && $_POST["apellido_paterno"] != "" && $_POST["apellido_materno"] != "" && $_POST["correo"] != "" && $_POST["ubicacion"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                    if($_FILES["archivo"]["type"]=="image/png" || $_FILES["archivo"]["type"]=="image/jpeg"){
                        if($_FILES["archivo"]["type"]=="image/png" ){
                            $nombre_archivo = $_POST["nombre"].$_POST["apellido_paterno"].date("dmY").".png";
                        }else if($_FILES["archivo"]["type"]=="image/jpeg"){
                            $nombre_archivo =date("dmY_Hms").".jpeg";
                        }
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_investigadores . "/" . $nombre_archivo;
                        $url_foto=$ruta_investigadores . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            //echo "El fichero es válido y se subió con éxito.\n";
                            $nivel_estudios= $_POST["nivel_estudios"];
                            $nombre= $_POST["nombre"];
                            $apellido_paterno= $_POST["apellido_paterno"];
                            $apellido_materno= $_POST["apellido_materno"];
                            $correo= $_POST["correo"];
                            $ubicacion= $_POST["ubicacion"];
                            $id= consultaSQL("SELECT (COUNT(*)+1) AS total from investigadores");
                            $respuesta = querySQL("INSERT INTO investigadores (id_investigador, nombre, apellido_paterno, apellido_materno, nivel_estudios, correo, ubicacion, url_foto, status) VALUES (".$id[0]['total'].", '".$nombre."', '".$apellido_paterno."', '".$apellido_materno."', '".$nivel_estudios."', '".$correo."', '".$ubicacion."', '".$url_foto."', 1);");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'registrar_proyecto':
        if($_POST["titulo_proyecto"] != "" && $_POST["lider_proyecto"] != "" && $_POST["linea_investigacion"] != "" && $_POST["fecha_inicio"] != "" && $_POST["fecha_fin"] != "" && $_POST["resumen"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                    if($_FILES["archivo"]["type"]=="image/png" || $_FILES["archivo"]["type"]=="image/jpeg"){
                        if($_FILES["archivo"]["type"]=="image/png" ){
                            $nombre_archivo = $_POST["titulo_proyecto"].date("dmY").".png";
                        }else if($_FILES["archivo"]["type"]=="image/jpeg"){
                            $nombre_archivo = date("dmY_Hms").".jpeg";
                        }
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_proyectos . "/" . $nombre_archivo;
                        $url_foto=$ruta_proyectos . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            //echo "El fichero es válido y se subió con éxito.\n";
                            $titulo_proyecto= $_POST["titulo_proyecto"];
                            $lider_proyecto= $_POST["lider_proyecto"];
                            $linea_investigacion= $_POST["linea_investigacion"];
                            $fecha_inicio= $_POST["fecha_inicio"];
                            $fecha_fin= $_POST["fecha_fin"];
                            $financiamiento= $_POST["financiamiento"];
                            $resumen= $_POST["resumen"];
                            $id= consultaSQL("SELECT (COUNT(*)+1) AS total from proyectos");
                            $respuesta = querySQL("INSERT INTO proyectos (id_proyecto, titulo_proyecto, lider_proyecto, linea_investigacion, fecha_inicio, fecha_fin, financiamiento, link_imagen, fecha_registro, resumen, status) VALUES ('".$id[0]['total']."', '".$titulo_proyecto."', '".$lider_proyecto."', '".$linea_investigacion."', DATE_FORMAT(STR_TO_DATE('".$fecha_inicio."', '%d/%m/%Y'), '%Y-%m-%d'), DATE_FORMAT(STR_TO_DATE('".$fecha_fin."', '%d/%m/%Y'), '%Y-%m-%d'), '".$financiamiento."', '".$url_foto."', '0000-00-00', '".$resumen."', '1');");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'editar_proyecto_con':
        if($_POST["titulo_proyecto"] != "" && $_POST["lider_proyecto"] != "" && $_POST["linea_investigacion"] != "" && $_POST["fecha_inicio"] != "" && $_POST["fecha_fin"] != "" && $_POST["resumen"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                if($_FILES["archivo"]["type"]=="image/png" || $_FILES["archivo"]["type"]=="image/jpeg"){
                    if($_FILES["archivo"]["type"]=="image/png" ){
                        $nombre_archivo = $_POST["titulo_proyecto"].date("dmY").".png";
                    }else if($_FILES["archivo"]["type"]=="image/jpeg"){
                        $nombre_archivo = date("dmY_Hms").".jpeg";
                    }
                    $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                    $archivador = "../".$ruta_proyectos . "/" . $nombre_archivo;
                    $url_foto=$ruta_proyectos . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            $id_proyecto= $_POST["id_proyecto"];
                            $titulo_proyecto= $_POST["titulo_proyecto"];
                            $lider_proyecto= $_POST["lider_proyecto"];
                            $linea_investigacion= $_POST["linea_investigacion"];
                            $fecha_inicio= $_POST["fecha_inicio"];
                            $fecha_fin= $_POST["fecha_fin"];
                            $financiamiento= $_POST["financiamiento"];
                            $resumen= $_POST["resumen"];
                            $respuesta = querySQL("UPDATE proyectos SET titulo_proyecto = '".$titulo_proyecto."', lider_proyecto = '".$lider_proyecto."', linea_investigacion = '".$linea_investigacion."', fecha_inicio = DATE_FORMAT(STR_TO_DATE('".$fecha_inicio."', '%d/%m/%Y'), '%Y-%m-%d'), fecha_fin = DATE_FORMAT(STR_TO_DATE('".$fecha_fin."', '%d/%m/%Y'), '%Y-%m-%d'), financiamiento = '".$financiamiento."', link_imagen = '".$url_foto."', resumen = '".$resumen."' WHERE id_proyecto = ".$id_proyecto.";");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'editar_proyecto_sin':
        if($_POST["titulo_proyecto"] != "" && $_POST["lider_proyecto"] != "" && $_POST["linea_investigacion"] != "" && $_POST["fecha_inicio"] != "" && $_POST["fecha_fin"] != "" && $_POST["resumen"] != ""){
                $id_proyecto= $_POST["id_proyecto"];
                $titulo_proyecto= $_POST["titulo_proyecto"];
                $lider_proyecto= $_POST["lider_proyecto"];
                $linea_investigacion= $_POST["linea_investigacion"];
                $fecha_inicio= $_POST["fecha_inicio"];
                $fecha_fin= $_POST["fecha_fin"];
                $financiamiento= $_POST["financiamiento"];
                $resumen= $_POST["resumen"];
                $respuesta = querySQL("UPDATE proyectos SET titulo_proyecto = '".$titulo_proyecto."', lider_proyecto = '".$lider_proyecto."', linea_investigacion = '".$linea_investigacion."', fecha_inicio = DATE_FORMAT(STR_TO_DATE('".$fecha_inicio."', '%d/%m/%Y'), '%Y-%m-%d'), fecha_fin = DATE_FORMAT(STR_TO_DATE('".$fecha_fin."', '%d/%m/%Y'), '%Y-%m-%d'), financiamiento = '".$financiamiento."', resumen = '".$resumen."' WHERE id_proyecto = ".$id_proyecto.";");
                echo $respuesta;
            }else{
                echo "Llena todos los campos porfavor";
            }
        break;
        case 'editar_investigador_sin':
        if($_POST["nivel_estudios"] != "" && $_POST["nombre"] != "" && $_POST["apellido_paterno"] != "" && $_POST["apellido_materno"] != "" && $_POST["correo"] != "" && $_POST["ubicacion"] != ""){
                            $nivel_estudios= $_POST["nivel_estudios"];
                            $id_investigador= $_POST["id_investigador"];
                            $nombre= $_POST["nombre"];
                            $apellido_paterno= $_POST["apellido_paterno"];
                            $apellido_materno= $_POST["apellido_materno"];
                            $correo= $_POST["correo"];
                            $ubicacion= $_POST["ubicacion"];
                            $respuesta = querySQL("UPDATE investigadores SET nombre = '".$nombre."', apellido_paterno = '".$apellido_paterno."', apellido_materno = '".$apellido_materno."', nivel_estudios = '".$nivel_estudios."', correo = '".$correo."', ubicacion='".$ubicacion."' WHERE id_investigador = ".$id_investigador.";");
                            echo $respuesta;
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'editar_investigador_con':
        if($_POST["nivel_estudios"] != "" && $_POST["nombre"] != "" && $_POST["apellido_paterno"] != "" && $_POST["apellido_materno"] != "" && $_POST["correo"] != "" && $_POST["ubicacion"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                    if($_FILES["archivo"]["type"]=="image/png" || $_FILES["archivo"]["type"]=="image/jpeg"){
                        if($_FILES["archivo"]["type"]=="image/png" ){
                            $nombre_archivo =date("dmY_Hms").".png";
                        }else if($_FILES["archivo"]["type"]=="image/jpeg"){
                            $nombre_archivo =date("dmY_Hms").".jpeg";
                        }
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_investigadores . "/" . $nombre_archivo;
                        $url_foto=$ruta_investigadores . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            //echo "El fichero es válido y se subió con éxito.\n";
                            $id_investigador= $_POST["id_investigador"];
                            $nivel_estudios= $_POST["nivel_estudios"];
                            $nombre= $_POST["nombre"];
                            $apellido_paterno= $_POST["apellido_paterno"];
                            $apellido_materno= $_POST["apellido_materno"];
                            $correo= $_POST["correo"];
                            $ubicacion= $_POST["ubicacion"];
                            $respuesta = querySQL("UPDATE investigadores SET nombre = '".$nombre."', apellido_paterno = '".$apellido_paterno."', apellido_materno = '".$apellido_materno."', nivel_estudios = '".$nivel_estudios."', correo = '".$correo."', url_foto = '".$url_foto."', ubicacion='".$ubicacion."' WHERE id_investigador = ".$id_investigador.";");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'registrar_congreso':
        if($_POST["nombre_evento"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                if($_FILES["archivo"]["type"]=="image/png" || $_FILES["archivo"]["type"]=="image/jpeg"){
                        if($_FILES["archivo"]["type"]=="image/png" ){
                            $nombre_archivo =date("dmY_Hms").".png";
                        }else if($_FILES["archivo"]["type"]=="image/jpeg"){
                            $nombre_archivo = date("dmY_Hms").".jpeg";
                        }
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_congresos . "/" . $nombre_archivo;
                        $link_imagen=$ruta_congresos . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            $nombre_evento= $_POST["nombre_evento"];
                            $link_externo= $_POST["link_externo"];
                            $linea_investigacion= $_POST["linea_investigacion"];
                            $respuesta = querySQL("INSERT INTO congresos (id_evento, nombre_evento, descripcion, lugar, fecha_evento, link_imagen, link_externo, linea_investigacion, fecha_registro, id_proyecto) VALUES (NULL, '".$nombre_evento."', '1', '1', '0000-00-00', '$link_imagen', '$link_externo', '$linea_investigacion', '0000-00-00', NULL);");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
        case 'editar_congreso_sin':
        if($_POST["nombre_evento"] != ""){
            $id_evento=$_POST["id_evento"];
            $nombre_evento= $_POST["nombre_evento"];
            $link_externo= $_POST["link_externo"];
            $linea_investigacion= $_POST["linea_investigacion"];
            $respuesta = querySQL("UPDATE congresos SET nombre_evento = '".$nombre_evento."', link_externo = '".$link_externo."', linea_investigacion = '".$linea_investigacion."' WHERE id_evento = ".$id_evento.";");
            echo $respuesta;
            }else{
                echo "LLena el campo nobre por favor";
            }
        break;
        case 'editar_congreso_con':
        if($_POST["nombre_evento"] != ""){
            if(file_exists($_FILES['archivo']['tmp_name'])){
                if($_FILES["archivo"]["type"]=="image/png" || $_FILES["archivo"]["type"]=="image/jpeg"){
                        if($_FILES["archivo"]["type"]=="image/png" ){
                            $nombre_archivo = $_POST["nombre_evento"].date("dmY").".png";
                        }else if($_FILES["archivo"]["type"]=="image/jpeg"){
                            $nombre_archivo = date("dmY_Hms").".jpeg";
                        }
                        $tmp_archivo = $_FILES["archivo"]["tmp_name"];
                        $archivador = "../".$ruta_congresos . "/" . $nombre_archivo;
                        $link_imagen=$ruta_congresos . "/" . $nombre_archivo;
                        if (move_uploaded_file($tmp_archivo, $archivador)) {
                            $id_evento=$_POST["id_evento"];
                            $nombre_evento= $_POST["nombre_evento"];
                            $link_externo= $_POST["link_externo"];
                            $linea_investigacion= $_POST["linea_investigacion"];
                            $respuesta = querySQL("UPDATE congresos SET nombre_evento = '".$nombre_evento."', link_externo = '".$link_externo."', link_imagen='".$link_imagen."',  linea_investigacion = '".$linea_investigacion."' WHERE id_evento = ".$id_evento.";");
                            echo $respuesta;
                        } else {
                            echo "¡Error archivo muy grande!\n";
                        }
                    }else{
                        echo "el documeto ingresado es muy grande o no tiene el formato incorrecto";
                    }
                }else{
                    echo "no seleccionaste archivo";
                }
            }else{
                echo "LLena todos los campos porfavor";
            }
        break;
    }
?>
