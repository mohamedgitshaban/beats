<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/locale/{locale}', function (Request $request, string $locale) {
    $supportedLocales = ['en', 'ar'];

    if (! in_array($locale, $supportedLocales, true)) {
        $locale = config('app.fallback_locale');
    }

    $request->session()->put('locale', $locale);

    return redirect()->back();
})->name('locale.switch');
