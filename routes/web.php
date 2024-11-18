<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(\App\Models\Transaction::all()[0]->category()->name);
});
