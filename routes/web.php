<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\XeroController;
use App\Http\Controllers\NewRuleController;
use App\Http\Controllers\ViewRuleController;


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

//Rule screen route to test components
Route::get('ruleScreen', function() {
    return view('livewire/managers/rules/ruleScreen');
});

//Post for adding a new rule
Route::post('addNewRule',[NewRuleController:: class, 'insertRule'] )->name('newRule');


