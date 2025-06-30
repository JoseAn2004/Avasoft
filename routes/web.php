<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pedidosp;
use App\Http\Controllers\FavoritoController;


use App\Http\Controllers\FavoritosController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ProductosController;
use App\Http\Controllers\VistaPublicaController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Admin\UsuariosWebController;
use App\Http\Controllers\Admin\ProspectosController;

use App\Http\Controllers\SuscripcionController;


// ==============================
// 🌐 RUTAS PÚBLICAS (sin login)
// ==============================


Route::post('/suscribirse', [SuscripcionController::class, 'guardar']);
Route::get('/', [ProductosController::class, 'mostrarPublico'])->name('ini');

Route::get('/new', [VistaPublicaController::class, 'new'])->name('nuevos');
Route::get('/hombre', [VistaPublicaController::class, 'hombre'])->name('men');
Route::get('/mujer', [VistaPublicaController::class, 'mujer'])->name('woman');

Route::get('/iniciarsession', [VistaPublicaController::class, 'iniciarsession'])->name('vistapublica.iniciarsession');
Route::get('/registropb', [VistaPublicaController::class, 'registropublico'])->name('vistapublica.registropublico');



// Productos visibles para todos
Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
Route::get('/productos/mujer', [ProductosController::class, 'mostrarMujer'])->name('vistapublica.mujer');
Route::get('/productos/hombre', [ProductosController::class, 'mostrarHombre'])->name('vistapublica.hombre');
Route::get('/productos/accesorios', [ProductosController::class, 'mostrarAccesorios'])->name('vistapublica.accesorios');
Route::get('/productos/nuevos', [ProductosController::class, 'mostrarNuevosProductos'])->name('vistapublica.new');



// Registro Cliente (usuario público)
Route::get('/registrarse', [UserRegisterController::class, 'showRegistrationForm'])->name('registro.form');
Route::post('/registrarse', [UserRegisterController::class, 'register'])->name('registro');

Route::get('/buscar-productos', [ProductosController::class, 'buscar'])->name('productos.buscar');



// ==============================
// 🔐 RUTAS DE AUTENTICACIÓN ADMIN
// ==============================

// Login Admin
Route::get('/loginadmin', [AdminLoginController::class, 'showLoginForm'])->name('loginadmin');
Route::post('/loginadmin', [AdminLoginController::class, 'login']);

// Registro Admin
Route::get('/registeradmin', [RegisterController::class, 'showRegistrationForm'])->name('registeradmin');
Route::post('/registeradmin', [RegisterController::class, 'register']);




// Logout cliente
Route::post('/logout-cliente', function () {
    Auth::guard('web')->logout();
    //request()->session()->invalidate();
    //request()->session()->regenerateToken();

    return redirect()->route('vistapublica.iniciarsession');
})->name('logout.cliente');

// Logout admin
Route::post('/logout-admin', function () {
    Auth::guard('admin')->logout();
    // request()->session()->invalidate();
    //request()->session()->regenerateToken();

    return redirect()->route('loginadmin');
})->name('logout.admin');


// ==============================
// 🔒 RUTAS PROTEGIDAS CLIENTE (guard web)
// ==============================

Route::get('/iniciar-sesion', [UserLoginController::class, 'showLoginForm'])->name('vistapublica.iniciarsession');
Route::post('/login-cliente', [UserLoginController::class, 'login'])->name('login.cliente');



Route::middleware(['auth:web'])->group(function () {
    Route::get('/mi-perfil', [ProfileController::class, 'miperfil'])->name('perfil.ver');
    Route::put('/perfil/actualizar', [ProfileController::class, 'actualizar'])->name('perfil.actualizar');
    Route::put('/perfil/direccion', [ProfileController::class, 'actualizarDireccion'])->name('perfil.actualizarDireccion');

    Route::get('/carrito', [VistaPublicaController::class, 'index'])->name('carrito.index');
    Route::get('/finalizar-pedido', [Pedidosp::class, 'finalizarPedido'])->name('vistapublica.procesocarrito');
    Route::get('/checkout', [Pedidosp::class, 'mostrarFormularioCheckout'])->name('checkout');
    Route::post('/checkout/guardar', [Pedidosp::class, 'guardarPedido'])->middleware('auth');


    Route::get('/mis-pedidos', [VistaPublicaController::class, 'pedidos'])->name('cliente.pedidos');
    Route::get('/mis-pedidos-json', [Pedidosp::class, 'pedidosJson'])->name('mis.pedidos.json');



    Route::post('/favorito/toggle', [FavoritoController::class, 'toggle'])->name('favorito.toggle');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
});



// ==============================
// 🔒 RUTAS PROTEGIDAS ADMIN (guard admin)
// ==============================

Route::prefix('admin')->name('admin.')->group(function () {
    // Rutas públicas (login)
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('loginadmin');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('loginadmin.submit');

    // Rutas protegidas
    Route::middleware('auth:admin')->group(function () {
        Route::get('/inicio', function () {
            return view('admin.inicio');
        })->name('inicio');

        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Subgrupo de productos PROTEGIDO
        Route::prefix('productos')->name('productos.')->group(function () {
            Route::get('/', [ProductosController::class, 'index'])->name('index');
            Route::get('/crear', [ProductosController::class, 'create'])->name('create');
            Route::post('/', [ProductosController::class, 'store'])->name('store');
            Route::get('/{producto}/editar', [ProductosController::class, 'edit'])->name('edit');
            Route::put('/{producto}', [ProductosController::class, 'update'])->name('update');
            Route::delete('/{producto}', [ProductosController::class, 'destroy'])->name('destroy');


            Route::get('/export/pdf', [ProductosController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel', [ProductosController::class, 'exportExcel'])->name('export.excel');
        });

        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [UsuariosController::class, 'index'])->name('index');
            // Route::get('/crear', [UsuariosController::class, 'create'])->name('create');
            //Route::post('/', [UsuariosController::class, 'store'])->name('store');
            //Route::get('/{usuario}/editar', [UsuariosController::class, 'edit'])->name('edit');
            //Route::put('/{usuario}', [UsuariosController::class, 'update'])->name('update');
            //Route::delete('/{usuario}', [UsuariosController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('usuarios-web')->name('usuariosweb.')->group(function () {
            Route::get('/', [UsuariosWebController::class, 'index'])->name('index');
            Route::get('/export/pdf', [UsuariosWebController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel', [UsuariosWebController::class, 'exportExcel'])->name('export.excel');

            // Route::get('/crear', [UsuariosWebController::class, 'create'])->name('create');
            // Route::post('/', [UsuariosWebController::class, 'store'])->name('store');
            // Route::get('/{usuario}/editar', [UsuariosWebController::class, 'edit'])->name('edit');
            // Route::put('/{usuario}', [UsuariosWebController::class, 'update'])->name('update');
            // Route::delete('/{usuario}', [UsuariosWebController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('prospectos-web')->name('prospectos.')->group(function () {
            Route::get('/', [ProspectosController::class, 'index'])->name('index');
        });
    });
});
