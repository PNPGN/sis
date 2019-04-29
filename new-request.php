<?php
if($level == "non-supervisor"){
    
    $result = $db_con->query("SELECT * FROM leaves WHERE for_staff_level = 'non-supervisor'");
    
}else{
        
    $result = $db_con->query("SELECT * FROM leaves WHERE for_staff_level = 'supervisor'");

}

if($result->num_rows > 0){
    
    include("leave-types.php");

    echo "<h1 class='text-center hide'>Jauns atvaļinājuma pieprasījums</h1>

        <form action='request.php' method='post' class='mb-5' id='request-form'>
            <input type='hidden' name='staff_id' value='$id'>

            <label for='leave-type'>Izvēlieties atvaļinājuma veidu</label>
            <select name='leave_id' class='form-control' required>";

    while($row = $result->fetch_object()){

        
        $num_days = $row->allowed_monthly_days;
        
        switch($row->leave_type){

       
       
        case "bērnu kopšanas": $type = "Bērnu kopšanas atvaļinājums";
        break;   
        case "ikgadējais": $type = "Ikgadējais atvaļinājums";
        break;
        case "studiju": $type = "Studiju atvaļinājums";
        break;
        case "bezalgas": $type = "Bezalgas atvaļinājums";
        break;
        case "papilddienu": $type = "Papilddien atvaļinājums";
        break;
        case "īslaicīga prombūtne": $type = "Īsa prombūtne";
        break;
        case "ilgstoša prombūtne": $type = "Ilgstoša prombūtne";
        break;
        default : "Unknown";
        break;
    
        }
            
            echo "<option class='leave_type' value='$row->leave_id'>$type</option>";
            
    }
       
        echo "</select><hr>";

        
}         

    $min = date("Y-m-d");
    
    echo "<label for='start'>Sākuma datums</label><br>
        <input type='date' name='leave_start_date' min='$min' id='start' class='form-control' required><hr>
        <label for='end'>Beigu datums</label><br>
        <input type='date' name='leave_end_date' id='end' min='$min' class='form-control' required><br>
        <small class='error' id='error'></small>
        <hr>
        <button class='btn btn-warning' type='submit' name='request'>
       Pieprasīt</button></form>";
