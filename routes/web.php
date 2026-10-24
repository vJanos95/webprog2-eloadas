
<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;

Route::get('/', function () {
    return redirect()->route('introduction');
})->name('home');

Route::get('/introduction', function () {
    return view('introduction');
})->name('introduction');

Route::get('/exercise1', function () {
    return view('view1');
});

// Bejelentkezés és regisztráció
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AdminController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AdminController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AdminController::class, 'register'])
        ->name('register.store');
});

// Csak bejelentkezett felhasználók
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', function () {
        return redirect()->route('user');
    })->name('dashboard');

    Route::get('/user', function () {
        return view('user');
    })->name('user');

    Route::get('/admin', [AdminController::class, 'adminPage'])
        ->middleware('role:1')
        ->name('admin');
        // Diákok listázása: admin és tanár
Route::get('/students', [StudentController::class, 'index'])
    ->name('students.index');

// Diákok kezelése: csak admin
Route::middleware('role:1')->group(function () {
    Route::get('/students/create', [StudentController::class, 'create'])
        ->name('students.create');

    Route::post('/students', [StudentController::class, 'store'])
        ->name('students.store');

    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])
        ->name('students.edit');

    Route::put('/students/{id}', [StudentController::class, 'update'])
        ->name('students.update');

    Route::delete('/students/{id}', [StudentController::class, 'destroy'])
        ->name('students.destroy');
});
// Tantárgyak listázása: admin és tanár
Route::get('/subjects', [SubjectController::class, 'index'])
    ->name('subjects.index');

// Tantárgyak módosítása: csak admin
Route::middleware('role:1')->group(function () {
    Route::get('/subjects/create', [SubjectController::class, 'create'])
        ->name('subjects.create');

    Route::post('/subjects', [SubjectController::class, 'store'])
        ->name('subjects.store');

    Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit'])
        ->name('subjects.edit');

    Route::put('/subjects/{id}', [SubjectController::class, 'update'])
        ->name('subjects.update');

    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])
        ->name('subjects.destroy');
});
Route::get('/grades', [GradeController::class, 'index'])
    ->name('grades.index');

Route::get('/grades/create', [GradeController::class, 'create'])
    ->name('grades.create');

Route::post('/grades', [GradeController::class, 'store'])
    ->name('grades.store');

Route::get('/grades/{id}/edit', [GradeController::class, 'edit'])
    ->name('grades.edit');

Route::put('/grades/{id}', [GradeController::class, 'update'])
    ->name('grades.update');

Route::delete('/grades/{id}', [GradeController::class, 'destroy'])
    ->name('grades.destroy');
});
