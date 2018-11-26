var datos;
var aux=0;
var puntero=1;
var paginas=1;
var matriz;
//carga el contenido en la BD una vez que se
$( document ).ready(function() {
  buscarDatos();
  buscarLineas();
});
//extrae la informacion del select y retorna una consulta con los investigadores
//correspondientes a una linea
function filtrar(){
  $("#output").empty();
  $.ajax({
    type: "POST",
    async: true,
    url: "filtro-investigador.php",
    timeout: 12000,
    data: $("#form").serialize(),
    dataType: "json",
    success: function(response)
    {
      //se calcula el numero de paginas
      var pags;
      var n = response.length;
      pags = n / 9;
      if(pags<1)paginas=1;
      else if(pags==parseInt(pags)) paginas =pags;
      else if(pags>parseInt(pags))paginas = pags+1;
      datos = response;
      //se crea y rellena la matriz
      matriz = new Array(response.length);
      for (var i = 0; i < matriz.length; i++) {
        matriz[i] =  new Array(5);
      }
      var a=0;
      $.each(response,function(key, registro) {
        matriz[a][0]= registro.url_foto;
        matriz[a][1]= registro.nombre;
        matriz[a][2] = registro.apellido_paterno;
        matriz[a][3] = registro.apellido_materno;
        matriz[a][4] = registro.nombre_linea;
        a++;
      });
      cargarDatos(datos,paginas,puntero);
      $("#output").append("<br><br>");
    },
    error: function(jqXHR, textStatus, errorThrown){
      console.log(errorThrown);
      $("#dato").html(errorThrown);
    }
  });
}
//limpia los contenedores para volver a hacer una consulta
function reiniciar(){
  $("#output").empty();
  $("#investigador").empty();
  $("#investigador").append("<option value='default'>Linea de investigacion</option>");
  buscarDatos();
  buscarLineas();
}
//consulta las lineas de investigacion y las coloca en un select
function buscarLineas(){
  $.ajax({
          type: "POST",
          async: true,
          url: "filtros.php",
          timeout: 12000,
          data: {id:1},
          dataType: "json",
          success: function(response)
          {
            $.each(response,function(key, registro) {
                $("#investigador").append("<option value='"+registro.nombre_linea+"'>"+registro.nombre_linea+"</option>");
            });
          },
          error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            $("#dato").html(errorThrown);
          }
    });
}
//buscarDatos conecta con el servidor para obtener un json con los datos de los Investigadores
function buscarDatos(){
  $.ajax({
          type: "POST",
          async: true,
          url: "investigadores.php",
          timeout: 12000,
          dataType: "json",
          success: function(response)
          {
            var pags;
            var n = response.length;
            pags = n / 9;
            if(pags<1)paginas=1;
            else if(pags==parseInt(pags)) paginas =pags;
            else if(pags>parseInt(pags))paginas = pags+1;
            //la respuesta se almacena en una variable global
            datos = response;
            //se genera y rellena la matriz con los datos del json
            matriz = new Array(response.length);
            for (var i = 0; i < matriz.length; i++) {
              matriz[i] =  new Array(9);
            }
            var a=0;
            $.each(response,function(key, registro) {
              matriz[a][0]= registro.url_foto;
              matriz[a][1]= registro.nombre;
              matriz[a][2] = registro.apellido_paterno;
              matriz[a][3] = registro.apellido_materno;
              matriz[a][4] = registro.nombre_linea;
              matriz[a][5] = registro.nivel_estudios;
              matriz[a][6] = registro.correo;
              matriz[a][7] = registro.ubicacion;
              matriz[a][9] = registro.id_investigador;
              a++;
            });
            //se envian a cargarDatos para su presentacion en pantalla
            cargarDatos(response,paginas,puntero);
            $("#output").append("<br><br>");

          },
          error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            $("#dato").html(errorThrown);
          }
    });
}
//esta funcion es invocada desde el metodo onclick de los botones de paginar
//su funcion es rellenar un grid con los elementos correspondientes para esa pagina
function cambioPagina(i){
  //limpia el contenedor de investigadores
  $("#output").empty();
  //llama a la funcion cargarDatos
  cargarDatos(datos,paginas,i);
}
//esta funcion permite paginar el contenido de los Investigadores
//recibe 3 parametros: datos (json con informacion de los investigadores)
//paginas (numero de paginas que seran necesarias para almacenar la informacion)
//puntero (indica la pagina actual)
function cargarDatos(datos,paginas,puntero){
  //p guardara el valor maximo de elemento en esa pagina ej. puntero=2,p=18
  var p = puntero * 9;
  var c,d;
  if(puntero==1){
    c = 9;
    if(datos.length<9){
      c= datos.length;
    }
  }else{
    //c = 9 - (18-10), c=1
    c = 9-(p-datos.length);
  }
  //limite inferior, x = 18-9 -> x=9
  var x= p-9;
  //limite superior, d = 9 + 1 -> d =10
  d=x+c;
  //se llena un grid con un rango de datos si puntero = 2, se mostrara de 9 -> 10
  for (var i = x; i < d; i++) {
      $("#output").append("<div class='col-md-4' style='display:inline-block;'>"+
      "<div class='imagen-proyecto' onclick='verInvestigador("+i+")'>"+
      "<img src='"+matriz[i][0]+"'>"+
      "<h3>Ver más"+
     "</h3></div>"+"<div class='info-proyecto'><h3>Investigador:<br>"+
      matriz[i][1]+" "+matriz[i][2]+" "+matriz[i][3]+
      " </h3><h3>Línea de investigación: <br>"+
      matriz[i][4]+"</h3></div></div>");
  }
  $("#output").append("<br><br>");
  //se inserta el html de los botones de paginas
  for (var i = 1; i <= parseInt(paginas); i++) {
    if(i==puntero){
      $("#output").append("<button class='btn paginacion' type='button' style='margin-right:5px;' onclick='cambioPagina("+i+")'>"+i+"</button>");
    }else{
      $("#output").append("<button class='btn' type='button' style='margin-right:5px;' onclick='cambioPagina("+i+")'>"+i+"</button>");
    }

  }
}

function verInvestigador(i){
  var out = document.getElementById("output");
  var c =  document.getElementById("row");
  out.style.display = "none";
  c.style.display = "none";
  var contenedor = document.getElementById("inv");
  contenedor.style.display = "block";
  $("#img").append("<img src='"+ matriz[i][0]+ "'>");
  $("#cont-info").append("<h3>"+matriz[i][5]+" "+matriz[i][1]+
  " "+matriz[i][2]+" "+matriz[i][3]+"</h3>");
  $("#datos").append("<h4>Correo: "+matriz[i][6]+"</h4>"+
  "<h4>Ubicacion: "+matriz[i][7] +"</h4>"
  );
  $("#titulo").append("<h3>Publicaciones</h3>");
  var my_arr = new Array('id',i);
  var x= matriz[i][9];
  $.ajax({
          type: "POST",
          async: true,
          url: "proyectos_investigador.php",
          timeout: 12000,
          data:{'id':x},
          dataType: "json",
          success: function(response)
          {
            $.each(response,function(key, registro) {
              $("#titulo").append("<br><div class='mini-cont'>"+
              "<h4>"+registro.titulo_publicacion+"</h4>"+
              "<h4>"+registro.fecha_publicacion+"</h4>"+
              "<h4>"+registro.foro_publicacion+"</h4>"+
              "<h4><a href='"+registro.link_publicacion+"'>Ver publicacion</a></h4>"+
              "</div>"
              );
            });
          }

    });
}
