<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\XeroController;
use App\Http\Controllers\ParsingController;
use App\Classes\InvoiceGenerator;
use App\Models\User;
use App\Http\Controllers\RuleController;


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

Route::get('/parse', function(Request $req) {
    /*
    Parses and saves a random invoice
    */
    if (count(User::all()) == 0) {
        User::factory()->withPersonalTeam()->create();
    }
    $generator = new InvoiceGenerator;
    [$item, $invoice] = $generator->getPair();
    $result = ParsingController::parseLineItem($item);
    ParsingController::saveInvoice($result);
    return;
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/rules', function () {
    return view('rules');
})->name('rules');


//Post for adding a new rule
Route::post('addNewRule',[RuleController:: class, 'insertRule'] )->name('newRule');


