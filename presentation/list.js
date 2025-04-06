const url = 'http://localhost:3000/presentation/index.php';
     
var btnGuardar = document.getElementById('btnGuardar');
var btnActualizar = document.getElementById('btnActualizar');


window.onload = function() {
   obtenerTareas();
}

btnGuardar.addEventListener('click', function () {
  
  
  let descripcion = document.getElementById('tarea');
  let fecha = document.getElementById('fecha');
  let prioridad = document.getElementById('prioridad');

  let obj = {
     descripcion: descripcion.value,
     prioridad: prioridad.value,
     fecha: fecha.value,
     estado: 0
  };

  let json = JSON.stringify(obj);

  fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json' },
   mode: 'cors', body: json })
  .then((response) => {
   if (!response.ok) {
           alert('Error al consumir el servicio...');
       }
       return response.json();
  })
  .then((data) => {

    limpiarTabla();
    obtenerTareas();
    descripcion.value = "";
    fecha.value = "";

  })
  .catch((error) => {
    console.error('Hubo un problema con la solicitud fetch: ', error);
  });

});

function obtenerTareas() {

   fetch(url, { method: 'GET', headers: { 'Content-Type': 'application/json' },mode: 'cors' })
   .then(response => {
       if (!response.ok) {
           alert('Error al consumir el servicio...');
       }
       return response.json();
   })
   .then(data => {
       
       console.log(data);
       if (data.length > 0) {

           for (let i = 0; i < data.length; i++) 
           {
               agregarFila(data[i].ID, data[i].descripcion, data[i].estado, data[i].prioridad);
           }
       }

   })
   .catch(error => {
       console.error('Hubo un problema con la solicitud fetch: ', error);
   });

}

function agregarFila(id, tarea, estado, prioridad) 
{
   const nuevaFila = document.createElement('tr');

 
   const celdaId = document.createElement('td');
   celdaId.textContent = id;

   const celdaTarea = document.createElement('td');
   celdaTarea.textContent = tarea;

   const celdaEstado = document.createElement('td');
   let cadenaEstado;
   if(estado == 0) cadenaEstado = 'PENDIENTE';
   if(estado == 1) cadenaEstado = 'COMPLETADO';
   celdaEstado.textContent = cadenaEstado;

   const celdaPrioridad = document.createElement('td');
   let cadenaPrioridad;
   if(prioridad == 1) cadenaPrioridad = 'ALTA';
   if(prioridad == 2) cadenaPrioridad = 'MEDIA';
   if(prioridad == 3) cadenaPrioridad = 'BAJA';
   celdaPrioridad.textContent = cadenaPrioridad;

   
  
   let botonEliminar = document.createElement('button');
   botonEliminar.textContent = 'Eliminar';
   botonEliminar.classList.add('btn');
   botonEliminar.classList.add('btn-danger');
   botonEliminar.onclick = function() {
      eliminarTarea(id);
   };

   // Agregar el botón de eliminar a la celda de acciones
   const celdaAcciones = document.createElement('td');
   celdaAcciones.appendChild(botonEliminar);


   if (estado == 0) {
       const botonEditar = document.createElement('button');
       botonEditar.textContent = 'Completar';
       botonEditar.classList.add('btn');
       botonEditar.style.marginLeft = '20px';
       botonEditar.classList.add('btn-success');
       botonEditar.onclick = function() {
           actualizarTarea(id);
       };

       celdaAcciones.appendChild(botonEditar);
   } 

   // Agregar las celdas a la fila
   nuevaFila.appendChild(celdaId);
   nuevaFila.appendChild(celdaTarea);
   nuevaFila.appendChild(celdaEstado);
   nuevaFila.appendChild(celdaPrioridad);
   nuevaFila.appendChild(celdaAcciones);

   // Insertar la fila en la tabla
   var tabla = document.getElementById('tabla');
   var tbody = tabla.getElementsByTagName('tbody')[0];

   tbody.appendChild(nuevaFila);
}


function eliminarTarea(id){
   fetch(url + "/" + id, { method: 'DELETE', headers: { 'Content-Type': 'application/json' },mode: 'cors' })
   .then(response => {
       if (!response.ok) {
           alert('Error al consumir el servicio...');
       }
       return response.json();
   })
   .then(data => {

       limpiarTabla();
       obtenerTareas();
       
   })
   .catch(error => {
       console.error('Hubo un problema con la solicitud fetch: ', error);
   });
}


function actualizarTarea(id) {
   fetch(url + "/" + id, { method: 'PUT', headers: { 'Content-Type': 'application/json' },mode: 'cors' })
   .then(response => {
       if (!response.ok) {
           alert('Error al consumir el servicio...');
       }
       return response.json();
   })
   .then(data => {
       
       limpiarTabla();
       obtenerTareas();
       
   })
   .catch(error => {
       console.error('Hubo un problema con la solicitud fetch: ', error);
   });
}

function limpiarTabla() {

   var tabla = document.getElementById('tabla');
   
   var tbody = tabla.getElementsByTagName('tbody')[0];
   
   while (tbody.rows.length > 0) 
   {
       tbody.deleteRow(0);
   }
}