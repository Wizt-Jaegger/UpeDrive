<x-app-layout>
</x-app-layout>
<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
  </head>
  <body style="background-color: #121212; color: white; font-family: 'Ubuntu', sans-serif;">
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">  
            @if(session('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    {{ session('message') }}
                </div>
            @endif     
            <h2 style="text-align: center; font-size: 40px; padding-bottom: 20px; color: white;">Todos los vehículos</h2>

            <table style="
              margin: auto; 
              text-align: center; 
              width: 90%; 
              padding: 30px; 
              border-radius: 20px; 
              background-color: rgba(30, 30, 30, 0.65); 
              color: white; 
              backdrop-filter: blur(6px); 
              box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
              border: 2px solid #D90D4E;
              border-collapse: collapse;
              overflow: hidden;
            ">
              <thead style="background-color: #D90D4E;">
                <tr>
                  <th style="padding: 15px;">Nombre del Automóvil</th>
                  <th style="padding: 15px;">Descripción</th>
                  <th style="padding: 15px;">Cantidad</th>
                  <th style="padding: 15px;">Categoría</th>
                  <th style="padding: 15px;">Precio</th>
                  <th style="padding: 10px;">Estatus</th>
                  <th style="padding: 38px;">Imagen</th>
                  <th style="padding: 5px; ">Eliminar</th>
                  <th style="padding: 5px; ">Editar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($producto as $producto)
                <tr style="background-color: rgba(25, 28, 36, 0.7); transition: background-color 0.3s;" 
                    onmouseover="this.style.backgroundColor='rgba(17, 17, 24, 0.7)'" 
                    onmouseout="this.style.backgroundColor='rgba(25, 28, 36, 0.7)'">
                    <td style="padding: 15px;">{{$producto->title}}</td>
                    <td style="padding: 15px;">{{$producto->description}}</td>
                    <td style="padding: 15px;">{{$producto->quantity}}</td>    
                    <td style="padding: 15px;">{{$producto->category}}</td>
                    <td style="padding: 15px;">
                        ${{ number_format($producto->price, 2) }} MXN
                    </td>

                    <td style="padding: 15px;">
                        @if ($producto->discount_price == 1)
                            Nuevo
                        @elseif ($producto->discount_price == 2)
                            Semi nuevo
                        @elseif ($producto->discount_price == 3)
                            Usado
                        @else
                            Sin especificar
                        @endif
                    </td>
                  <td style="padding: 15px;">
                    <img src="/producto/{{$producto->image}}" alt="imagen del vehículo" style="width: 350px; height: 100px; border-radius: 10px; object-fit: cover; border: 2px solid #0fa5ae;">
                  </td>
                  <td style="padding: 15px;">
                      <a onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')" href="{{url('/delete_producto', $producto->id)}}" class="btn btn-danger">Eliminar</a>
                  </td>
                  <td style="padding: 15px;">
                      <a href="{{url('/update_producto', $producto->id)}}" class="btn btn-primary">Editar</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
