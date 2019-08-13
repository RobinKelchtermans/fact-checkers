<?php

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

Route::get('/', 'HomeController@index');

Auth::routes(['verify' => true]);

Route::view('/about', 'about.index')->name('about');

Route::resource('/survey/hexad', 'Survey\HexadSurveyController')->only([
    'index', 'store'
]);

Route::resource('/survey/media', 'Survey\MediaSurveyController')->only([
    'index', 'store'
]);

Route::resource('/survey/sus', 'Survey\SUSSurveyController')->only([
    'index', 'store'
]);

Route::resource('/survey/end', 'Survey\EndSurveyController')->only([
    'index', 'store'
]);

Route::resource('comment', 'CommentController')->only([
    'store', 'destroy'
]);

Route::resource('vote', 'VoteController')->only([
    'store'
]);

Route::resource('/profile', 'ProfileController');
Route::post('/profile/toggleComments', 'ProfileController@toggleComments');
Route::post('/profile/updatePassword', 'ProfileController@updatePassword');
Route::post('/profile/addCanBeContacted', 'ProfileController@addCanBeContacted');
Route::post('/profile/updateAvatar', 'ProfileController@updateAvatar');
Route::post('/profile/giveFeedback', 'ProfileController@giveFeedback');


Route::get('/category/{id}', 'ArticleController@index');
Route::resource('/article', 'ArticleController', ['except' => ['index']]);

Route::get('/users/{id}', 'UserController@show');


Route::get('/verifyInfo', function() {
    return view('info.verify');
});
Route::get('/tutorialInfo', function() {
    return view('info.tutorial');
});
Route::get('/endInfo', function() {
    return view('info.end');
});

Route::get('/settings', function() {
    return view('profile.settings');
});

Route::get('/bug', function() {
    return view('bug');
});

Route::get('/questionnaires', function() {
    return view('surveys.questionnaires');
});


Route::get('/feedLoader', 'FeedLoaderController@index');

Route::post('/saveFilters', 'FilterController@store');
Route::post('/saveScore', 'ScoreController@store');


Route::any('/search', 'SearchController@index');

Route::get('/load/{source}', function($source) {
    if (auth()->guest()) {
        return view('index');
    }

    if (auth()->user()->is_admin == 0) {
        return view('index');
    }
    $exitCode = Artisan::call('feed:load', [
        'source' => $source,
    ]);
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');