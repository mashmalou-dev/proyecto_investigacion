<?php include_once "includes/templates/header.php";?>
    <div class="container">
        <div class="row">
            <div class="col-md titulo">
                <h2>linea de investigación seleccionada</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md filtro">
                <h3>filtrar</h3>
                <select name="año" id="año">
                </select>
                <select name="investigador" id="investigador">
                </select>
                <button class="btn" type="submit" id="aplicar">aplicar filtro</button>
                <button class="btn" type="button" id="reiniciar">quitar filtro</button>
            </div>
        </div>
        <div class="row justify-content-between row-container">
            
        </div>
    </div>
<?php include_once "includes/templates/footer.php";?>
<script src="js/proyectos/proyectos_funciones.js"></script>
