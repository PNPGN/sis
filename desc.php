<?php
 
$stmt = $db_con->query("SELECT * FROM employee");

$rows = $stmt->num_rows;

if($rows > 0){

        echo "<h3 class='text-center'>Darbavietas apraksts</h3>
    
        <form action='process.php' method='post'>
        <label for='salary'>Izvēlieties darbinieku</label>
        <select name='staff_id' id='select-user'>";
        
    while($row = $stmt->fetch_object()){
             
         echo "<option value='$row->staff_id'>$row->fname $row->lname</option>";
         
    }
        $da = date('Y-m-d');
        
        echo "</select><hr>
            <label for='salary'>Alga</label>
            <input type='number' min='700' name='salary_level' class='form-control mb-2' id='salary'><hr>
            
            <label for='date'>Pievienošanās datums</label>
            <input type='date' max='$da' name='date_joined' class='form-control mb-2' id='date'><hr>

            <hr><button name='publish' class='btn btn-primary'>Publicēt</button><br>
            </form>";
        
}