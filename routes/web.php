<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/dashboard', 'DashboardController');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Almacenero']], function () {
        Route::get('/categoria', 'CategoriaCotroller@index');
        Route::post('/categoria/registrar', 'CategoriaCotroller@store');
        Route::put('/categoria/actualizar', 'CategoriaCotroller@update');
        Route::put('/categoria/desactivar', 'CategoriaCotroller@desactivar');
        Route::put('/categoria/activar', 'CategoriaCotroller@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaCotroller@selectCategoria');

        Route::get('/articulo', 'ArticulosController@index');
        Route::post('/articulo/registrar', 'ArticulosController@store');
        Route::put('/articulo/actualizar', 'ArticulosController@update');
        Route::put('/articulo/desactivar', 'ArticulosController@desactivar');
        Route::put('/articulo/activar', 'ArticulosController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticulosController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticulosController@listarArticulos');
        Route::get('/articulo/listarPdf', 'ArticulosController@listarPdf')->name('articulos_pdf');

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
    });

    Route::group(['middleware' => ['Vendedor']], function () {
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        Route::get('/articulo/buscarArticuloVenta', 'ArticulosController@buscarArticuloVenta');
        Route::get('/articulo/listarArticulosVenta', 'ArticulosController@listarArticulosVenta');

        Route::get('/venta', 'VentaController@index');
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');
    });

    Route::group(['middleware' => ['Administrador']], function () {
        Route::get('/categoria', 'CategoriaCotroller@index');
        Route::post('/categoria/registrar', 'CategoriaCotroller@store');
        Route::put('/categoria/actualizar', 'CategoriaCotroller@update');
        Route::put('/categoria/desactivar', 'CategoriaCotroller@desactivar');
        Route::put('/categoria/activar', 'CategoriaCotroller@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaCotroller@selectCategoria');

        Route::get('/articulo', 'ArticulosController@index');
        Route::post('/articulo/registrar', 'ArticulosController@store');
        Route::put('/articulo/actualizar', 'ArticulosController@update');
        Route::put('/articulo/desactivar', 'ArticulosController@desactivar');
        Route::put('/articulo/activar', 'ArticulosController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticulosController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticulosController@listarArticulos');
        Route::get('/articulo/buscarArticuloVenta', 'ArticulosController@buscarArticuloVenta');
        Route::get('/articulo/listarArticulosVenta', 'ArticulosController@listarArticulosVenta');
        Route::get('/articulo/listarPdf', 'ArticulosController@listarPdf')->name('articulos_pdf');

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');


        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');


        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');

        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
    });
});

//Route::get('/home', 'HomeController@index')->name('home');
