<?php
include_once('resources/Database.php');
include_once('resources/utilites.php');


//process the form

if(isset($_POST['signupBtn'])){
    
    //array of errors
    $form_errors = array();

    //Form validation
    $required_fields = array('email','username','password');
    
     
    //call the function to check for empty fields and merege data with form_errors array
    $form_errors = array_merge($form_errors,check_empty_fields($required_fields));
    
    //fields that required for minimum length check
    $field_to_check_length = array('username'=>4,'password'=>8);
    
    //call the function to check for minimum required length and merege data with form_errors array
    $form_errors = array_merge($form_errors,check_min_length($field_to_check_length));
    
    //email validation/merege data with form_errors array
    $form_errors = array_merge($form_errors,check_email($_POST));
    
    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)){
        //collect form data and store in variables
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        //hashing the password
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
    try{
        
        $sqlInsert = "INSERT INTO users (username,email,password,join_date)
                 VALUES (:username,:email,:password,now())";
    
        $statement = $db->prepare($sqlInsert);
    
        $statement->execute(array(':username'=>$username,':email'=>$email,'password'=>$hashed_password));

        if($statement->rowCount()==1){
         
         $result = "<p style = 'padding:20px;color:green;'>registration seccessful</p>";
        }
    }catch(PDOException $ex){
    
        
         $result = "<p style = 'padding:20px;color:red;'>registration faild".$ex->getMessage()."</p>";

    }
 }else{
      if(count($form_errors)==1)
      {
          $result = "<p style=' color: red;'>There was an error in the form</p>";
      }else{
          $result = "<p style='color: red;'>There were ".count($form_errors)." error in the form</p>";
      }
 }
}
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="utf-8">
        <title>Registration Page</title>
    </head>
    <body>
        <h2>User Authentication System</h2><hr>
        
        <h3>Registration Form</h3>
        
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        <form method="post" action="">
             <table>
                <tr><td>Email:</td><td><input type="text" value="" name="email"></td></tr>
                <tr><td>Username:</td><td><input type="text" value="" name="username"></td></tr>
                <tr><td>Password:</td><td><input type="password" value="" name="password"></td></tr>
                <tr><td></td><td><input style="float:right;" type="submit" name="signupBtn" value="SignUP"></td></tr>
             </table>
        </form>
        <p><a href="index.php">Back</a></p>
    </body>
</html>