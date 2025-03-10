<html>
<head>
      <title>Form Example</title>
   </head>

   <body>
      <form action = "/user/register" method = "post">
         @csrf
      
         <table>
            <tr>
               <td>Name</td>
               <td><input type = "text" name = "name" /></td>
            </tr>
            <tr>
               <td>Username</td>
               <td><input type = "text" name = "username" /></td>
            </tr>
            <tr>
               <td>Password</td>
               <td><input type = "password" name = "password" /></td>
            </tr>
	    <tr>
		<td> Confirm password: </td>
		<td><input type = "password" name = "password1" /> </td>
	    </tr>
            <tr>
               <td colspan = "2" align = "center">
                  <input type = "submit"  value = "Register" />
               </td>
            </tr>
         </table>
      
      </form>
   </body>
</html>
