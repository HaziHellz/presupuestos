<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteDetailController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIfUserIsLoggedIn;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)
    ->name('user')
    ->group(
        function () {
            Route::get('/sign-in', 'signin')->name('-sign-in');
            Route::get('/sign-up', 'signup')->name('-sign-up');

            Route::get('/do-log-out', 'doLogout')->name('do-log-out');

            Route::post('/do-sign-up', 'store')->name('-do-sign-up');
            Route::post('/do-log-in', 'doLogin')->name('do-log-in');
        }
    );


Route::middleware([CheckIfUserIsLoggedIn::class])
    ->controller(QuoteController::class)
    ->name('quote')
    ->group(
        function () {
            Route::get('/', 'index')->name('-index');

            Route::post('/do-quote', 'store')->name('-store');


            Route::get('/quote/{id}/category/{category_id}', 'quotePage')->name('-page');

            Route::get('/quote/{id}/gen-pdf/category/{category_id}', 'pdf')->name('-pdf');


            Route::delete('/quote/delete', 'delete')->name('-delete');
            Route::put('/quote/update', 'update')->name('-update');

        }
    );


Route::middleware([CheckIfUserIsLoggedIn::class])
    ->controller(CategoryController::class)
    ->name('category')
    ->group(
        function () {
            // Listar categorías
            Route::get('/category', 'index')->name('-index');

            // Crear una nueva categoría
            Route::post('/category', 'store')->name('-store');

            // Mostrar formulario de edición
            Route::get('/category/{id}/edit', 'edit')->name('-edit');

            // Actualizar una categoría
            Route::put('/category/{id}', 'update')->name('-update');

            // Eliminar una categoría
            Route::post('/category/destroy', 'destroy')->name('-destroy');
        }
    );


Route::middleware([CheckIfUserIsLoggedIn::class])
    ->controller(ClientController::class)
    ->name('client')
    ->group(
        function () {
            Route::get('/client', 'index')->name('-index');
            Route::get('/client/add', 'storePage')->name('-storePage');
            Route::post('/client/add-process', 'store')->name('-store');
            Route::post('/client/delete', 'delete')->name('-delete');
            Route::post('/client/edit', 'edit')->name('-edit');
            //AGREGAR RUTAS QUE HAGAN FALTA
        }
    );

Route::middleware([CheckIfUserIsLoggedIn::class])
    ->controller(ConceptController::class)
    ->name('concept')
    ->group(
        function () {
            Route::get('/concepts', 'index')->name('-index');

            Route::get('/concepts/add', 'addForm')->name('-store-page');
            Route::get('/concepts/{category_id}/edit/{concept_id}', 'editForm')->name('-edit');

            Route::post('/concepts/do-add', 'store')->name('-store');
            Route::put('/concepts/do-update', 'update')->name('-update');
            Route::delete('/concept/do-delete', 'delete')->name('-delete');
            //AGREGAR RUTAS QUE HAGAN FALTA
        }
    );


Route::middleware([CheckIfUserIsLoggedIn::class])
    ->controller(QuoteDetailController::class)
    ->name('quote-detail')
    ->group(
        function () {
            Route::post('/add-detail', 'addDetail')->name('-add-detail');
            Route::delete('/delete-detail', 'delete')->name('-delete-detail');
        }
    );
