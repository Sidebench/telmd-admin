<?php

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() {
    Route::get('/', function() {
        return redirect(env('ADMIN_PATH', 'admin') . '/dashboard');
    });
    
    Route::get('/dashboard', \WFN\Admin\Http\Controllers\DashboardController::class . '@index')->name('admin.dashboard');

    Route::get('/login', \WFN\Admin\Http\Controllers\Auth\LoginController::class . '@showLoginForm')->name('admin.login');
    Route::post('/login', \WFN\Admin\Http\Controllers\Auth\LoginController::class . '@login')->name('admin.login.post');
    Route::post('logout', \WFN\Admin\Http\Controllers\Auth\LoginController::class . '@logout')->name('admin.logout');
    Route::get('logout', function () {
        return redirect(env('ADMIN_PATH', 'admin') . '/dashboard');
    });

    Route::get('password/reset', \WFN\Admin\Http\Controllers\Auth\ForgotPasswordController::class . '@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', \WFN\Admin\Http\Controllers\Auth\ForgotPasswordController::class . '@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', \WFN\Admin\Http\Controllers\Auth\ResetPasswordController::class . '@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', \WFN\Admin\Http\Controllers\Auth\ResetPasswordController::class . '@reset')->name('admin.password.reset.post');

    Route::get('/settings', \WFN\Admin\Http\Controllers\SettingsController::class . '@index')->name('admin.settings');
    Route::post('/settings', \WFN\Admin\Http\Controllers\SettingsController::class . '@save')->name('admin.settings.save');

    Route::prefix('user')->group(function() {
        Route::get('/', \WFN\Admin\Http\Controllers\UserController::class . '@index')->name('admin.user');
        Route::get('/edit/{id}', \WFN\Admin\Http\Controllers\UserController::class . '@edit')->name('admin.user.edit');
        Route::get('/new', \WFN\Admin\Http\Controllers\UserController::class . '@new')->name('admin.user.new');
        Route::post('/save', \WFN\Admin\Http\Controllers\UserController::class . '@save')->name('admin.user.save');
        Route::get('/delete/{id}', \WFN\Admin\Http\Controllers\UserController::class . '@delete')->name('admin.user.delete');

        Route::prefix('role')->group(function() {
            Route::get('/', \WFN\Admin\Http\Controllers\User\RoleController::class . '@index')->name('admin.user.role');
            Route::get('/edit/{id}', \WFN\Admin\Http\Controllers\User\RoleController::class . '@edit')->name('admin.user.role.edit');
            Route::get('/new', \WFN\Admin\Http\Controllers\User\RoleController::class . '@new')->name('admin.user.role.new');
            Route::post('/save', \WFN\Admin\Http\Controllers\User\RoleController::class . '@save')->name('admin.user.role.save');
            Route::get('/delete/{id}', \WFN\Admin\Http\Controllers\User\RoleController::class . '@delete')->name('admin.user.role.delete');
        });
    });
});

Route::get('robots.txt', function() {
    return response(\Settings::getConfigValue('app/robots') ?: '')->header('Content-Type', 'text/plain');
});