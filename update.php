<?php
require_once('db.php');

require_once('functions.php');

if(isset($_POST['update'])){

    $err = array();
    
    if(var_set($_POST['password'])){

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
    }else{
        $err[] = urlencode("Ievadi paroli");
    }
    
    if(var_set($_POST['confpassword'])){

        $confpass = password_hash($_POST['confpassword'], PASSWORD_DEFAULT);
    }else{
        $err[] = urlencode("Apstiprini paroli");
    }
    
    if(var_set($_POST['phone'])){

        $phone = strip_tags($_POST['phone']);
    }else{
        $err[] = urlencode("Ievadi tel. nr.");
    }
    
    $id = var_set($_POST['id']) ? intval($id) : "";
      
    if(var_set($_POST['email'])){
        
        $email = strip_tags($_POST['email']);
    }else{
        $err[] = urlencode("Ievadi e-pastu");
    }
    
    if(!$err){
        if($confpass == $password){

            $query = $db_con->query("UPDATE employee SET email = '$email', phone = $phone, password = '$password' WHERE id = $id");

            $affected = $db_con->affected_rows;

            if($affected == 1){

                $msg = urlencode("Tava dati ir atjaunoti");

                header('Location:dashboard.php?tab=4&msg='.$msg);

            }else{

                $error = urlencode("Your request could not be processed. Try again".$db_con->error);

                header('Location:dashboard.php?tab=4&error='.$error);
            }

        } else{

            $error = urlencode("Paroles nesakrīt");

            header('Location:dashboard.php?tab=4&error='.$error);
        }
        
    }else{
        header("Location:admin.php?tab=4&error=".join($err, urlencode("<br")));
    }
}else{
    header("Location:dashboard.php?tab=4");
}