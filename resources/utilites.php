<?php

/**
*@param required_field_array,an array containing n required fields
*@return array , containing all errors
*/

function check_empty_fields($required_field_array){
    //initialize an array to store any error message from the form
    $form_errors = array();
    
     //loop through the required fields array
    foreach($required_field_array as $name_of_field){
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field]==NULL){
            $form_errors[] = $name_of_field." is a required field.";
        }
    }
    return $form_errors;
}

/**
*@param fields_to_check is an array containing the name of fields
*which is used to check the length of the fields
*like username->4,email->12,password->8
*@return array containing all errors
*/

function check_min_length($fields_to_check_length)
{
    //initilize an array for errors
    $form_errors = array();
    
    foreach($fields_to_check_length as $name_of_field => $minimum_of_length_required){
        if(strlen(trim($_POST[$name_of_field])) < $minimum_of_length_required){
            $form_errors[]=$name_of_field." is too short,must be ".$minimum_of_length_required." characters long";
        }
    }
    
    return $form_errors;
}

/**
*@param $data, store a key/data pair array where key is the name of the form control(field)
*in this case 'email' , and the value entered by user
*@return array contain all errors
*/

function check_email($data)
{
     //initilize an array for errors
    $form_errors = array();
    
    $key = 'email';
    
    //check if key email is exist with the data array
    
    if(array_key_exists($key,$data)){
        
        //check if the email has a value
        if($_POST[$key]!=null){
            
            //remove all illegal character in the email
            $key = filter_var($key,FILTER_SANITIZE_EMAIL);
            
            //check if input is valid email
            if(filter_var($_POST[$key],FILTER_VALIDATE_EMAIL)===false){
                $form_errors[] = $key." is not a valid email";
            }
        }
    }
   return $form_errors; 
}

/**
*@param @form_errors_array which contain
*all error we want to loop through
*@return a string list containing all errors
*/

function show_errors($form_errors_array)
{
    $errors = "<p><ul style='color:red;'>";
    //loop through error array and display all items in a list
    foreach($form_errors_array as $the_error){
        $errors.="<li> {$the_error} </li>";
    }
    $errors.="</ul></p>";
    return $errors;
    
}
?>