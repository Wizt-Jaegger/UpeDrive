<x-app-layout>
</x-app-layout>
<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="/public">
    <meta charset="utf-8" />
    @include('admin.css')
    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;
        }
        .font_size {
            font-size: 40px;
            padding-bottom: 40px;
        }
        label {
            display: inline-block;
            width: 200px;
        }
    </style>
  </head>
  <body>
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
          <div class="div_center">
            <h1 class="font_size">Edita tu Automóvil</h1>

            <form action="{{ url('/edit_producto', $producto->id) }}" method="POST" enctype="multipart/form-data">    

                @csrf
                <div>
                    <label>Nombre del Vehículo</label>
                    <input type="text" name="titulo" placeholder="Escribe el nombre del automóvil" 
                    value="{{$producto->title}}"
                    style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);" required><br><br>
                </div>
                <div>
                    <label>Descripción del Vehículo</label>
                    <input type="text" name="description" placeholder="Describe el automóvil" 
                    value="{{$producto->description}}"
                    style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);" required><br><br>
                </div>
                <div>
                    <label>Precio del Vehículo</label>
                    <input type="number" name="price" placeholder="Escribe el precio" 
                    value="{{$producto->price}}"
                    style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);" required><br><br>
                </div>
                <div>
                    <label for="tipo_producto">Tipo de Producto</label>
                    <select name="dis_price" id="tipo_producto"
                        style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);" required>
                        <option value="" {{ is_null($producto->discount_price) ? 'selected' : '' }}>Selecciona una opción</option>
                        <option value="1" {{ $producto->discount_price == 1 ? 'selected' : '' }}>Nuevo</option>
                        <option value="2" {{ $producto->discount_price == 2 ? 'selected' : '' }}>Semi nuevo</option>
                        <option value="3" {{ $producto->discount_price == 3 ? 'selected' : '' }}>Usado</option>
                    </select>
                    <br><br>
                </div>




                <div>
                    <label>Cantidad de Unidades</label>
                    <input type="number" name="quantity" min="0" placeholder="Escribe la cantidad" 
                    value="{{$producto->quantity}}"
                    style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);" required><br><br>
                </div>
                <div>
                    <label>Categoría del Automóvil</label>
                    <select style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);" name="category"required>
                    <option value="{{$producto->category}}" selected="">
                        {{$producto->category}}
                    </option>  
                    @foreach($category as $category)
                        <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                    @endforeach
                    </select>
                </div>
                &nbsp;
                <div>
                    <label>Imagen actual</label>
                    <img style="margin:auto;" height = "100" width="100" src="/producto/{{$producto->image}}" alt="">
                </div>
                &nbsp;
                <div>
                    <label>Cambiar imagen</label>
                    <input type="file" name="image" style="color: black; border: none; border-radius: 20px; background-color: rgba(255,255,255,0.8);"><br><br>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" value="Actualizar Automóvil" style="border-radius: 20px;">
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
