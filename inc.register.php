<?php
?>
<form action="process.php" method="post">
        
    <div class="row mb-2">
        <div class="col-md-5">
            <label for="title">Title</label><br>

            <select name="title" id="title" class="form-control w-75">
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
                <option value="Dr">Dr</option>
                <option value="Mrs">Miss</option>
            </select>

            <label for="username">Lietotājvārds</label><br>
            <input type="text" name="username" id="username">
            <br>
            <label for="firstname">Vārds</label><br>
                <input type="text" name="firstname" id="firstname">
            <br>
               
            <label for="lastname">Uzvārds</label><br>
                <input type="text" name="lastname" id="lastname">
            <br>
        </div>
        <div class="col-md-5">
            <label class="padding-none">Tel. nr. </label>
            <hr class="divider">

            <label for="code" class="text-sm">Valsts kods</label><br>
            <select name="country-code" id="code" class="form-control w-75">
                <?php

                for($i = 370; $i < 373; $i++){
                    echo "<option value='+$i'>+$i</option>";
                }
                ?>
            </select>
            
            <label for="phone" class="text-sm">Nummurs</label><br>
            <input type="text" name="phone" placeholder="543000391" id="phone">

            <br>
            <label for="email">E-pasts</label><br>
            <input  name="email" id="email">
            <br>

            <label for="password">Parole</label><br>
            <input type="password" name="password" id="password">
        </div>
        <button class="btn btn-warning ml-5" type="submit">Pievienot Vadītāju</button>
    </div>
</form>