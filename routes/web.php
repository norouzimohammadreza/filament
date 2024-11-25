<?php

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Models\Activity;

Route::get('/test-log', function () {
    auth()->user()->actions();
    $activity = Activity::all()->last();
    dd($activity);
});
Route::get('/', function () {
    return view('welcome');
});

//test-batch
Route::get('/test-batch', function () {
    LogBatch::startBatch();
    $category = Category::create([
        'name' => 'مغازه',
    ]);
    $transaction = Transaction::create([
        'amount' => 10000,
        'description' => 'hellloooooo',
        'category_id' => $category->id,
    ]);
    $transaction->update(['description' => 'test']);
    $category->delete();
    LogBatch::endBatch();

});
