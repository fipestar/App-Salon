<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuacion</p>

<form action="/olvide" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
         <input 
           type="email"
           id="email"
           name="email"
           placeholder="Tu Email">
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
        <a href="/">¿Ya tienes una cuenta? Inicia sesion</a>
        <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
    </div>