<?php
include('header.php');

if(isset($_SESSION['username']) || isset($_GET['msg'])){

    $msg = strval($_GET['msg']);

    echo '<hr><div class="container mb-lg mt-5">
        <div class="alert alert-success alert-dismissible">';
    echo $msg."<span class='mt-0 mr-0 close' data-dismiss='alert'>&times;</span>
        </div>
        <a href='dashboard.php' class='text-md text-center'>
        Turpiniet uz sākumu <i class='fa fa-arrow-right'></i></a></div>";
}else{
    redirect_user("index.php");
}

include_once('footer.php');
?>
