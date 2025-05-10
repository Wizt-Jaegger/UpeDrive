<x-app-layout>
</x-app-layout>
<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;
        }
        .h2_font {
            font-size: 40px;
            padding-bottom: 40px;
            color: white;
        }
        .center {
            margin: auto;
            width: 50%;
            text-align: center;
            border: 2px solid #D90D4E;
            border-radius: 20px;
            margin-top: 40px;
            background-color: rgba(25, 28, 36, 0.7); /* fondo con transparencia */
            color: white;
            padding: 20px;
        }
        .input_color {
            color: black;
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid black;
        }
        .table-container {
            margin: auto;
            width: 60%;
            margin-top: 40px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-collapse: collapse;
            background-color: rgba(30, 30, 30, 0.7); /* fondo con transparencia */
            color: #ffffff;
        }
        thead {
            background-color: #D90D4E;
            color: white;
        }
        tbody tr {
            background-color: rgba(25, 28, 36, 0.7);
            transition: background-color 0.3s;
        }
        tbody tr:hover {
            background-color: rgba(17, 17, 24, 0.7);
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.header')
      <div class="main-panel">
        <div class="content-wrapper">
          @if(session()->has('message'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{session()->get('message')}}
          </div>
          @endif

          <div class="div_center center">
            <h2 class="h2_font">Agrega una categoría</h2>
            <form action="{{'/add_category'}}" method="POST">
              @csrf
              <input style="border-radius:20px;" type="text" class="input_color" name="category" placeholder="Escribe el nombre de la categoría">
              &nbsp;&nbsp;
              <input style="border-radius:20px; background-color:#0fa5ae;" type="submit" class="btn btn-primary" name="submit" value="Agregar Categoría">
            </form>
          </div>

          <table class="table-container">
            <thead>
              <tr>
                <th style="padding: 15px; font-size: 16px;">Nombre de categoría</th>
                <th style="padding: 15px; font-size: 16px;">Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $data)
              <tr>
                <td style="padding: 15px; text-align: center; font-size: 16px;">{{$data->category_name}}</td>
                <td style="padding: 15px; text-align: center;">
                  <a 
                    onclick="return confirm('¿Estás seguro de eliminar esta categoría?')" 
                    href="{{url('delete_category', $data->id)}}"
                    style="border-radius: 20px; background-color: #D90D4E; border: 1px solid #b1063d; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; font-size: 14px; transition: background-color 0.3s, opacity 0.3s;"
                    onmouseover="this.style.opacity='0.85'" 
                    onmouseout="this.style.opacity='1'"
                  >
                    Eliminar
                  </a>
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
