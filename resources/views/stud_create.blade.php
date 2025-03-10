<html>
<head>
      <title>Student Management | Add</title>
   </head>

   <body>

      <form action = "/create" method = "post">
         @csrf

	 <h3 style = "color:#890207;"> Student information form</h4>
         <table>
            <tr>
               <td>Enter your Name :</td>
               <td><input type='text' name='name' /></td>
            </tr>
        	<tr>
		<td>Enter Username :</td>
		<td> <input type = 'text' id = "username" name ="username"></td>
		</tr>
		<tr>
		<td>Enter register number:</td>
		<td><input type ="text" id = "regno" name = "regno"> </td>
		</tr>
		<tr>
		<td> Your age : </td>
		<td> <input type = 'text' id = "age name = "age"></td>    
	<tr>
               <td colspan = '2'>
                  <input type = 'submit' value = "Add student"/>
               </td>
            </tr>
         </table>
      </form>
      
   </body>
</html>
