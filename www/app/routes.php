<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
//     $vocabs = Vocab::all();
//     return View::make('vocabs')->with('vocabs', $vocabs);
// });

Route::get('/', 'TrainerController@index');

Route::get('trainer', 'TrainerController@index');
Route::get('trainer/reset', 'TrainerController@reset');
Route::get('trainer/next', 'TrainerController@next');
Route::post('trainer', 'TrainerController@check');

Route::resource('vocabs', 'VocabsController');