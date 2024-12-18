<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/products-and-services', function () {
    return view('products-and-services');
});

Route::get('/jobs', function () {
    return view('jobs');
});

Route::get('/about-plr-zambia', function () {
    return view('about-plr-zambia');
});

// User Routes
// Route::get('/register', [UserController::class, 'create'])->name('users.create');
// Route::post('/register', [UserController::class, 'store'])->name('users.store');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('users.login');
Route::post('/login', [UserController::class, 'login'])->name('login');;
Route::get('/logout', [UserController::class, 'logout'])->name('users.logout');

//test routes
Route::get('/test-pdf', function () {
    $data = ['message' => 'Hello, DomPDF!'];
    $pdf = Pdf::loadView('pdf.test', $data);
    return $pdf->stream('test.pdf');
});

// Application Routes
Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications/tracking', [ApplicationController::class, 'getApplicationTrackingForm'])->name('applications.track');
Route::post('/applications/tracking', [ApplicationController::class, 'trackApplication'])->name('applications.track-post');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.admin');
    })->name('dashboards.admin');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::get('/payslips/upload', [PayslipController::class, 'showUploadForm'])->name('payslips.uploadForm');
    Route::post('/payslips/upload', [PayslipController::class, 'upload'])->name('payslips.upload');
    Route::get('/payslips/generate', [PayslipController::class, 'generate'])->name('payslips.generate');


    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('/employees/{employee}/payslip', [EmployeeController::class, 'generatePayslip'])->name('employees.generatePayslip');
    Route::get('/employees/generate-payslips', [EmployeeController::class, 'generatePayslips'])->name('employees.generatePayslips');
});

Route::post('/applications/{application}/certificates', [ApplicationController::class, 'uploadCertificates'])->name('applications.uploadCertificates');

// Name ID Position Team Basic HRA Conveyance Medical Other PF Loan OtherDeductions PaymentMode BankDetails
