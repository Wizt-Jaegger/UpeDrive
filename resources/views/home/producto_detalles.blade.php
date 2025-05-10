<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
       <base href="/public">
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="home/images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
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
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->

        <!-- Product Card -->
        <div class="container my-5" style="background-image: url('../admin/assets/bg.jpg'); background-size: cover; background-position: center; padding: 50px;width: 100%;">
            <div class="card text-white shadow-lg rounded-4 p-4" style=" background-color: rgba(255,255,255,0.1); border-radius:20px; margin: auto;">
                <div class="row g-0">
                    <div class="col-md-6 d-flex align-items-center justify-content-center p-3">
                        <img src="producto/{{ $producto->image }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $producto->title }}">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body d-flex flex-column justify-content-center h-100">
                            <h4 class="card-title mb-2 fw-bold">{{ $producto->title }}</h4>
                            <p class="mb-2 text-muted fst-italic" style="color: #bbb;">
                                {{ [1 => 'Nuevo', 2 => 'Semi nuevo', 3 => 'Usado'][$producto->discount_price] ?? 'Sin especificar' }}
                            </p>
                            <h5 class=" mb-3" style="color: #0fa5ae;">
                                ${{ number_format($producto->price, 2) }} 
                                <span class="text-secondary" style="font-size: 0.8em;">MXN</span>
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li><strong>Categoría:</strong> {{ $producto->category }}</li>
                                <li><strong>Descripción:</strong> {{ $producto->description }}</li>
                                <li><strong>Disponibles:</strong> {{ $producto->quantity }}</li>
                            </ul>
                            <div class="row mt-4">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                <a href="{{ url('/') }}" class="btn btn-outline-light px-4 py-2 rounded-pill shadow-sm w-100">
                                    ← Regresar
                                </a>
                                </div>
                                <div class="col-md-8">
                                    <form action="{{ url('add_cart', $producto->id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                                        @csrf
                                        <input
                                            type="number"
                                            name="quantity"
                                            min="1"
                                            value="1"
                                            class="form-control"
                                            style="width: 100px; background-color: rgba(0,0,0,0); color: #fff; z-index: 10; pointer-events: auto; border: 1px solid #fff; border-radius: 20px;"
                                        >
                                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                                            <i class="fa fa-shopping-cart me-2"></i> Agregar al carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer section -->
        @include('home.footer')

   </body>
</html>