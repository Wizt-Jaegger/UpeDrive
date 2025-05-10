<section class="product_section layout_padding">
   <div class="container">
      <div class="heading_container heading_center">
         <h2>
            Nuestros <span>carros</span>
         </h2>
      </div>
      <div class="row">
         @foreach ($producto as $productos)
            <div class="col-sm-6 col-md-4 col-lg-4">
               <div class="box">
                  <div class="option_container">
                     <div class="options">
                        <a href="{{ url('producto_detalles/' . $productos->id) }}" class="option1">
                        Ver Detalles
                        </a>
                        <form action="{{url('add_cart',$productos->id)}}" method="Post">
                           @csrf
                           <div class="row">
                              <div class="col-md-4">
                              <input
                                 type="number"
                                 name="quantity"
                                 min="1"
                                 value="1"
                                 style="width: 100px; z-index: 10; position: relative; pointer-events: auto; background-color: #fff; color: #000;"
                              >
                              </div>
                              <div class="col-md-4">
                                 <input type="submit" value="Agregar al carrito" class="option2">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="img-box">
                     <img src="producto/{{$productos->image}}" alt="">
                  </div>
                  <div class="detail-box" style="display: flex; flex-direction: column; gap: 6px;">
                     <h5 style="margin: 0; font-size: 1.1rem;">
                        {{ $productos->title }}
                     </h5>
                     <p style="margin: 0; font-size: 0.95rem; color: #ccc;">
                        {{ [1 => 'Nuevo', 2 => 'Semi nuevo', 3 => 'Usado'][$productos->discount_price] ?? 'Sin especificar' }}
                     </p>
                     <h6 style="margin: 0; font-size: 1rem;">
                        ${{ number_format($productos->price, 2) }}
                        <span style="font-size: 0.85em; color: #aaa;">MXN</span>
                     </h6>
                  </div>
               </div>
            </div>
         @endforeach

         <span style="padding-top: 20px; display: block;">
            {!! $producto->withQueryString()->links('pagination::bootstrap-5') !!}
         </span>

         <!-- Estilos para modo oscuro de paginación -->
         <style>
            .pagination {
               background-color: transparent;
            }

            .pagination .page-link {
               background-color: #1e1e1e;
               color: #ccc;
               border: 1px solid #333;
               transition: background-color 0.2s, color 0.2s;
            }

            .pagination .page-link:hover {
               background-color: #333;
               color: #fff;
            }

            .pagination .page-item.active .page-link {
               background-color: #0d6efd;
               color: #fff;
               border-color: #0d6efd;
            }
         </style>

      </div>
   </div>
</section>
