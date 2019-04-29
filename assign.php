<?php

$result = $db_con->query("SELECT * FROM employee WHERE supervisor IS NULL OR supervisor = ''");

if($result->num_rows > 0){
    
    $res = $db_con->query("SELECT * FROM employee WHERE staff_level = 'supervisor'");

    if($res->num_rows > 0){

        echo "<h1 class='text-center hide'>Apstiprināt vadītāju</h1>

            <form action='process.php' method='post' class='mb-5'>

                <label for='users'>Izvēlieties darbinieku</label>
                <select name='assign-to' class='form-control w-50' id='users' required>";
        while($row = $result->fetch_object()){
            
            echo "<option value='$row->username'>$row->fname $row->lname</option>";
        }
             
            
        echo "</select><hr>
        
        <label for='supervisors'>Izvēlieties vadītāju, kuram pievienot izvēlēto darbinieku</label><br>
                <select name='supervisor' class='form-control' id='supervisors' required>";
        while($rows = $res->fetch_object()){
            
            echo "<option value='$rows->username'>$rows->fname $rows->lname</option>";
        }
        
        echo '</select><hr>
            <button class="btn btn-warning" name="assign-super" type="submit">
            Pievienot
            </button></form>';
        
    }else{
        
        echo "<h1 class='text-center hide'>Apstiprināt vadītāju</h1>

            <form action='process.php' method='post'>

            <p class='alert alert-warning'>Nav lietotāja, kuram  pievienot vadītāja lomu.Jūs variet izvēlēties no reģistrētajiem lietotājiem to, kuram
            pievienot vadītāja lomu</p>
            <label for='select'>Izvēlieties darbinieku, kuram pievienot vadītāja lomu</label>
                <select name='make-supervisor' class='form-control w-50' id='select'>";
        while($row = $result->fetch_object()){
            
            echo "<option value='$row->username'>$row->fname $row->lname   "
                    . "- $row->staff_id</option>";
        }
        
        echo '</select><br>
            <input type="hidden" name="tab" value="5">
            <button class="btn btn-warning" name="make-super" type="submit">
            Izveidot vadītāju
            </button></form><hr>
            <span class="circled-content centered">Vai</span><hr>
            <h4 class="text-center mb-2">Reģistrēt jaunu vadītāju</h4>';
        
        include_once("inc.register.php");
        
    }
}else{
    echo '<h1 class="text-center">Nav darbinieku</h1>'
    . '<p>Nav pieejamu darbinieku, kuram pievienot vadītāja lomu. '
            . 'Jauku darba dienu!</p>';
}