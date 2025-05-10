<!DOCTYPE html>
<html>
<head>
   <!-- Metas y CSS como lo tenías -->
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <link rel="shortcut icon" href="home/images/favicon.png" type="">
   <title>Famms - Fashion HTML Template</title>
   <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
   <link href="home/css/font-awesome.min.css" rel="stylesheet" />
   <link href="home/css/style.css" rel="stylesheet" />
   <link href="home/css/responsive.css" rel="stylesheet" />

   <style type="text/css">
      .center {
         margin: auto;
         width: 60%;
         text-align: center;
         padding: 30px;
      }
      table {
         width: 100%;
         border-collapse: collapse;
         background-color: #1e1e1e;
         color: #ffffff;
         box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
         border-radius: 12px;
         overflow: hidden;
      }
      th, td {
         padding: 15px;
         text-align: center;
         font-size: 16px;
         border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }
      th {
         background-color: #D90D4E;
         color: white;
      }
      tr {
         background-color: rgba(25, 28, 36, 0.1);
         transition: background-color 0.3s;
      }
      tr:hover {
         background-color: rgba(17, 17, 24, 0.1);
      }
      .btn-danger {
         background-color: #D90D4E;
         border: 1px solid #b1063d;
         color: white;
         padding: 10px 15px;
         font-size: 14px;
         transition: background-color 0.3s, opacity 0.3s;
         border-radius: 20px;
      }
      .btn-danger:hover {
         opacity: 0.85;
      }
      h1 {
         color: white;
      }
      .hours-grid {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
         gap: 10px;
         margin-top: 15px;
      }
      .hour-slot.selected {
        background-color: #0fa5ae;
        color: white;
        border: 1px solid #0fa5ae;
      }

      .hour-slot {
         background-color: #0fa5ae;
         color: white;
         border: none;
         padding: 10px 20px;
         border-radius: 10px;
         cursor: pointer;
         transition: background-color 0.3s;
      }
      .hour-slot:hover {
         background-color: #097f89;
      }
      .hour-slot.selected {
         background-color: #074b50;
      }
   </style>
</head>
<body>
   <div class="hero_area">
      @include('home.header')

      <div class="container my-5" style="background-image: url('../admin/assets/bg.jpg'); background-size: cover; background-position: center; padding: 50px;">
         @if(session()->has('message'))
         <div class="alert alert-success" style="background-color: rgba(255,255,255,0.5); color: black; border-radius: 20px; text-align: center;">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session()->get('message') }}
         </div>
         @endif

         <div class="center">
            <table>
               <tr>
                  <th>Nombre carro</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Imagen</th>
                  <th>Acción</th>
               </tr>
               @php $totalprice = 0; @endphp
               @foreach($cart as $cart)
               <tr>
                  <td>{{ $cart->product_title }}</td>
                  <td>{{ $cart->quantity }}</td>
                  <td>${{ number_format($cart->price, 2, '.', ',') }} MXN</td>
                  <td><img height="100" width="100" src="/producto/{{ $cart->image }}"></td>
                  <td><a class="btn btn-danger" onclick="return confirm('¿Eliminar este auto de tu carrito?')" href="{{ url('remove_cart', $cart->id) }}">Eliminar</a></td>
               </tr>
               @php $totalprice += $cart->price; @endphp
               @endforeach
            </table>

            <div style="padding-top: 20px;">
               <h1>Precio total: ${{ number_format($totalprice, 2, '.', ',') }} MXN</h1>
            </div>

            <div style="margin-top: 40px;">
               <h1>Agenda tu cita</h1>
               <form action="/ruta-de-envio" method="POST">
                  @csrf
                  <div style="margin-bottom: 15px;">
                     <label for="fechaCita">Selecciona una fecha:</label><br>
                     <input type="date" id="fechaCita" name="fechaCita" required onchange="actualizarHoras()" style="border-radius: 10px; padding: 8px; border: 1px solid white; background-color: rgba(255,255,255,0.1); color: gray;">
                  </div>

                  <div style="margin-bottom: 15px;">
                     <label for="tipoCita">Selecciona el tipo de cita:</label><br>
                     <select id="tipoCita" name="tipoCita" required style="border-radius: 10px; padding: 8px; border: 1px solid white; background-color: rgba(255,255,255,0.1); color: gray;">
                        <option value="">-- Selecciona una opción --</option>
                        <option value="1">Cita comprar</option>
                        <option value="2">Cita testear</option>
                     </select>
                  </div>

                  <div>
                      <label for="horaCita">Selecciona una hora:</label>
                      <div class="hours-grid" id="horariosDisponibles">
                          @foreach(['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00'] as $hora)
                              <button type="button" class="hour-slot" data-hora="{{ $hora }}" onclick="seleccionarHora('{{ $hora }}')">{{ $hora }}</button>
                          @endforeach
                      </div>
                      <p id="mensajeNoDisponibilidad" style="display:none; color:red;">No hay horarios disponibles para este día.</p>
                      <input type="hidden" name="horaCita" id="horaCita" required>
                  </div>
                  <script>
                        const horasDisponibles = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00'];

                        function actualizarHoras() {
                        const fecha = document.getElementById('fechaCita').value;
                        const botones = document.querySelectorAll('.hour-slot');
                        const mensaje = document.getElementById('mensajeNoDisponibilidad');

                        if (!fecha) return;

                        fetch(`/horas-disponibles?fecha=${fecha}`)
                            .then(res => res.json())
                            .then(data => {
                                // Mostrar todos los botones antes de filtrar
                                botones.forEach(btn => btn.style.display = 'inline-block');

                                const ocupadas = data.ocupadas || [];

                                let disponibles = 0;

                                botones.forEach(btn => {
                                    const hora = btn.getAttribute('data-hora');
                                    if (ocupadas.includes(hora)) {
                                    btn.style.display = 'none';
                                    } else {
                                    disponibles++;
                                    }
                                });

                                mensaje.style.display = disponibles === 0 ? 'block' : 'none';
                            })
                            .catch(err => {
                                console.error('Error al obtener las horas:', err);
                            });
                        }

                        function seleccionarHora(hora) {
                        document.getElementById('horaCita').value = hora;
                        const botones = document.querySelectorAll('.hour-slot');
                        botones.forEach(btn => btn.classList.remove('selected'));
                        const botonSeleccionado = Array.from(botones).find(btn => btn.textContent === hora);
                        if (botonSeleccionado) {
                            botonSeleccionado.classList.add('selected');
                        }
                        }
                  </script>


                  <a 
                      href="#" 
                      onclick="redirigirConParametros()" 
                      class="btn btn-primary mt-4" 
                      style="border-radius: 20px; background-color: #0fa5ae; border: none; padding: 10px 20px; color: white; text-decoration: none;">
                      Agendar Cita
                  </a>

                  <script>
                      function redirigirConParametros() {
                          const fecha = document.getElementById('fechaCita').value;
                          const hora = document.getElementById('horaCita').value;
                          const tipo = document.getElementById('tipoCita').value;

                          if (!fecha || !tipo || !hora) {
                              alert('Por favor selecciona una fecha, hora y un tipo de cita.');
                              return;
                          }

                          const url = `/agendar_cita?fecha=${encodeURIComponent(fecha)}&hora=${encodeURIComponent(hora)}&tipo=${encodeURIComponent(tipo)}`;
                          window.location.href = url;
                      }
                  </script>


               </form>
            </div>
         </div>
      </div>

      @include('home.footer')
   </div>

   <div class="cpy_">
      <p class="mx-auto">© 2025 Todos los derechos reservados <a href="https://emireyes.com/">Luis E. Reyes G.</a><br>
         Hecho Por <a href="https://emireyes.com/" target="_blank">Luis E. Reyes G.</a>
      </p>
   </div>

   <!-- Scripts -->
   <script src="home/js/jquery-3.4.1.min.js"></script>
   <script src="home/js/popper.min.js"></script>
   <script src="home/js/bootstrap.js"></script>
   <script src="home/js/custom.js"></script>

   <!-- Script para seleccionar la hora -->
   <script>
      function seleccionarHora(hora) {
         document.querySelectorAll('.hour-slot').forEach(btn => btn.classList.remove('selected'));
         event.target.classList.add('selected');
         document.getElementById('horaCita').value = hora;
      }
   </script>
</body>
</html>
