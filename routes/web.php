<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\XeroController;
use App\Http\Controllers\NewRuleController;
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
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/rules', function () {
    return view('rules');
})->name('rules');

//Temporary Routes to test the new rule modal feature
Route::get('newRuleModal', function() {
    return view('livewire/managers/rules/new-rule-modal');
});

Route::post('addNewRule',[NewRuleController:: class, 'insertRule'] );

