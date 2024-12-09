<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Models\Activity;

Route::get('/ttt',function (){
$user = auth()->user();

dd($user->checkValue());
});
Route::get('/class',function (){
    $user = auth()->user();

    dd(($user->id));
});
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

//causer-log
Route::get('/causer-log', function () {
    $post = Post::find(1);
    $causer = $post->user;
    CauserResolver::setCauser($causer);
    $post->update(['title' => 'شرق بهشت']);
    echo Activity::all()->last()->causer; // Post Model
    echo Activity::all()->last()->causer->id; // Post#1 Owner
});
