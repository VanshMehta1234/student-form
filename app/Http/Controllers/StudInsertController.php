<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StudInsertController extends Controller {
   public function insertform(){
      return view('stud_create');
   }
	
   public function insert(Request $request){
      $name = $request->input('name');
      $username = $request->input('username');
      $age = $request->input('age');
      $regno = $request->input('regno');
      
//Inserting data into table
      DB::insert('insert into student (name) values(?)',[$name]);
      DB::insert('insert into student (username) values(?)',[$username]);
      DB::insert('insert into student (age) values(?)', [$age]);
      DB::insert('insert into student (regno) values(?)',[$regno]);

      echo "Record inserted successfully.<br/>";
      echo '<a href = "/insert">Click Here</a> to go back.';

//Selecting datas from dable
      $users = DB::select('select name from student');
      $username = DB::select('select username from student');
      $regno = DB::select('select regno from student');
      $age = DB::select('select age from student');
        
	echo "<h4> Users list:</h4>";
	foreach ($users as $user) {
		echo $user->name;
		echo "<br>";
}
	echo "<h4> Usernames: </h4>";
	foreach ($username as $user) {
		echo $user->username;
		echo "<br>";
		}

	echo "<h4>Register Number : </h4>";
	foreach($regno as $user) {
		echo $user->regno. "<br>";
	}

	echo "<h4> Age: </h4>";
	foreach($age as $user) {
		echo "<br/>" .$user->age;
}
}
}
