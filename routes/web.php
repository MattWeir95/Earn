<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\XeroController;
use App\Http\Controllers\ParsingController;
use App\Classes\InvoiceGenerator;
use App\Models\User;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\TargetController;

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


Route::get('/login/xero', function(Request $request) {
    $instance = new XeroController;
    $instance->handleCallbackFromXero($request);
    return redirect('/dashboard');
});

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/rules', function () {
    return view('rules');
})->name('rules');


//Post for adding a new rule
Route::post('addNewRule',[RuleController:: class, 'insertRule'] )->name('newRule');

//Post for editing/deleteing a rule
Route::post('editRule',[RuleController:: class, 'editForm'] )->name('editForm');




