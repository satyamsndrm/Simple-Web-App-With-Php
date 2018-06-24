<?php
require_once('db_access.php');
$title='Teams';
include('header.php');
session_unset();
session_destroy();



?>
<div class="container">
<div class="row filterDetails">
    <div class="col-sm-3">
        <select class="form-control" name="teams" id="teamNo">
            <option value="">All</option>
            <option value="team1">Team1</option>
            <option value="team2">Team2</option>
        </select>
    </div>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="inputName" placeholder="Type the name of person"/>
        <div id="showUsers">
            
        </div>
    </div>
</div>

<div id="showUserDetails">
    


</div>




</div>

<?php

include 'footer.php';

?>