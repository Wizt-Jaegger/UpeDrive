<x-app-layout>
</x-app-layout>
<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
    <style>
      body {
        background-color: #121212;
        color: white;
        font-family: 'Ubuntu', sans-serif;
      }
      .tabla-estilo {
        margin: auto;
        text-align: center;
        width: 95%;
        padding: 30px;
        border-radius: 20px;
        background-color: rgba(30, 30, 30, 0.65);
        color: white;
        backdrop-filter: blur(6px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: 2px solid #D90D4E;
        border-collapse: collapse;
        overflow: hidden;
      }
      .tabla-estilo thead {
        background-color: #D90D4E;
      }
      .tabla-estilo tbody tr {
        background-color: rgba(25, 28, 36, 0.7);
        transition: background-color 0.3s;
      }
      .tabla-estilo tbody tr:hover {
        background-color: rgba(17, 17, 24, 0.7);
      }
      .btn-danger {
        background-color: #D90D4E;
        border: none;
        margin: 10px 15px;
        border-radius: 10px;
        color: white;
        transition: background-color 0.3s;
      }
      .btn-danger:hover {
        background-color: #a5083a;
      }
      h2 {
        text-align: center;
        font-size: 40px;
        padding-bottom: 20px;
        color: white;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.header')

      <div class="main-panel">
        <div class="content-wrapper">

          @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
          @endif

          <h2>Administrar Citas</h2>

          <table class="tabla-estilo">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Total de Citas</th>
                <th>Carros</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach($citas as $cita)
              &nbsp;
              <tr>
                <td>{{ $cita['name'] }}</td>
                <td>{{ $cita['email'] }}</td>
                <td>{{ $cita['fecha'] }}</td>
                <td>{{ $cita['hora'] }}</td>
                <td>{{ $cita['total'] }}</td>
                <td>
                  <ul>
                    @foreach($cita['carros'] as $carro)
                      <li>{{ $carro }}</li>
                    @endforeach
                  </ul>
                </td>
                <td>
                  <form 
                    action="{{ url('/admin-cancelar-cita/'.$cita['email'].'/'.$cita['fecha'].'/'.$cita['hora']) }}" 
                    method="POST" 
                    onsubmit="return confirm('¿Cancelar todas las citas de este bloque?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Cancelar</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>    

    @include('admin.script')
  </body>
</html>
