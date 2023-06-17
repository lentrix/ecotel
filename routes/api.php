<?php

use App\Models\Addon;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/search-guest', function(Request $request) {
    $guests = Guest::orderBy('last_name')->orderBy('first_name');

    if($request->lname) {
        $guests->where('last_name','like',"%$request->lname%");
    }

    if($request->fname) {
        $guests->where('first_name','like',"%$request->fname%");
    }

    if($guests->count()==0) {
        return response()->json([
            'message'=>'Not found'
        ]);
    }else {
        return response()->json([
            'message'=>'ok',
            'guests' => $guests->get(['last_name','first_name','id'])
        ]);
    }

});

Route::post('/addon-items', function(Request $request) {
    $addons = Addon::orderBy('name');

    if($request->filter) {
        $addons->where('name','like',"%$request->filter%")
            ->orWhere('description','like',"$request->filter");
    }

    return response()->json([
        'message' => 'ok',
        'data' => $addons->get()
    ]);
});
