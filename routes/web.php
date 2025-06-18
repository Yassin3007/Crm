<?php

use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\StatisticsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\DistrictController;
use App\Http\Controllers\Dashboard\BranchController;
use App\Http\Controllers\Dashboard\LeadController;
use App\Http\Controllers\Dashboard\SourceController;
use App\Http\Controllers\Dashboard\ProductController;






// Authentication Routes
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/language/{locale}', [\App\Http\Controllers\HomeController::class, 'switchLanguage'])->name('language.switch');
// Profile Routes
Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::put('/profile', [App\Http\Controllers\AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'showForgotPasswordForm'])->name('password.request')->middleware('guest');
Route::get('/reset-password', [App\Http\Controllers\AuthController::class, 'showResetPasswordForm'])->name('password.reset')->middleware('guest');


Route::get('/auth/google', [LeadController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('/auth/google/callback', [LeadController::class, 'handleGoogleCallback'])->name('google.callback');


// Profile routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {

//    Route::prefix('dashboard')->group(function () {
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('dashboard');
//        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
        Route::get('/statistics/chart-data', [StatisticsController::class, 'getChartDataAjax'])->name('statistics.chart-data');
//    });
    Route::get('/', [\App\Http\Controllers\Dashboard\StatisticsController::class,'index'])->name('dashboard');

//    Route::get('/statistics', function () {
//
//        return view('dashboard.index');
//    })->name('dashboard');
    // Profile edit page
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profile
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Delete profile image
    Route::delete('/profile/delete-image', [ProfileController::class, 'deleteImage'])->name('profile.delete-image');

    // Logout route
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});











// Routes for Role
Route::middleware(['auth'])->group(function() {
    Route::get('roles', [RoleController::class, 'index'])
        ->name('roles.index')
        ->middleware('can:view_role');

    Route::get('roles/create', [RoleController::class, 'create'])
        ->name('roles.create')
        ->middleware('can:create_role');

    Route::post('roles', [RoleController::class, 'store'])
        ->name('roles.store')
        ->middleware('can:create_role');

    Route::get('roles/{role}', [RoleController::class, 'show'])
        ->name('roles.show')
        ->middleware('can:view_role');

    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])
        ->name('roles.edit')
        ->middleware('can:edit_role');

    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->name('roles.update')
        ->middleware('can:edit_role');

    Route::delete('roles/{role}', [RoleController::class, 'destroy'])
        ->name('roles.destroy')
        ->middleware('can:delete_role');
});

// Routes for Permission
Route::middleware(['auth'])->group(function() {
    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('permissions.index')
        ->middleware('can:view_permission');

    Route::get('permissions/create', [PermissionController::class, 'create'])
        ->name('permissions.create')
        ->middleware('can:create_permission');

    Route::post('permissions', [PermissionController::class, 'store'])
        ->name('permissions.store')
        ->middleware('can:create_permission');

    Route::get('permissions/{permission}', [PermissionController::class, 'show'])
        ->name('permissions.show')
        ->middleware('can:view_permission');

    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])
        ->name('permissions.edit')
        ->middleware('can:edit_permission');

    Route::put('permissions/{permission}', [PermissionController::class, 'update'])
        ->name('permissions.update')
        ->middleware('can:edit_permission');

    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])
        ->name('permissions.destroy')
        ->middleware('can:delete_permission');
});







// Routes for User
Route::middleware(['auth'])->group(function() {
    Route::get('users', [UserController::class, 'index'])
        ->name('users.index')
        ->middleware('can:view_user');

    Route::get('users/create', [UserController::class, 'create'])
        ->name('users.create')
        ->middleware('can:create_user');

    Route::post('users', [UserController::class, 'store'])
        ->name('users.store')
        ->middleware('can:create_user');

    Route::get('users/{user}', [UserController::class, 'show'])
        ->name('users.show')
        ->middleware('can:view_user');

    Route::get('users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit')
        ->middleware('can:edit_user');

    Route::put('users/{user}', [UserController::class, 'update'])
        ->name('users.update')
        ->middleware('can:edit_user');

    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('can:delete_user');
});




// Routes for City
Route::middleware(['auth'])->group(function() {
    Route::get('cities', [CityController::class, 'index'])
        ->name('cities.index')
        ->middleware('can:view_city');

    Route::get('cities/create', [CityController::class, 'create'])
        ->name('cities.create')
        ->middleware('can:create_city');

    Route::post('cities', [CityController::class, 'store'])
        ->name('cities.store')
        ->middleware('can:create_city');

    Route::get('cities/{city}', [CityController::class, 'show'])
        ->name('cities.show')
        ->middleware('can:view_city');

    Route::get('cities/{city}/edit', [CityController::class, 'edit'])
        ->name('cities.edit')
        ->middleware('can:edit_city');

    Route::put('cities/{city}', [CityController::class, 'update'])
        ->name('cities.update')
        ->middleware('can:edit_city');

    Route::delete('cities/{city}', [CityController::class, 'destroy'])
        ->name('cities.destroy')
        ->middleware('can:delete_city');
});

// Routes for District
Route::middleware(['auth'])->group(function() {
    Route::get('districts', [DistrictController::class, 'index'])
        ->name('districts.index')
        ->middleware('can:view_district');

    Route::get('districts/create', [DistrictController::class, 'create'])
        ->name('districts.create')
        ->middleware('can:create_district');

    Route::post('districts', [DistrictController::class, 'store'])
        ->name('districts.store')
        ->middleware('can:create_district');

    Route::get('districts/{district}', [DistrictController::class, 'show'])
        ->name('districts.show')
        ->middleware('can:view_district');

    Route::get('districts/{district}/edit', [DistrictController::class, 'edit'])
        ->name('districts.edit')
        ->middleware('can:edit_district');

    Route::put('districts/{district}', [DistrictController::class, 'update'])
        ->name('districts.update')
        ->middleware('can:edit_district');

    Route::delete('districts/{district}', [DistrictController::class, 'destroy'])
        ->name('districts.destroy')
        ->middleware('can:delete_district');
});

// Routes for Branch
Route::middleware(['auth'])->group(function() {
    Route::get('branches', [BranchController::class, 'index'])
        ->name('branches.index')
        ->middleware('can:view_branch');

    Route::get('branches/create', [BranchController::class, 'create'])
        ->name('branches.create')
        ->middleware('can:create_branch');

    Route::post('branches', [BranchController::class, 'store'])
        ->name('branches.store')
        ->middleware('can:create_branch');

    Route::get('branches/{branch}', [BranchController::class, 'show'])
        ->name('branches.show')
        ->middleware('can:view_branch');

    Route::get('branches/{branch}/edit', [BranchController::class, 'edit'])
        ->name('branches.edit')
        ->middleware('can:edit_branch');

    Route::put('branches/{branch}', [BranchController::class, 'update'])
        ->name('branches.update')
        ->middleware('can:edit_branch');

    Route::delete('branches/{branch}', [BranchController::class, 'destroy'])
        ->name('branches.destroy')
        ->middleware('can:delete_branch');
});

// Routes for City
Route::middleware(['auth'])->group(function() {
    Route::get('cities', [CityController::class, 'index'])
        ->name('cities.index')
        ->middleware('can:view_city');

    Route::get('cities/create', [CityController::class, 'create'])
        ->name('cities.create')
        ->middleware('can:create_city');

    Route::post('cities', [CityController::class, 'store'])
        ->name('cities.store')
        ->middleware('can:create_city');

    Route::get('cities/{city}', [CityController::class, 'show'])
        ->name('cities.show')
        ->middleware('can:view_city');

    Route::get('cities/{city}/edit', [CityController::class, 'edit'])
        ->name('cities.edit')
        ->middleware('can:edit_city');

    Route::put('cities/{city}', [CityController::class, 'update'])
        ->name('cities.update')
        ->middleware('can:edit_city');

    Route::delete('cities/{city}', [CityController::class, 'destroy'])
        ->name('cities.destroy')
        ->middleware('can:delete_city');
});



// Routes for Lead
Route::middleware(['auth'])->group(function() {
    Route::get('leads', [LeadController::class, 'index'])
        ->name('leads.index')
        ->middleware('can:view_lead');

    Route::get('leads/create', [LeadController::class, 'create'])
        ->name('leads.create')
        ->middleware('can:create_lead');

    Route::post('leads', [LeadController::class, 'store'])
        ->name('leads.store')
        ->middleware('can:create_lead');

    Route::get('leads/{lead}', [LeadController::class, 'show'])
        ->name('leads.show')
        ->middleware('can:view_lead');

    Route::get('leads/{lead}/edit', [LeadController::class, 'edit'])
        ->name('leads.edit')
        ->middleware('can:edit_lead');

    Route::put('leads/{lead}', [LeadController::class, 'update'])
        ->name('leads.update')
        ->middleware('can:edit_lead');

    Route::delete('leads/{lead}', [LeadController::class, 'destroy'])
        ->name('leads.destroy')
        ->middleware('can:delete_lead');

    // Lead actions routes - following the same pattern
    Route::post('leads/{lead}/actions', [LeadController::class, 'storeAction'])
        ->name('leads.actions.store')
        ->middleware('can:edit_lead');

    Route::put('leads/{lead}/actions/{action}', [LeadController::class, 'updateAction'])
        ->name('leads.actions.update')
    ->middleware('can:edit_lead');

    Route::get('leads/{lead}/actions', [LeadController::class, 'getActions'])
        ->name('leads.actions.index')
        ->middleware('can:view_lead');

    Route::delete('leads/{lead}/actions/{action}', [LeadController::class, 'destroyAction'])
        ->name('leads.actions.destroy')
        ->middleware('can:edit_lead');


    // lead media routes
    Route::post('leads/{lead}/media', [LeadController::class, 'storeMedia'])
        ->name('leads.media.store')
        ->middleware('can:edit_lead');

    Route::get('leads/{lead}/download-media/{media}', [LeadController::class, 'downloadMedia'])
        ->name('leads.media.download')
        ->middleware('can:view_lead');

    Route::delete('leads/{lead}/media/{media}', [LeadController::class, 'destroyMedia'])
        ->name('leads.media.destroy')
        ->middleware('can:edit_lead');

    // import and export

    Route::get('leads/export/excel', [LeadController::class, 'export'])
        ->name('leads.export')
        ->middleware('can:export_lead');
    Route::get('leads/import/form', [LeadController::class, 'importForm'])
        ->name('leads.import.form')
        ->middleware('can:import_lead');
    Route::post('leads/import', [LeadController::class, 'import'])
        ->name('leads.import')
        ->middleware('can:import_lead');
    Route::get('leads/template/download', [LeadController::class, 'downloadTemplate'])->name('leads.template.download');
});


// Routes for Source
Route::middleware(['auth'])->group(function() {
    Route::get('sources', [SourceController::class, 'index'])
        ->name('sources.index')
        ->middleware('can:view_source');

    Route::get('sources/create', [SourceController::class, 'create'])
        ->name('sources.create')
        ->middleware('can:create_source');

    Route::post('sources', [SourceController::class, 'store'])
        ->name('sources.store')
        ->middleware('can:create_source');

    Route::get('sources/{source}', [SourceController::class, 'show'])
        ->name('sources.show')
        ->middleware('can:view_source');

    Route::get('sources/{source}/edit', [SourceController::class, 'edit'])
        ->name('sources.edit')
        ->middleware('can:edit_source');

    Route::put('sources/{source}', [SourceController::class, 'update'])
        ->name('sources.update')
        ->middleware('can:edit_source');

    Route::delete('sources/{source}', [SourceController::class, 'destroy'])
        ->name('sources.destroy')
        ->middleware('can:delete_source');
});

// Routes for Category
Route::middleware(['auth'])->group(function() {
    Route::get('categories', [CategoryController::class, 'index'])
        ->name('categories.index')
        ->middleware('can:view_category');

    Route::get('categories/create', [CategoryController::class, 'create'])
        ->name('categories.create')
        ->middleware('can:create_category');

    Route::post('categories', [CategoryController::class, 'store'])
        ->name('categories.store')
        ->middleware('can:create_category');

    Route::get('categories/{category}', [CategoryController::class, 'show'])
        ->name('categories.show')
        ->middleware('can:view_category');

    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit')
        ->middleware('can:edit_category');

    Route::put('categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update')
        ->middleware('can:edit_category');

    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy')
        ->middleware('can:delete_category');
});

// Routes for Product
Route::middleware(['auth'])->group(function() {
    Route::get('products', [ProductController::class, 'index'])
        ->name('products.index')
        ->middleware('can:view_product');

    Route::get('products/create', [ProductController::class, 'create'])
        ->name('products.create')
        ->middleware('can:create_product');

    Route::post('products', [ProductController::class, 'store'])
        ->name('products.store')
        ->middleware('can:create_product');

    Route::get('products/{product}', [ProductController::class, 'show'])
        ->name('products.show')
        ->middleware('can:view_product');

    Route::get('products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit')
        ->middleware('can:edit_product');

    Route::put('products/{product}', [ProductController::class, 'update'])
        ->name('products.update')
        ->middleware('can:edit_product');

    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy')
        ->middleware('can:delete_product');
});