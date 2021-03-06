<?php
  session_start();
  if (session_status() === PHP_SESSION_ACTIVE && $_SESSION['usuario']!="") {

  }else{
  	header("Location: ../login.php");
  	exit();
  }
 ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="../css/bootstrap.min.css">
     <link rel="stylesheet" href="../css/administracion.css">
     <link rel="stylesheet" href="../datepicker/css/bootstrap-datepicker.css">
     <title>Administración</title>
 </head>

 <body style="background: #f8f8f8">

     <!--Barra superior-->
     <div style="background: rgb(27, 57, 106); height: 4em; display: flex; justify-content: center; align-items: center;">
         <h1 style="color:#f8f8f8">Administracion</h1>
     </div>

     <!--Navegacion de secciones-->
     <ul class="nav nav-tabs sticky-top" id="myTab" role="tablist" style="background: #f0f0f0;">
         <li class="nav-item">
             <a class="nav-link active list-group-item-action" id="proyectos-tab" data-toggle="tab" href="#proyectos"
                 role="tab" aria-controls="home" aria-selected="false">Proyectos</a>
         </li>
         <li class="nav-item">
             <a class="nav-link list-group-item-action" id="investigadores-tab" data-toggle="tab" href="#investigadores"
                 role="tab" aria-controls="profile" aria-selected="false">Investigadores</a>
         </li>
         <li class="nav-item">
             <a class="nav-link list-group-item-action" id="publicaciones-tab" data-toggle="tab" href="#publicaciones"
                 role="tab" aria-controls="contact" aria-selected="false">Publicaciones</a>
         </li>
         <li class="nav-item">
             <a class="nav-link list-group-item-action" id="congresos-tab" data-toggle="tab" href="#congresos" role="tab"
                 aria-controls="contact" aria-selected="false">Congresos</a>
         </li>
         <li class="nav-item">
             <a class="nav-link list-group-item-action" id="anuncios-tab" data-toggle="tab" href="#anuncios" role="tab"
                 aria-controls="contact" aria-selected="false">Anuncios</a>
         </li>
         <li class="nav-item"><a class="nav-link list-group-item-action" href='../includes/funciones/cerrar.php'>Salir</a></li>
     </ul>

     <!--seccion de gestion-->
     <div class="tab-content" id="myTabContent" style="margin-top:1em;">
         <!--Seccion de proyectos-->
         <div class="tab-pane fade show active" id="proyectos" role="tabpanel" aria-labelledby="proyectos-tab">
             <div class="row">
                 <div class="col-lg-2">
                     <button id="btn_nuevo_proyecto" href="#registrar_proyecto" style="margin-left:2em" type="button"
                         class="btn btn-md btn-outline-primary" data-toggle='modal'>Nuevo</button>
                 </div>
                 <div class="col-lg-2">
                     <div class="form-check" style="margin-top:4%;">
                         <input class="form-check-input" type="checkbox" id="check_proyectos" value="1">
                         <label class="form-check-label" for="check_proyectos">Proyectos inactivos</label>
                     </div>
                 </div>
                 <div class="col-lg-8">
                     <form class="form-inline">
                         <div class="form-group" style="margin:1%;">
                             <label for="in_palabra_proyecto">Filtros:</label>
                             <input id="in_palabra_proyecto" type="text" placeholder="buscar" class="form-control mx-sm-3">
                             <select id="select_investigador_proyecto" class="custom-select">
                                 <option selected>Investigador</option>
                                 <option value="1">Investigador 1</option>
                             </select>
                             <select id="select_linea_proyecto" class="custom-select">
                                 <option selected>Linea</option>
                                 <option value="1">Linea 1</option>
                             </select>
                             <button id="tbn_refrescar_filtros_proyectos" type="button" class="form-control mx-sm-3">Quitar
                                 filtros</button>
                         </div>
                     </form>
                 </div>
             </div>
             <div class="container" style="margin-top:1em;">
                 <div id="contenedor_proyectos" class="row">

                 </div>
             </div>
         </div>

         <!--Seccion de investigadores-->
         <div class="tab-pane fade" id="investigadores" role="tabpanel" aria-labelledby="investigadores-tab">
             <div class="row">
                 <div class="col-lg-3">
                     <button id="btn_nuevo_investigador" href="#registrar_investigador" style="margin-left:2em" type="button"
                         class="btn btn-md btn-outline-primary" data-toggle='modal'>Nuevo</button>
                 </div>
                 <div class="col-lg-3">
                     <div class="form-check" style="margin-top:4%;">
                         <input class="form-check-input" type="checkbox" value=1 id="check_investigador">
                         <label class="form-check-label" for="check_investigador">Ivestigadores inactivos</label>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <form class="form-inline">
                         <div class="form-group" style="margin:1%;">
                             <label for="in_nombre_investigador">Filtros:</label>
                             <input type="text" id="in_nombre_investigador" placeholder="buscar" style="padding-left: 5em; padding-right: 5em" class="form-control mx-sm-3">
                             <select id="select_linea_investigador" class="custom-select">
                                 <option selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                             <button id="btn_refrescar_filtos_investigador" type="button" class="form-control mx-sm-3">Quitar
                                 filtros</button>
                         </div>
                     </form>
                 </div>
             </div>
             <div class="container" style="margin-top:1em;">
                 <div id="contenedor_investigadores" class="row"></div>
             </div>
         </div>

         <!--Seccion de publicaciones-->
         <div class="tab-pane fade" id="publicaciones" role="tabpanel" aria-labelledby="publicaciones-tab">
             <div class="row">
                 <div class="col-lg-3">
                     <button id="btn_nueva_publicacion" href="#registrar_publicacion" style="margin-left:2em" type="button"
                         class="btn btn-md btn-outline-primary" data-toggle='modal'>Nuevo</button>
                 </div>
                 <div class="col-lg-3">
                     <div class="form-check" style="margin-top:4%;">
                         <input id="check_publicacion" class="form-check-input" type="checkbox" value="1">
                         <label class="form-check-label" for="check_proyectos">Publicaciones inactivas</label>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <form class="form-inline">
                         <div class="form-group" style="margin:1%;">
                             <label for="in_palabra_publicacion">Filtros:</label>
                             <input type="text" id="in_palabra_publicacion" placeholder="buscar" class="form-control mx-sm-3">
                             <select id="select_linea_publicacion" class="custom-select">
                                 <option selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                             <button id="btn_refrescar_filtos_publicacion" type="button" class="form-control mx-sm-3">Quitar
                                 filtros</button>
                         </div>
                     </form>
                 </div>
             </div>
             <div class="container" style="margin-top:1em;">
                 <div id="contenedor_publicaciones" class="row"></div>
             </div>
         </div>

         <!--Seccion de congresos-->
         <div class="tab-pane fade" id="congresos" role="tabpanel" aria-labelledby="congresos-tab">
             <div class="row">
                 <div class="col-lg-6">
                     <button id="btn_nuevo_congreso" href="#registrar_congreso" style="margin-left:2em" type="button"
                         class="btn btn-md btn-outline-primary" data-toggle='modal'>Nuevo</button>
                 </div>
                 <div class="col-lg-6">
                     <form class="form-inline">
                         <div class="form-group" style="margin:1%;">
                             <label for="in_palabra_congreso">Filtros:</label>
                             <input type="text" id="in_palabra_congreso" placeholder="buscar" class="form-control mx-sm-3">
                             <select id="select_linea_congreso" class="custom-select">
                                 <option selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                             <button id="btn_refrescar_filtros_congreso" type="button" class="form-control mx-sm-3">Qutar
                                 filtros</button>
                         </div>
                     </form>
                 </div>
             </div>
             <div class="container" style="margin-top:1em;">
                 <div id="contenedor_congresos" class="row"></div>
             </div>
         </div>

         <!--Seccion de Anuncios-->
         <div class="tab-pane fade" id="anuncios" role="tabpanel" aria-labelledby="congresos-tab">
             <div class="row">
                 <div class="col-lg-6">
                     <button id="btn_nuevo_anuncio" href="#registrar_anuncio" style="margin-left:2em" type="button"
                         class="btn btn-md btn-outline-primary" data-toggle='modal'>Nuevo</button>
                 </div>
             </div>
             <div class="container" style="margin-top:1em;">
                 <div id="contenedor_anuncios" class="row"></div>
             </div>
         </div>

     </div>

     <!--Moda de confirmacion-->
     <div class="modal fade" id="confirmacion">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header">
                     <h3 id="text_titulo_confirmacion" class="modal-title">Confirmacion</h3>
                     <button id="btn_cerrar" tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 </div>
                 <div class="modal-body">
                     <h4 id="text_confirmacion"> ¿Seguro que desea continuar? </h4>
                 </div>
                 <div class="modal-footer">
                     <button id="btn_si" class="btn btn-lg btn-outline-danger">Si</button>
                 </div>
             </div>
         </div>
     </div>
     <!--/Moda de confirmacion-->

     <!--Modal de nuevo proyecto-->
     <div class="modal fade" id="registrar_proyecto">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!--Cabecera del modal-->
                 <div class="modal-header">
                     <h3 id="titulo_modal_proyecto" class="modal-title">Titulo P</h3>
                     <button id="btn_cerrar_registrar_proyectos" tyle="button" class="close" data-dismiss="modal"
                         aria-hidden="true">&times;</button>
                 </div>
                 <!--Cuerpo del modal-->
                 <div class="modal-body">
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_titulo_proyecto" class="font-weight-bold">Titulo</label>
                             <input type="text" id="in_titulo_proyecto" class="form-control">
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_titulo_proyecto" class="font-weight-bold">Lider de proyecto</label>
                             <select id="select_lider_proyecto_registro" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 col-md-12">
                             <label class="font-weight-bold">Imagen</label>
                             <div class="input-group">
                                 <label class="input-group-btn">
                                     <span class="btn btn-outline-info">
                                         Buscar&hellip; <input id="img_proyecto_ref" name="img_proyecto_ref" type="file" style="display: none;" accept="image/png, image/jpeg">
                                     </span>
                                 </label>
                                 <input id="in_img_proyecto" type="text" class="form-control" readonly>
                             </div>
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_linea_proyecto_registro" class="font-weight-bold">Linea de investigación</label>
                             <select id="select_linea_proyecto_registro" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class='col-md-6'>
                             <div class="form-group">
                                 <label for="fecha_inicio" class="font-weight-bold">Fecha inicio</label>
                                 <div class='input-group date' id='fecha_inicio'>
                                     <input id="in_fecha_inicio" type='text' class="form-control">
                                     <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                     </span>
                                 </div>
                             </div>
                         </div>
                         <div class='col-md-6'>
                             <div class="form-group">
                                 <label for="fecha_fin" class="font-weight-bold">Fecha inicio</label>
                                 <div class='input-group date' id='fecha_fin'>
                                     <input id="in_fecha_fin" type='text' class="form-control">
                                     <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="row" style="margin:1em;">
                         <div class="container col-sm-12">
                             <div class="form-check">
                                 <input id="check_financiado" class="form-check-input" type="checkbox" value="0">
                                 <label class="form-check-label font-weight-bold mx-sm-3" for="check_financiado">Proyecto
                                     financiado</label>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-sm-12">
                             <label for="txt_resumen_proyecto" class="font-weight-bold">Resumen</label>
                             <textarea class="form-control" id="txt_resumen_proyecto" rows="3"></textarea>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_colaboradores" class="font-weight-bold">Colaboradores</label>
                             <select id="select_colaboradores" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="lista_colaboradores" class="font-weight-bold">Colaboradores agregados</label>
                             <ul id="lista_colaboradores" class="list-group">
                                 <li class="list-group-item item list-group-item-success"">Dapibus ac facilisis in<button id="" tyle="
                                     button" class="close" aria-hidden="true">&times;</button></li>
                             </ul>
                         </div>
                     </div>
                     <!---
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_publicaciones" class="font-weight-bold">Publicaciones</label>
                             <select id="select_publicaciones" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="lista_publicaciones" class="font-weight-bold">Publicaciones relacionadas</label>
                             <ul id="lista_publicaciones" class="list-group">
                                 <li class="list-group-item item list-group-item-success"">Dapibus ac facilisis in<button id="" tyle="
                                     button" class="close" aria-hidden="true">&times;</button></li>
                             </ul>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_congresos" class="font-weight-bold">Congresos</label>
                             <select id="select_congresos" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="lista_congresos" class="font-weight-bold">congresos relacionados</label>
                             <ul id="lista_congresos" class="list-group">
                                 <li class="list-group-item item list-group-item-success"">Dapibus ac facilisis in<button id="" tyle="
                                     button" class="close" aria-hidden="true">&times;</button></li>
                             </ul>
                         </div>
                     </div>
                     -->
                 </div>
                 <!--Pie del modal-->
                 <div class="modal-footer">
                     <button id="btn_guardar_proyecto" class="btn btn-md btn-outline-success">Guardar</button>
                 </div>
             </div>
         </div>
     </div>
     <!--/Modal de nuevo proyecto-->

     <!--Modal de nuevo investigador-->
     <div class="modal fade" id="registrar_investigador">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!--Cabecera del modal-->
                 <div class="modal-header">
                     <h3 id="titulo_modal_investigador" class="modal-title">Titulo I</h3>
                     <button id="btn_cerrar_registrar_investigador" tyle="button" class="close" data-dismiss="modal"
                         aria-hidden="true">&times;</button>
                 </div>
                 <!--Cuerpo del modal-->
                 <div class="modal-body">
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_titulo_investigador_registro" class="font-weight-bold">Titulo</label>
                             <input type="text" id="in_titulo_investigador_registro" class="form-control">
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_nombre_investigador_registro" class="font-weight-bold">Nombre</label>
                             <input type="text" id="in_nombre_investigador_registro" class="form-control">
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_apellido_patertno" class="font-weight-bold">Apellido paterno</label>
                             <input type="text" id="in_apellido_patertno" class="form-control">
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_apellido_matertno_registro" class="font-weight-bold">Apellido matertno</label>
                             <input type="text" id="in_apellido_matertno_registro" class="form-control">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-4 col-md-12">
                             <label class="font-weight-bold">Foto</label>
                             <div class="input-group">
                                 <label class="input-group-btn">
                                     <span class="btn btn-outline-info">
                                         Buscar&hellip; <input id="img_investigador" name="img_investigador" type="file" style="display: none;" accept="image/png, image/jpeg">
                                     </span>
                                 </label>
                                 <input id="in_foto_investigador" type="text" class="form-control" readonly>
                             </div>
                         </div>
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="in_correo_registro" class="font-weight-bold">Correo electronico</label>
                             <input type="email" id="in_correo_registro" class="form-control">
                         </div>
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="in_edificio_ubicacion" class="font-weight-bold">Ubicacion de cubiculo</label>
                             <input type="text" id="in_edificio_ubicacion" class="form-control">
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="select_lineas_investigacion_registro" class="font-weight-bold">Lineas</label>
                             <select id="select_lineas_investigacion_registro" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                         <div class="form-group col-lg-8 col-md-12">
                             <label for="lista_lineas_investigador" class="font-weight-bold">Lineas agregadas</label>
                             <ul id="lista_lineas_investigador" class="list-group">
                                 <li class="list-group-item item list-group-item-success"">Dapibus ac facilisis in<button id="" tyle="
                                     button" con class="close" aria-hidden="true">&times;</button></li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 <!--Pie del modal-->
                 <div class="modal-footer">
                     <button id="btn_guardar_investigador" class="btn btn-md btn-outline-success">Guardar</button>
                 </div>
             </div>
         </div>
     </div>
     <!--/Modal de nuevo investigador-->

     <!--Modal de nueva publicacion-->
     <div class="modal fade" id="registrar_publicacion">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!--Cabecera del modal-->
                 <div class="modal-header">
                     <h3 id="titulo_modal_publicacion" class="modal-title">Titulo Pu</h3>
                     <button id="btn_cerrar_registrar_proyectos" tyle="button" class="close" data-dismiss="modal"
                         aria-hidden="true">&times;</button>
                 </div>
                 <!--Cuerpo del modal-->
                 <div class="modal-body">
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_titulo_publicacion_registro" class="font-weight-bold">Titulo</label>
                             <input type="text" id="in_titulo_publicacion_registro" class="form-control">
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_autor_publicacion_registro" class="font-weight-bold">Autor</label>
                             <select id="select_autor_publicacion_registro" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_foro_publicacion" class="font-weight-bold">Foro</label>
                             <input type="text" id="in_foro_publicacion" class="form-control">
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_linea_publicacion_registro" class="font-weight-bold">Linea de
                                 investigación</label>
                             <select id="select_linea_publicacion_registro" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 col-md-12">
                             <label class="font-weight-bold">Documento</label>
                             <div class="input-group">
                                 <label class="input-group-btn">
                                     <span class="btn btn-outline-info">
                                         Buscar&hellip; <input type="file" id="achivo_pdf" name="archivo_pdf" style="display: none;" accept="application/pdf">
                                     </span>
                                 </label>
                                 <input id="in_doc_publicacion" type="text" class="form-control" readonly>
                             </div>
                         </div>
                         <div class='col-lg-6 col-md-12'>
                             <div class="form-group">
                                 <label for="fecha_publicacion" class="font-weight-bold">Fecha de publicación</label>
                                 <div class='input-group date' id='fecha_publicacion'>
                                     <input id="in_fecha_publicacion" type='text' class="form-control" />
                                     <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!--Pie del modal-->
                 <div class="modal-footer">
                     <button id="btn_guardar_publicacion" class="btn btn-md btn-outline-success">Guardar</button>
                 </div>
             </div>
         </div>
     </div>
     <!--/Modal de nuevo publicacion-->

     <!--Modal de nuevo congreso-->
     <div class="modal fade" id="registrar_congreso">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!--Cabecera del modal-->
                 <div class="modal-header">
                     <h3 id="tutulo_reg_congreso" class="modal-title">Titulo C</h3>
                     <button id="btn_cerrar_registrar_proyectos" tyle="button" class="close" data-dismiss="modal"
                         aria-hidden="true">&times;</button>
                 </div>
                 <!--Cuerpo del modal-->
                 <div class="modal-body">
                     <div class="row">
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_titulo_congreso" class="font-weight-bold">Titulo</label>
                             <input type="text" id="in_titulo_congreso" class="form-control">
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="select_linea_congreso_registro" class="font-weight-bold">Linea de investigación</label>
                             <select id="select_linea_congreso_registro" class="custom-select">
                                 <option value="1" selected>Linea</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 col-md-12">
                             <label class="font-weight-bold">Imagen</label>
                             <div class="input-group">
                                 <label class="input-group-btn">
                                     <span class="btn btn-outline-info">
                                         Buscar&hellip; <input id="img_congreso_reg" name="img_congreso_reg" type="file" name="img_congreso" id="img_congreso" style="display: none;" accept="image/png, image/jpeg">
                                     </span>
                                 </label>
                                 <input id="in_img_congreso" type="text" class="form-control" readonly>
                             </div>
                         </div>
                         <div class="form-group col-lg-6 col-md-12">
                             <label for="in_link_congreso" class="font-weight-bold">Link externo</label>
                             <input type="text" id="in_link_congreso" placeholder="https://www.example.com" class="form-control">
                         </div>
                     </div>
                 </div>
                 <!--pie del modal-->
                 <div class="modal-footer">
                     <button id="btn_guardar_congreso" class="btn btn-md btn-outline-success">Guardar</button>
                 </div>
             </div>
         </div>
     </div>
     <!--/Modal de nuevo congreso-->

     <!--Modal de nuevo anuncio-->
     <div class="modal fade" id="registrar_anuncio">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!--Cabecera del modal-->
                 <div class="modal-header">
                     <h3 id="titulo_registro_anuncio" class="modal-title">Titulo A</h3>
                     <button id="btn_cerrar_registro_anuncio" tyle="button" class="close" data-dismiss="modal"
                         aria-hidden="true">&times;</button>
                 </div>
                 <!--Cuerpo del modal-->
                 <div class="modal-body">
                     <div class="row">
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="in_cantidad_alumno" class="font-weight-bold">Cantidad de alumnos</label>
                             <input type="number" id="in_cantidad_alumno" class="form-control">
                         </div>
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="in_semestre_alumno" class="font-weight-bold">Semestre</label>
                             <input type="number" id="in_semestre_alumno" class="form-control">
                         </div>
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="select_proyecto_anuncio" class="font-weight-bold">Proyecto</label>
                             <select id="select_proyecto_anuncio" class="custom-select">
                                 <option value="" selected>Linea</option>
                                 <option value="1">One</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-sm-12">
                             <label for="txt_perfil_anuncio" class="font-weight-bold">Perfil alumno(s):</label>
                             <textarea class="form-control" id="txt_perfil_anuncio" rows="3"></textarea>
                         </div>
                         <div class="form-group col-lg-4 col-md-12">
                             <label for="in_recompensa_alumno" class="font-weight-bold">Recompensa</label>
                             <select id="in_recompensa_alumno" class="custom-select">
                                 <option value="Credito complementario" selected>Credito complementario</option>
                                 <option value="Servicio Social">Servicio Social</option>
                                 <option value="Residencias">Residencias</option>
                             </select>
                         </div>
                     </div>
                 </div>
                 <!--Cabecera del modal-->
                 <div class="modal-footer">
                     <button id="btn_guardar_anuncio" class="btn btn-md btn-outline-success">Guardar</button>
                 </div>
             </div>
         </div>
     </div>
     <!--/Modal de nuevo anuncio-->

     <script src="../js/jquery-3.3.1.min.js"></script>
     <script src="../js/bootstrap.min.js"></script>
     <script src="../datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="../js/administracion/administracion.js"></script>
 </body>

 </html>
