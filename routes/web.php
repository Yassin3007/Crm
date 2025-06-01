<?php

use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\DistrictController;
use App\Http\Controllers\Dashboard\BranchController;


Route::get('/dashboard2', function () {

    return view('dashboard.temp.index');
})->name('dashboard');



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



// Profile routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/statistics', function () {

        return view('dashboard.temp.index');
    })->name('dashboard');
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