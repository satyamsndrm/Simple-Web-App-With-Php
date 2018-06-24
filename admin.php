<?php
require_once('db_access.php');
$title='Admin';
include('header.php');
//$_SESSION['admin']=true;
if(isset($_POST['action'])){
    $admin=mysqli_real_escape_string($db , $_POST['username']);
    $pass=mysqli_real_escape_string($db , $_POST['password']);
    $sql = "SELECT * FROM admin WHERE username='$admin' AND password='$pass'";
    $res=mysqli_query($db , $sql);
    if(mysqli_num_rows($res)>0){
        $_SESSION['admin']=true;
        $showLoginForm=false;
    }
}

if(isset($_SESSION['admin']) && $_SESSION['admin']){
    $showUsers=true;
    $showLoginForm=false;
}else{
    $showLoginForm=true;
    $showUsers=false;
}

$loginForm='<div class="row">
<div class="col-sm-6 offset-sm-3">
    <form class="form" method="post" action="">
        <div class="form-group">
            <label for="username" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="admin">
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label">Password:</label>
            <input type="text" class="form-control" id="password" name="password" value="admin">
        </div>
        <input type="submit" value="Login" name="action" />
    </form>
</div>
</div>';

$users='<div class="container">
            <div class="row filterDetails">
                <div class="col-sm-3">
                    <select class="form-control" name="teams" id="teamNo">
                        <option value="">All</option>
                        <option value="team1">Team1</option>
                        <option value="team2">Team2</option>
                    </select>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Type the name of the person" id="inputName"/>
                    <div id="showUsers">
                        
                    </div>
                </div>
            </div>

            <div id="showUserDetails">
            </div>
        </div>';
if($showLoginForm){
    echo $loginForm;
}
if($showUsers){
    echo $users;
}

include 'footer.php';

?>
