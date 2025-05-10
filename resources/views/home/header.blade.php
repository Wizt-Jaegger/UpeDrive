<header class="header_section">
            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container ">
                  <a class="navbar-brand" href="{{'/'}}"><img width="250" src="home/images/logo.png" alt="#" /></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav">
                        <li class="nav-item active">
                           <a class="nav-link" href="{{'/'}}">Inicio <span class="sr-only">(current)</span></a>
                        </li>
                       <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">Pages <span class="caret"></span></a>
                           <ul class="dropdown-menu">
                              <li><a href="home/about.html">Acerca De</a></li>
                              <li><a href="home/testimonial.html">Testimonios</a></li>
                           </ul>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="home/product.html">Productos</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="home/blog_list.html">Blog</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="home/contact.html">Contacto</a>
                        </li>
                        @if (Auth::check() && Auth::user()->usertype == 0)
                           <li class="nav-item">
                              <a class="nav-link" href="{{ url('citas') }}">Citas</a>
                           </li>
                        @endif


                        <li class="nav-item">
                           <a class="nav-link" href="{{url('show_cart')}}"><i class="fa fa-shopping-cart me-2"></i></a>
                        </li>
                        <form class="form-inline">
                           <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                           <i class="fa fa-search" aria-hidden="true"></i>
                           </button>
                        </form>
                        @if (Route::has('login'))
                        @auth
                        <li class="nav-item">
                            <x-app-layout></x-app-layout>  
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="btn btn-primary" style="border-radius: 20px; background-color: #D90D4E; border: none;" href="{{route('login')}}">Inicia Sesión</a>
                        </li>
                        &nbsp;&nbsp;
                        <li class="nav-item ms-2">
                            <a class="btn btn-secondary" style="border-radius: 20px; border: none;" href="{{route('register')}}">Regístrate</a>
                        </li>
                        @endauth
                        @endif
                     </ul>
                  </div>
               </nav>
            </div>
         </header>