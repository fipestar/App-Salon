let paso = 1;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); //Muestra la seccion de acuerdo al paso
    tabs(); //Cambia la seccion de acuerdo a la pestaña seleccionada
    botonesPaginador(); //Paginador siguiente y anterior
    paginaSiguiente(); //Funcion para avanzar a la siguiente pagina
    paginaAnterior(); //Funcion para retroceder a la pagina anterior

    consultarAPI(); //Consultar la API para obtener los datos
    nombreCliente(); //Validar el nombre del cliente
    seleccionarFecha(); //Seleccionar la fecha
    seleccionarHora(); //Seleccionar la hora
    mostrarResumen(); //Muestra el resumen de la cita
}

function mostrarSeccion(){
    //Ocultar la seccion anterior
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Eliminar la clase de actual en el tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', (e) => {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        })
    })
}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', () => {
        paso--;
        mostrarSeccion();
        botonesPaginador();
    })
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', () => {
        paso++;
        mostrarSeccion();
        botonesPaginador();
    })  
}

async function consultarAPI(){
    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach( servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);


        document.querySelector('#servicios').appendChild(servicioDiv);
    })
}

function seleccionarServicio(servicio){
        const { id } = servicio;
        const { servicios } = cita;
        //Identificar al elemento al que se le da click
        const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
        //Comprobar si un servicio ya fue agregado
        if(servicios.some( agregado => agregado.id === servicio.id)){
            //Eliminar el servicio del arreglo

            cita.servicios = servicios.filter( agregado => agregado.id !== id);
            divServicio.classList.remove('seleccionado');

               }else {
                //Agrega el servicio al arreglo
                cita.servicios = [...servicios, servicio];
                divServicio.classList.add('seleccionado');
               }   
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {

        const dia = new Date(e.target.value).getUTCDay();

        if( [6, 0].includes(dia) ){
            e.target.value = '';
            mostrarAlerta('No se pueden agendar citas los fines de semana', 'error');
        }else{
            cita.fecha = e.target.value;
        }
    })
}

function seleccionarHora(){

    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){

        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];

        if(hora < 10 || hora > 18){
            e.target.value = '';
            mostrarAlerta('Hora no válida', 'error');
            setTimeout(() => {
                inputHora.value = '';
            }, 3000);
        }else{
            cita.hora = e.target.value;
        }
    })

}

function mostrarAlerta(mensaje, tipo){

    //Si hay una alerta previa, no crear otra
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        return;
    }


    //Scripting de la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const formulario = document.querySelector('.formulario');
    formulario.appendChild(alerta);

    //Eliminar la alerta despues de 3 segundos
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    if(Object.values(cita).includes('')){
        console.log('Hacen falta datos');
}else{

}
}