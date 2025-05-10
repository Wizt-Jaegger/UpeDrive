<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="home/images/favicon.png" type="">
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />
   </head>
   <body>

      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         <div class="container my-5" style="background-image: url('../admin/assets/bg.jpg'); background-size: cover; background-position: center; padding: 50px;">
            @if(session()->has('message'))
                <div class="alert alert-success" style="background-color: rgba(255,255,255,0.5); color: black; border-radius: 20px; text-align: center;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{session()->get('message')}}
                </div>
            @endif
            <div class="center">
                
            <table class="table  table-striped table-hover" style="background-color: rgba(255,255,255,0.5); color: black; border-radius: 20px; text-align: center;">
                <thead  style="background-color: #D90D4E; border-radius: 20px; color: white; border:none --important;" >
                    <tr>
                        <th>ID Compuesto</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Autos</th>
                        <th>Tipo de Cita</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $clave => $grupo)
                        @php
                            $primera = $grupo->first();
                            $idCompuesto = md5($primera->fecha . $primera->hora . $primera->user_id);
                            $fechaHoraCita = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $primera->fecha . ' ' . $primera->hora);
                            $horaActual = \Carbon\Carbon::now();
                            $puedeCancelar = $horaActual->diffInHours($fechaHoraCita, false) >= 1;
                        @endphp
                        <tr>
                            <td>{{ $idCompuesto }}</td>
                            <td>{{ $primera->fecha }}</td>
                            <td>{{ $primera->hora }}</td>
                            <td>
                                <ul>
                                    @foreach($grupo as $cita)
                                        <li>{{ $cita->product_title }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if($primera->tipoCita == '1') Ver
                                @elseif($primera->tipoCita == '2') Probar
                                @else Otro
                                @endif
                            </td>
                            <td>
                                @if($puedeCancelar)
                                    <form method="POST" action="{{ url('cancelar-cita/' . $primera->fecha . '/' . $primera->hora) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Cancelar</button>
                                    </form>
                                @else
                                    <span style="color:#D90D4E;">No se puede cancelar</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            </div>
        </div>
         
        
         
      

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2025 Todos los derechos reservados <a href="https://emireyes.com/">Luis E. Reyes G.</a><br>
         
            Hecho Por <a href="https://emireyes.com/" target="_blank">Luis E. Reyes G.</a>
         
         </p>
      </div>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>