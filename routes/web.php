<?php

use App\Http\Controllers\PagesController;
use App\Modules\Admin\Controllers\UsersController;
use App\Modules\Category\Controllers\CategoriesController;
use App\Modules\Report\Controllers\ReportsController;
use App\Modules\Client\Controllers\ClientsController;
use App\Modules\Problem\Controllers\ProblemTypesController;
use App\Modules\Product\Controllers\ProductsController;
use App\Modules\Status\Controllers\StatusesController;
use App\Modules\Technic\Controllers\TechnicController;
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
Route::middleware('lang')->group(function (){
    Route::group([
        'middleware' => ['auth', 'technician'],
        'prefix' => 'technician',
        'as' => 'technician.'],
        function () {
            Route::get('products', [ProductsController::class, 'claimed'])
                ->name('products');
            Route::get('products/{product}/reports/download', [ProductsController::class, 'reportsDownload'])
                ->name('products.report.download');
            Route::get('reports', [ReportsController::class, 'selfReports'])
                ->name('reports');
            Route::get('reports/download', [ReportsController::class, 'selfReportsDownload'])
                ->name('reports.download');
        });

    Route::group([
        'middleware' => ['auth', 'admin'],
        'as' => 'admin.',
        'prefix' => 'admin'],
        function () {
            Route::get('reports', [ReportsController::class, 'reports'])
                ->name('reports');
            Route::get('reports/download', [ReportsController::class, 'reportsDownload'])
                ->name('reports.download');
            Route::resource('users', UsersController::class);
            Route::get('users-deleted', [UsersController::class, 'deleted']);

            Route::resource('categories', CategoriesController::class);
            Route::get('categories-deleted', [CategoriesController::class, 'deleted']);

            Route::resource('statuses', StatusesController::class);
            Route::get('statuses-deleted', [StatusesController::class, 'deleted']);

            Route::post('users/invite', [UsersController::class, 'invite'])
                ->name('users.invite.send');
            Route::get('users/invite/show', [UsersController::class, 'showInviteForm'])
                ->name('users.invite.show');
        });
    Route::group(['middleware' => ['auth']],
        function () {
            Route::get('/', [PagesController::class, 'dashboard'])
                ->name('index');
            Route::resource('products', ProductsController::class);
            Route::get('products-deleted', [ProductsController::class, 'deleted']);
            Route::resource('problems', ProblemTypesController::class);
            Route::get('problems-deleted', [ProblemTypesController::class, 'deleted']);
            Route::resource('clients', ClientsController::class);
            Route::get('clients-deleted', [ClientsController::class, 'deleted']);
            Route::post('products/upload/image', [ProductsController::class, 'uploadImage']);
        });
    Route::get('/show', [ProductsController::class, 'showProductInformation'])
        ->name('qr');
    Route::get('lang/{lang}', [PagesController::class, 'setLang'])
        ->name('lang');
    Route::middleware('guest')->group(function (){
        Route::get('invite/{encryptedEmail}', [TechnicController::class, 'showRegistration'])
            ->name('invite');
        Route::post('invite/{encryptedEmail}', [TechnicController::class, 'register'])
            ->name('registration');
    });
});
