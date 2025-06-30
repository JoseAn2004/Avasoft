<div class="absolute w-full bg-orange-500 dark:hidden min-h-75"></div>
<!-- Sidebar -->
<aside x-show="!modalOpen" x-transition 
  class="fixed inset-y-0 flex flex-col items-start w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 bg-white shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-10 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" 
  aria-expanded="false">

  <div class="h-20 w-full relative">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" sidenav-close></i>
    <a class="flex justify-center items-center h-full bg-black w-full" target="_blank">
      <img src="{{ asset('images/vtadmin/img/logo.png') }}"
           class="h-10 w-auto max-w-full transition-all duration-200 ease-nav-brand dark:hidden"
           alt="main_logo" />
      <img src="{{ asset('images/vtadmin/img/logo.png') }}"
           class="h-10 w-auto max-w-full transition-all duration-200 ease-nav-brand hidden dark:block"
           alt="main_logo" />
    </a>
  </div>

  <div class="w-auto max-h-screen overflow-auto h-sidenav grow basis-full px-2">
    <ul class="flex flex-col space-y-1">

    <li>
        <h6 class="pl-6 mt-4 text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-white/60">Pagina Web</h6>
        
      </li>
            <hr class="my-4 border-t border-gray-300 dark:border-gray-600" />
      <li>
        <a href="{{ route('admin.inicio')}}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 dark:text-white dark:hover:bg-blue-800 dark:hover:text-white transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-600">
            <i class="ni ni-tv-2 text-blue-500 text-base"></i>
          </div>
          <span>Dashboard</span>
        </a>
      </li>

      <li>
        <a href="{{ route('admin.prospectos.index')}}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-700 dark:text-white dark:hover:bg-orange-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-500">
            <i class="ni ni-single-02 text-orange-500 text-base"></i>
          </div>
          <span>Lista de prospectos</span>
        </a>
      </li>

      <li>
        <a href="" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-100 hover:text-emerald-700 dark:text-white dark:hover:bg-emerald-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-500">
            <i class="ni ni-credit-card text-emerald-500 text-base"></i>
          </div>
          <span>Registro de compras</span>
        </a>
      </li>

      <li>
        <a href="" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-cyan-100 hover:text-cyan-700 dark:text-white dark:hover:bg-cyan-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-100 dark:bg-cyan-500">
            <i class="ni ni-hat-3 text-cyan-500 text-base"></i>
          </div>
          <span>Calificaciones</span>
        </a>
      </li>

      <li>
        <a href="" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 dark:text-white dark:hover:bg-red-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 dark:bg-red-500">
            <i class="ni ni-delivery-fast text-red-600 text-base"></i>
          </div>
          <span>Seguimiento</span>
        </a>
      </li>

      <li>
        <a href="" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 dark:text-white dark:hover:bg-red-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 dark:bg-red-500">
            <i class="ni ni-chart-bar-32 text-red-600 text-base"></i>
          </div>
          <span>Reportes</span>
        </a>
      </li>

      <li>
        <h6 class="pl-6 mt-4 text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-white/60">Administrativo</h6>
        
      </li>
            <hr class="my-4 border-t border-gray-300 dark:border-gray-600" />


      <li>
        <a href="{{ route('admin.usuariosweb.index')}}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-slate-100 hover:text-slate-700 dark:text-white dark:hover:bg-slate-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-500">
            <i class="ni ni-single-02 text-slate-700 text-base"></i>
          </div>
          <span>Usuarios Web</span>
        </a>
      </li>

      <li>
        <a href="{{ route('admin.usuarios.index')}}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-slate-100 hover:text-slate-700 dark:text-white dark:hover:bg-slate-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-500">
            <i class="ni ni-single-02 text-slate-700 text-base"></i>
          </div>
          <span>Usuarios Panel</span>
        </a>
      </li>

      <li>
        <a href="{{ route('admin.productos.index')}}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-700 dark:text-white dark:hover:bg-orange-600 transition-colors duration-200">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-500">
            <i class="ni ni-single-copy-04 text-orange-500 text-base"></i>
          </div>
          <span>Productos</span>
        </a>
      </li>

      
    </ul>
  </div>
</aside>

<!-- Main Content -->
<section class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
  <!-- Navbar -->
  <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
      <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
          <li class="text-sm leading-normal">
            <a class="text-white opacity-50" href="javascript:;">Pages</a>
          </li>
          <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Dashboard</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
      </nav>

      <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
        <div class="flex items-center md:ml-auto md:pr-4"></div>
        
        <div class="relative group cursor-pointer flex items-center space-x-3 text-white select-none">
        <!-- Perfil con nombre y rol -->
        <div class="flex items-center space-x-3">
          <i class="fa fa-user text-2xl"></i>
          <div>
            <p class="text-sm font-semibold leading-tight">Juan Pérez</p>
            <p class="text-xs text-yellow-200 uppercase tracking-wide">Administrador</p>
          </div>
        </div>

        <!-- Menú desplegable -->
        <ul
          class="absolute right-0 top-full mt-3 w-44 bg-white rounded-md shadow-lg text-gray-800 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-opacity duration-200 z-50"
        >
          <li>
            <a
              href="#"
              class="block px-4 py-2 text-sm hover:bg-orange-100 transition-colors"
              >Mi perfil</a
            >
          </li>
          <li>
            <a
              href="#"
              class="block px-4 py-2 text-sm hover:bg-orange-100 transition-colors"
              >Cerrar sesión</a
            >
          </li>
        </ul>
      </div>



      </div>
    </div>
  </nav>
</section>
