<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios a continuacion</p>

<div id="app">
    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
         <p class="text-center">Elige tus servicios a continuacion</p>
          <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                   type="text" 
                   id="nombre" 
                   placeholder="Tu Nombre"
                   value="<?php echo $nombre; ?>"
                   disabled 
                   
                   >
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                   type="date" 
                   id="fecha"> 
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                   type="time" 
                   id="hora"> 
            </div>
        </form>
    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
         <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>   

    <div class="paginacion">
        <button
           id="anterior"
           class="boton"
           >&laquo; Anterior</button>

        
    </div>
    
</div>