<header>
   <nav class="navbar navbar-expand-lg navbar-light bg-light container-1660">
      <a class="navbar-brand" href="#"><img src="img/logo.png" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
         aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <div class="m-auto d-flex align-items-center">
            <a href="#">Search</a>
            <span>Search here for video and photos from any surf break around the world!!</span>
         </div>
         @if (Route::has('login'))
         <ul class="navbar-nav ml-auto">
            @auth
            <li class="nav-item ">
               <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard </a>
            </li>
            @else
            <li class="nav-item ">
               <a class="nav-link" href="{{ route('login') }}">Login </a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
               <a class="nav-link" href="{{ route('register') }}">Signup</a>
            </li>
            @endif
            @endif
         </ul>
         @endif 
      </div>
   </nav>
</header>