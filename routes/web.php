<?php

use App\ActivityLogsFunctions\Class\MyActivityLogStatus;
use App\Http\Controllers\TestController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Models\Activity;

Route::get('/ttt',function (){
$user = auth()->user();

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
   //Schedule::command('backup:run --only-db')->everySecond();

    phpinfo();
    return view('welcome');
});
Route::get('/ena',function (){
    $logStatus = app(MyActivityLogStatus::class);
    dd($logStatus);
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

Route::get('/models',[TestController::class,'index']);
Route::get('/cc',[TestController::class,'getClass']);
Route::get('/x',[TestController::class,'x']);
Route::get('/db-backup',[TestController::class,'dbBackup']);
Route::get('/db-job',[TestController::class,'dbJob']);
