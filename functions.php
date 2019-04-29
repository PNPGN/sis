<?php
include_once("connection.php");

    
function is_user_registered($tbl,$user) {

    global $db_con;

    $result = $db_con->query("SELECT * FROM '$tbl' WHERE username = '$user'");

    if($result->num_rows == 0){

        return FALSE;
    }
    return TRUE;   
}


function in_db($table, $column, $itemn) {
    
    global $db_con;
    
    $name = strval($column);
    
    $res = $db_con->query("SELECT * FROM $table WHERE $name = $item");
    
    if($res->num_rows == 1){
        
        return TRUE;
    }
    return FALSE;
}


function rows_affected($handle) {
    
    global $handle;
    
    if($handle->affected_rows > 0){
        return 1;
    }
    
    return 0;
}





function redirect_user($page){
    
    if(isset($page)){
        
        header("Location:$page");
    }
    
}

function show_alert(){
    
     if(isset($_GET['error']) && $_GET['error'] !== ''){

        echo "<div class='alert alert-danger alert-dismissible'>"
        .strval($_GET['error'])."<span class='close' data-dismiss='alert'>&times;
            </span></div>";
        }

    if(isset($_GET['msg']) && $_GET['msg'] !== ''){

         echo "<div class='alert alert-success alert-dismissible'>"
        .$_GET['msg']."<span class='close' data-dismiss='alert'>"
                 . "&times;</span></div>";
    }
}

function query_db($str) {  
        
    global $db_con;
        
    $res = $db_con->query($str);
        
    if($res->num_rows < 1 || $db_con->affected_rows == 0){
            
        return FALSE;
    }
        
    $rows = $res->fetch_object();
        
    return $rows;
 }
    

 
function select_with_prepare_stmt($tbl,$id=NULL,$col_identifier=NULL,$col=NULL){
    global $db_con;
    $str = "SELECT * FROM $tbl";
     
     if($id !== ""){
         
         $str .= " WHERE id = ?";
     }
     
     if($col !== "" && $col_identifier !== ""){
         $str .= " AND $col_identifier = ?";
     }
     
     $stmt = $db_con->prepare($str);
     
     $stmt->bind_param("is", $id,$col);
     
     $stmt->execute();
     
     $result = $stmt->get_result();
     
     if($result->num_rows > 0){
         
         $rows = $result->fetch_object();
         return $rows;
     }
     
     return FALSE;
 }
 

function verify_user($user, $password, $tbl) {
        
    $query = "SELECT $password FROM $tbl WHERE username = $user";
        
    if(query_db($query)){
            
        if(!password_verify($rows->password, PASSWORD_DEFAULT)){
                
            return FALSE;
        }
    }
        
    return TRUE;
}


function auto_update_leave_curr_date(){
    
    global $db_con;
    
    $date_now = date("U");
                    
    $query = $db_con->query("SELECT * FROM leaves");
    
    if($query->num_rows > 0){
        
        while($row = $query->fetch_object()){
            
            $difference = intval($date_now) - $row->auto_update;
            
            $reduced = $row->current_days - $row->allowed_monthly_days;
            
            if($difference == 0){
                
                $db_con->query("UPDATE leaves SET current_days = $reduced WHERE id = $row->id");
                                
            }
        }
    }  
}


function var_set($var) {
    
    if((isset($var) && $var !== "")){
        
        return TRUE;
    }
    
    return FALSE;
}

function determine_user_set_session($user_type,$rows) {
    
    session_start();
            
    if($user_type == "admin"){

        $_SESSION['admin-user'] = $rows->username;

        $_SESSION['admin-id'] = $rows->id;

    }elseif ($user_type == "employee") {

        $_SESSION['staff-user'] = $rows->username;

        $_SESSION['staff-email'] = $rows->email;

        $_SESSION['staff-id'] = $rows->staff_id;

    }else{

        $_SESSION['supervisor-user'] = $rows->username;

        $_SESSION['supervisor-id'] = $rows->supervisor_id;
        
        $_SESSION['supervisor-email'] = $rows->email;
    }
                
}


function verify_redirrect_user($user, $password, $tbl, $page) {
        
    $query = "SELECT * FROM $tbl WHERE username = $user";
        
    if(query_db($query)){
            
        if(password_verify($rows->password, PASSWORD_DEFAULT)){
            
            //Verified. Start and set sessions
            determine_user_set_session($tbl);
            
            redirect_user("Location:$page");
        }else{
            $errors[] = urlencode("Password incorrect");
        }
    }
        
    return FALSE;
}


 
function is_empty($field){
    
    if($field == '' || empty($field)){
        return TRUE;
    }
    
    return FALSE;
}



function load_styles(){
    include("styles.php");
}


function load_scripts(){
    include("scripts.php");
}


function session_redirect() {
    
    if(isset($_SESSION['staff-user'])){

            redirect_user("Location:dashboard.php");
            
    }elseif(isset($_SESSION['supervisor-user'])){

            redirect_user("Location:dashboard.php?type=supervisor");
            
    }elseif(isset($_SESSION['admin-user'])){

            redirect_user("Location:admin.php");
            
    }  else {
        
        redirect_user("index.php");
    }
        
}


function is_session_inplace($session_var) {
    
    if(!isset($_SESSION[$session_var])){

        return FALSE;
    }
    
    return TRUE;
}


function mail_user($user_email,$subject,$msg,$headers = NULL){
    
    $add_h = var_set($headers) ? $headers : "";
    
    if(mail($user_email,$subject,$msg,$add_h)){
        return TRUE;
    }else{
        return FALSE;
    }
    
}