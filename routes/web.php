<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


// Authentication Routes...
$this->get('/', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('/login', 'Auth\LoginController@login');
$this->post('/logout', 'Auth\LoginController@logout')->name('logout');

// Registration routes...
$this->get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('/register', 'Auth\RegisterController@register');

// Users

Route::get('users', 'UserController@index');
Route::get('users/new', 'UserController@addNew');
Route::get('users/update/{user}', 'UserController@getAccount');
Route::post('users/update/{user}', 'UserController@updateAccount');
Route::get('users/delete/{user}', 'UserController@destroyAccount');

// Groups

Route::get('settings/groups', 'GroupController@index');
Route::post('settings/groups', 'GroupController@storeGroup');
Route::post('settings/groups/{group}', 'GroupController@updateGroup');
Route::get('settings/addgroup', 'GroupController@addGroup');
Route::get('settings/editgroup/{group}', 'GroupController@editGroup');
Route::delete('settings/groups/{group}', 'GroupController@destroyGroup');

// Views

Route::get('users/myclients/{id?}', 'UserController@myClients');
Route::get('users/mycalendar', 'UserController@myCalendar');
Route::get('goaltracker', 'DataController@goalTracker');

// Settings

Route::get('settings', 'DataController@settings');

// Nutrition

Route::get('settings/nutritions', 'DataController@getNutritions');
Route::post('settings/nutritions', 'DataController@storeNutrition');
Route::get('settings/addnutrition', 'DataController@addNutritions');
Route::delete('settings/nutritions/{task}', 'DataController@destroyNutrition');
Route::post('settings/nutritions/search', 'DataController@searchNutrition');
Route::get('settings/nutritions/star/{id}/{val}', 'DataController@favNutrition');

// Exercise

Route::get('settings/exercises', 'DataController@getExercises');
Route::post('settings/exercises', 'DataController@storeExercise');
Route::get('settings/addexercise', 'DataController@addExercise');
Route::delete('settings/exercises/{exercise}', 'DataController@destroyExercise');
Route::post('settings/exercises/search', 'DataController@searchExercise');
Route::get('settings/exercises/star/{id}/{val}', 'DataController@favExercise');

// Meals

Route::get('settings/meals', 'DataController@getMeals');
Route::post('settings/meals', 'DataController@storeMeal');
Route::get('settings/addmeal', 'DataController@addMeal');
Route::get('settings/editmeal/{meal}', 'DataController@editMeal');
Route::post('settings/editmeal/{meal}', 'DataController@updateMeal');
Route::delete('settings/meals/{meal}', 'DataController@destroyMeal');

// Nutrition Program Templates

Route::get('settings/nutritiontemplates', 'DataController@getNutritionProgramTemplates');
Route::post('settings/nutritiontemplates', 'DataController@storeNutritionProgramTemplate');
Route::get('settings/addnutritiontemplate', 'DataController@addNutritionProgramTemplate');
Route::get('settings/editnutritiontemplate/{template}', 'DataController@editNutritionProgramTemplate');
Route::post('settings/editnutritiontemplate/{template}', 'DataController@updateNutritionProgramTemplate');
Route::delete('settings/nutritiontemplates/{template}', 'DataController@destroyNutritionProgramTemplate');

// Exercise Program Templates

Route::get('settings/exercisetemplates', 'DataController@getExerciseProgramTemplates');
Route::post('settings/exercisetemplates', 'DataController@storeExerciseProgramTemplate');
Route::get('settings/addexercisetemplate', 'DataController@addExerciseProgramTemplate');
Route::get('settings/editexercisetemplate/{template}', 'DataController@editExerciseProgramTemplate');
Route::post('settings/editexercisetemplate/{template}', 'DataController@updateExerciseProgramTemplate');
Route::delete('settings/exercisetemplates/{template}', 'DataController@destroyExerciseProgramTemplate');

// Circuts

Route::get('settings/circuits', 'DataController@getCircuits');
Route::post('settings/circuits', 'DataController@storeCircuit');
Route::get('settings/addcircuit', 'DataController@addCircuit');
Route::get('settings/editcircuit/{circuit}', 'DataController@editCircuit');
Route::post('settings/editcircuit/{circuit}', 'DataController@updateCircuit');
Route::delete('settings/circuits/{circuit}', 'DataController@destroyCircuit');

// TrainingSessions

Route::get('/user/{client}/sessions', 'TrainingSessionController@getTrainingSession');
Route::post('/user/{client}/sessions', 'TrainingSessionController@storeTrainingSession');
Route::get('/user/{client}/newsession', 'TrainingSessionController@newTrainingSession');
Route::get('/user/{client}/editsession/{session}', 'TrainingSessionController@editTrainingSession');
Route::post('/user/{client}/updateSession', 'TrainingSessionController@updateTrainingSession');
Route::delete('/user/{client}/destroysession/{session}', 'TrainingSessionController@destroyTrainingSession');

// Nutrition Programs

Route::get('/user/{client}/nutritionprogram/shoppinglist/{session?}', 'NutritionProgramController@getShoppingList');
Route::get('/user/{client}/nutritionprogram/pdf/{session?}', 'NutritionProgramController@getNutritionPDF');
Route::get('/user/{client}/nutritionprogram/{session?}', 'NutritionProgramController@getNutritionProgram');
Route::get('/user/{client}/newnutritionprogram/{session?}', 'NutritionProgramController@newNutritionProgram');
Route::post('/user/{client}/nutritionprogram/{session?}', 'NutritionProgramController@storeNutritionProgram');
Route::get('/user/{client}/editnutritionprogram/{session?}', 'NutritionProgramController@editNutritionProgram');
Route::post('/user/{client}/editnutritionprogram/{session?}', 'NutritionProgramController@updateNutritionProgram');
Route::get('/user/{client}/copynutritionprogram/{session?}/{pastSession?}', 'NutritionProgramController@copyNutritionProgram');

// Exercise Programs

Route::get('/user/{client}/exerciseprogram/pdf/{session?}', 'ExerciseProgramController@getExercisePDF');
Route::get('/user/{client}/exerciseprogram/{session?}', 'ExerciseProgramController@getExerciseProgram');
Route::get('/user/{client}/newexerciseprogram/{session?}', 'ExerciseProgramController@newExerciseProgram');
Route::post('/user/{client}/exerciseprogram/{session?}', 'ExerciseProgramController@storeExerciseProgram');
Route::get('/user/{client}/editexerciseprogram/{session?}', 'ExerciseProgramController@editExerciseProgram');
Route::post('/user/{client}/editexerciseprogram/{session?}', 'ExerciseProgramController@updateExerciseProgram');
Route::get('/user/{client}/copyexerciseprogram/{session?}/{pastSession?}', 'ExerciseProgramController@copyExerciseProgram');

// Email Notification

Route::get('/user/{client}/sendresults/{session?}', 'TrainingSessionController@SessionResults');
Route::post('/user/{client}/sendresults/{session?}', 'TrainingSessionController@sendSessionResults');


// Dashboard

Route::get('/user/{client}/pages/freefoods', 'DataController@freeFoods');
Route::get('/user/{client}/pages/restaurantfood', 'DataController@restaurantFood');

Route::get('/user/{client}/dashboard', 'DataController@index');
Route::get('/user/{client}/dashboard/pdf', 'DataController@makePDF');
Route::get('/user/{client}/dashboard/pdftest', 'DataController@testPDF');

Route::get('/user/{client}/welcome', 'DataController@clientIndex');

$this->post('/', 'Auth\LoginController@login');
