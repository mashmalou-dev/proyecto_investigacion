<?php 
$lineaInvestigacion;
if(isset($_GET['id'])) {
    $lineaInvestigacion=$_GET['id'];
}

if(isset($_POST['fecha'])&&$_POST['fecha']!='default'&& isset($_POST['id_investigador'])&&$_POST['id_investigador']!='default'){
    filtroAmbos();

} else {
    if(isset($_POST['fecha'])&&$_POST['fecha']!='default'&& isset($_POST['id_investigador'])&&$_POST['id_investigador']=='default') {
        filtroAño();
    } else {
        if (isset($_POST['fecha'])&&$_POST['fecha']=='default'&& isset($_POST['id_investigador'])&&$_POST['id_investigador']!='default') {
            filtroInvestigador();
        } else {
            include_once 'bdconexion.php';
            $info=[];
            try {
                $totalSql="select p.id_proyecto, p.titulo_proyecto,p.lider_proyecto, p.linea_investigacion, p.fecha_inicio,year(p.fecha_inicio) as anio,p.fecha_fin, p.link_imagen, p.resumen, i.nombre, i.apellido_paterno, i.apellido_materno, linea.nombre_linea from proyectos p inner join investigadores i on p.lider_proyecto=i.id_investigador inner join lineas_investigacion linea on linea.id_linea=p.linea_investigacion where linea_investigacion=".$lineaInvestigacion.";";

                $pageSize=9;
                if($sentencia= $conn->query($totalSql)){

                    $totalDatos=$sentencia->num_rows;
    
    
                    $numeroPaginas=ceil($totalDatos/$pageSize);

                }
                $iniciar=0;
                if(isset($_GET['pagina'])){
                    $iniciar=($_GET['pagina']-1)*$pageSize;
                } else {
                    $iniciar=0;
                }




                $sql = "select p.id_proyecto, p.titulo_proyecto,p.lider_proyecto, p.linea_investigacion, p.fecha_inicio,year(p.fecha_inicio) as anio,p.fecha_fin, p.link_imagen, p.resumen, i.nombre, i.apellido_paterno, i.apellido_materno, linea.nombre_linea from proyectos p inner join investigadores i on p.lider_proyecto=i.id_investigador inner join lineas_investigacion linea on linea.id_linea=p.linea_investigacion where linea_investigacion=".$lineaInvestigacion." limit ".$iniciar.",". $pageSize.";";
                if($datos = $conn->query($sql)){

                    while($dato=$datos->fetch_assoc()){
                        $informacion=array(
                            'id_proyecto'=>utf8_encode($dato['id_proyecto']),
                            'titulo_proyecto'=>utf8_encode($dato['titulo_proyecto']),
                            'lider_proyecto'=>utf8_encode($dato['lider_proyecto']),
                            'linea_investigacion'=>utf8_encode($dato['linea_investigacion']),
                            'nombre_linea'=>utf8_encode($dato['nombre_linea']),
                            'fecha_inicio'=>utf8_encode($dato['fecha_inicio']),
                            'anio'=>utf8_encode($dato['anio']),
                            'fecha_fin'=>utf8_encode($dato['fecha_fin']),
                            'link_imagen'=>utf8_encode($dato['link_imagen']),
                            'resumen'=>utf8_encode($dato['resumen']),
                            'nombre'=>utf8_encode($dato['nombre']),
                            'apellido_paterno'=>utf8_encode($dato['apellido_paterno']),
                            'apellido_materno'=>utf8_encode($dato['apellido_materno']),      
                            'numeroPaginas'=>$numeroPaginas           
                        );
                       $info[]=$informacion;
                    }
                    echo json_encode($info);
                    $datos->free();
                }

            } catch(Exception $e) {
                echo $e->getMessage();
            }
        
        }
    } 
}
function filtroAño() {
    include 'bdconexion.php';
    $fecha = $_POST['fecha'];
    $lineaInvestigacion = $_POST['linea_investigacion'];
    $info=[];
    try {
        $sql = "select p.id_proyecto, p.titulo_proyecto,p.lider_proyecto, p.linea_investigacion, p.fecha_inicio,year(p.fecha_inicio) as anio,p.fecha_fin, p.link_imagen, p.resumen, i.nombre, i.apellido_paterno, i.apellido_materno, linea.nombre_linea from proyectos p inner join investigadores i on p.lider_proyecto=i.id_investigador inner join lineas_investigacion linea on linea.id_linea=p.linea_investigacion where year(fecha_inicio)=".$fecha." and linea_investigacion=".$lineaInvestigacion.";";
        if($datos = $conn->query($sql)) {
            while($dato=$datos->fetch_assoc()){
                $informacion=array(
                    'id_proyecto'=>utf8_encode($dato['id_proyecto']),
                    'titulo_proyecto'=>utf8_encode($dato['titulo_proyecto']),
                    'lider_proyecto'=>utf8_encode($dato['lider_proyecto']),
                    'linea_investigacion'=>utf8_encode($dato['linea_investigacion']),
                    'nombre_linea'=>utf8_encode($dato['nombre_linea']),
                    'fecha_inicio'=>utf8_encode($dato['fecha_inicio']),
                    'anio'=>utf8_encode($dato['anio']),
                    'fecha_fin'=>utf8_encode($dato['fecha_fin']),
                    'link_imagen'=>utf8_encode($dato['link_imagen']),
                    'resumen'=>utf8_encode($dato['resumen']),
                    'nombre'=>utf8_encode($dato['nombre']),
                    'apellido_paterno'=>utf8_encode($dato['apellido_paterno']),
                    'apellido_materno'=>utf8_encode($dato['apellido_materno']),      
        );
               $info[]=$informacion;
            }
            echo json_encode($info);
            $datos->free();
        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
function filtroInvestigador(){
    include "bdconexion.php";
    $idInvestigador = $_POST['id_investigador'];
    $lineaInvestigacion = $_POST['linea_investigacion'];
    $info=[];
    try {
        $sql = "select p.id_proyecto, p.titulo_proyecto,p.lider_proyecto, p.linea_investigacion, p.fecha_inicio,year(p.fecha_inicio) as anio,p.fecha_fin, p.link_imagen, p.resumen, i.nombre, i.apellido_paterno, i.apellido_materno, linea.nombre_linea from proyectos p inner join investigadores i on p.lider_proyecto=i.id_investigador inner join lineas_investigacion linea on linea.id_linea=p.linea_investigacion where lider_proyecto=" . $idInvestigador." and linea_investigacion=".$lineaInvestigacion.";" ;
        if($datos = $conn->query($sql)) {
            while($dato=$datos->fetch_assoc()){
                $informacion=array(
                    'id_proyecto'=>utf8_encode($dato['id_proyecto']),
                    'titulo_proyecto'=>utf8_encode($dato['titulo_proyecto']),
                    'lider_proyecto'=>utf8_encode($dato['lider_proyecto']),
                    'linea_investigacion'=>utf8_encode($dato['linea_investigacion']),
                    'nombre_linea'=>utf8_encode($dato['nombre_linea']),
                    'fecha_inicio'=>utf8_encode($dato['fecha_inicio']),
                    'anio'=>utf8_encode($dato['anio']),
                    'fecha_fin'=>utf8_encode($dato['fecha_fin']),
                    'link_imagen'=>utf8_encode($dato['link_imagen']),
                    'resumen'=>utf8_encode($dato['resumen']),
                    'nombre'=>utf8_encode($dato['nombre']),
                    'apellido_paterno'=>utf8_encode($dato['apellido_paterno']),
                    'apellido_materno'=>utf8_encode($dato['apellido_materno']),      
        );
               $info[]=$informacion;
            }
            echo json_encode($info);
            $datos->free();
        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
function filtroAmbos() {
    include "bdconexion.php";
    $fecha = $_POST['fecha'];
    $idInvestigador = $_POST['id_investigador'];
    $lineaInvestigacion = $_POST['linea_investigacion'];
    $info=[];
    try {
        $sql = "select p.id_proyecto, p.titulo_proyecto,p.lider_proyecto, p.linea_investigacion, p.fecha_inicio,year(p.fecha_inicio) as anio,p.fecha_fin, p.link_imagen, p.resumen, i.nombre, i.apellido_paterno, i.apellido_materno, linea.nombre_linea from proyectos p inner join investigadores i on p.lider_proyecto=i.id_investigador inner join lineas_investigacion linea on linea.id_linea=p.linea_investigacion where year(fecha_inicio)=".$fecha. " and lider_proyecto=".$idInvestigador." and linea_investigacion=".$lineaInvestigacion.";";
        if($datos = $conn->query($sql)) {
            while($dato=$datos->fetch_assoc()){
                $informacion=array(
                    'id_proyecto'=>utf8_encode($dato['id_proyecto']),
                    'titulo_proyecto'=>utf8_encode($dato['titulo_proyecto']),
                    'lider_proyecto'=>utf8_encode($dato['lider_proyecto']),
                    'linea_investigacion'=>utf8_encode($dato['linea_investigacion']),
                    'nombre_linea'=>utf8_encode($dato['nombre_linea']),
                    'fecha_inicio'=>utf8_encode($dato['fecha_inicio']),
                    'anio'=>utf8_encode($dato['anio']),
                    'fecha_fin'=>utf8_encode($dato['fecha_fin']),
                    'link_imagen'=>utf8_encode($dato['link_imagen']),
                    'resumen'=>utf8_encode($dato['resumen']),
                    'nombre'=>utf8_encode($dato['nombre']),
                    'apellido_paterno'=>utf8_encode($dato['apellido_paterno']),
                    'apellido_materno'=>utf8_encode($dato['apellido_materno']),      
        );
               $info[]=$informacion;
            }
            echo json_encode($info);
            $datos->free();
        }
        else {
            echo ("no hubo resultado");
        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
?>