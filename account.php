<?php
if(isset($_SESSION['staff-user']) && $_SESSION['staff-user'] !== ''){

    $username = $_SESSION['staff-user'];

    $email = $_SESSION['staff-email'];

    $id = $_SESSION['staff-id'];

    $tbl = "employee";

    $type = "Staff";

}elseif(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ''){

    $username = $_SESSION['admin-user'];

    $email = $_SESSION['admin-email'];

    $id = $_SESSION['admin-id'];

    $tbl = "admin";

    $type = "Admin";

}else{
    redirect_user("index.php");
}
show_alert();

$result = query_db("SELECT * FROM $tbl WHERE username = '$username'");

if($result){

    if(is_session_inplace("staff-user") || is_session_inplace("supervisor-user")){

        $res = $result->supervisor;

        if($res){

            $sup = $res;

        }elseif($res == "") {
          $sup = 'Not yet assigned';
        } else {
            $sup = "Nav";
        }

        $uid = $result->staff_id;
    }elseif (is_session_inplace("supervisor-user")) {

        $uid = $result->supervisor_id;
        $sup = "N/A";
    }  else {

        $uid = $result->admin_id;
        $sup = '';
    }

    $staff = <<<STAFF
            <form action='update.php' method="post">
                <table class="table table-hover table-lg table-responsive-sm w-100">
                    <thead>
                        <th colspan="3" class="text-center">$type Details</th>
                    </thead>
                <tr>
                    <td><h6>Darbinieka ID</h3></td>
                    <td>$uid</td>
                    <td>
                        <button class="btn text-sm" disabled>
                            <small>Cannot Change</small>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td><h6>Vārds Uzvārds</h6></td>
                    <td>$result->fname $result->lname</td>
                    <td>
                        <button class="btn text-sm" disabled>
                            <small>Cannot Change</small></button>
                    </td>
                </tr>

                <tr>
                    <td><h6>Lietotājvārds</h6></td>
                    <td>$result->username</td>
                    <td>
                        <button class="btn text-sm" disabled><small>Cannot Change</small></button>
                    </td>
                </tr>

                 <tr>
                    <td><h6>Vadītājs</h6></td>
                    <td>$sup</td>
                    <td>
                        <button class="btn text-sm" disabled><small>Cannot Change</small></button>
                    </td>
                </tr>

                <tr>
                    <td><h6>Pievienošanās datums</h6></td>
                    <td>$result->date_registered</td>
                    <td>
                        <button class="btn text-sm" disabled><small>Cannot Change</small></button>
                    </td>
                </tr>
                <tr>
                    <td><h6>Tālr. nr</h6></td>
                    <td>
                    <div class="stack-input">
                        <span>$result->country_code</span>
                        <input type='tel' name="phone" value="0$result->phone">
                         <input type='hidden' name="id" value="$result->id">
                    </div>
                    </td>
                    <td>
                        <button class="btn btn-default" disabled>Disabled</button>
                    </td>
                </tr>

                <tr>
                    <td><h6>Epasts</h6></td>
                    <td>
                        <input name='email' type="email" value="$result->email">
                     </td>
                    <td>
                        <button class="btn btn-default" disabled>Disabled</button>
                    </td>
                </tr>

                <tr>
                   <td><h6>Jauna parole</h6></td>
                   <td>
                    <input type="password" name="password" id="password" placeholder="Jauna parole">
                    <p class="text-red error-line1"></p>
                    </td>
                    <td>
                        <button class="btn btn-default" disabled>Disabled</button>
                    </td>
                </tr>
                <tr>
                   <td><h6>Apstiprināt paroli</h6></td>
                   <td>
                    <input type="password" name="confpassword" id="conf-pass" placeholder="Retype Password">
                    <p class="text-red error-line2"></p>
                    </td>
                    <td>
                        <button class="btn btn-default" disabled>Disabled</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><button name="update" type="submit" class="btn btn-primary">
                    Atjaunot
                    </button>
                    </td>
                </div>

              </table>
            </form>
STAFF;

    echo $staff;

}  else {
echo '<h2>Nav datu</h2>';
}


$settings = <<<_EPL
        </div>
        <div class="card mb-4">
            <h3 class="text-danger">Dzēst kontu</h3>
            <div  class="alert alert-warning">
                <small><b>Note:</b> Dzēšot kontu jūs izdzēsīsiet visus datus, kas saistīti ar Jums.</small>
                <small>Labāka opcija ir sazināties ar administratoru, lai deaktvizētu Jūsu kontu</small>
            </div>

            <form id="delete-account" method="post" action"delete.user.php">
                <input type="hidden" name="id" type="text" value="$staff_id">
                 <label for="confirm-delete">
                <input name=delete_account" type="checkbox" id="confirm-delete">
                Esmu informēts, tiešām vēlos dzēst savu kontu </label><hr>

                <div class="hide" id="hide">
                <label for="password">Ievadiet savu paroli lai turpinātu</label><br><br>
                <input name="password" type="password" placeholder="Password"><hr>
                <input type='hidden' name='table' value='employee'>
                <input type='hidden' name='page' value='dashboard.php?tab=4'>

                <button name="delete-account" type="submit" class="btn btn-danger">Dzēst kontu</button>
                </div>
            </form>
        </div>
    </div>

_EPL;

echo $settings;
?>
