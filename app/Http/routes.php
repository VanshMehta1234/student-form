<?php
Route::get('/', function () {
   return view('welcome');
});

Route::get('/register',function(){
   return view('register');
});
Route::post('/user/register',array('uses'=>'UserRegistration@postRegister'));
