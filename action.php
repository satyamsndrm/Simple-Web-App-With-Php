<?php

include('db_access.php');

function showUser($row){
    echo '<div class="col-sm-4">
            <div class="card parentCard" >

                <img class="card-img-top" src="img.jpeg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">'.$row['fName'].' '.$row['lName'].'</h5>
                    <div class="userDetails">
                        <span class="leftCol">Id :-</span>
                        <span class="rightCol">'.$row['id'].'</span>
                    </div>
                    <div class="userDetails">
                        <span class="leftCol">Username :-</span>
                        <span class="rightCol">'.$row['username'].'</span>
                    </div>';
    if(isset($_SESSION['admin']) && $_SESSION['admin']){             
        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal" data-id="'.$row['id'].'">Edit Profile</button>';
    }  
      echo '</div>
            </div>
        </div>';
}

function showTeamWiseUsers($res){
    $team1Shown=false;
    $i=0;
    while($row=mysqli_fetch_assoc($res)){
        if($i==0 && ($row['belongTo']=='team1')){
            $i++;
            $team1Shown=true;
            echo '<div class="card grandParent">
            <div class="card-header">
                '.$row['belongTo'].'
            </div>
            <div class="row">';
        }
        
        if(($i==0 OR $i==1) && $row['belongTo']=='team2'){
            $i++;
            if($team1Shown){
                echo '</div></div>';
            }else{
                $i++;
            }
            echo '<div class="card grandParent">
            <div class="card-header">
                '.$row['belongTo'].'
            </div>
            <div class="row">';
        }
        showUser($row);
    }
}

if(isset($_POST['fetchByString'])){
    $queryString = mysqli_real_escape_string($db , $_POST['queryString']);
    $sql="SELECT * FROM teams 
        WHERE 
        fName LIKE '%$queryString%' OR 
        lName LIKE '%$queryString%' OR 
        username LIKE '%$queryString%' 
        ORDER BY username 
        LIMIT 0, 5";
    $res = mysqli_query($db , $sql) or die(mysqli_error($db));
    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_array($res)){
            echo '<div class="singleUser" userId="'.$row['id'].'">
            <img src="'.$row['photo'].'" alt="Iamge" class="img img-circle left">
            <div class="right">'.$row['fName'].' '.$row['lName'].'</div>
        </div>';
        }
    }else{
        echo '<div class="showNoRes" style="font-weight:700;color:red;">No Results</div>';
    }

}

if(isset($_POST['fetchByTeam'])){
    $team = mysqli_real_escape_string($db , $_POST['team']);
    if($team!=''){
        $sql="SELECT * FROM teams WHERE belongTo='$team'";
    }else{
        $sql="SELECT * FROM teams ORDER BY belongTo";
    }
    $res= mysqli_query($db , $sql) or die(mysqli_error($db));
    showTeamWiseUsers($res);
}

if(isset($_POST['fetchAllUsers'])){
    $sql="SELECT * FROM teams ORDER BY belongTo";
    $res=mysqli_query($db,$sql) or die(mysqli_error($db));
    showTeamWiseUsers($res);
    echo '</div></div>';
}

if(isset($_POST['fetchUser'])){
    $userId = mysqli_real_escape_string($db , $_POST['userId']);
    $sql="SELECT * FROM teams WHERE id=$userId";
    $res=mysqli_query($db,$sql) or die(mysqli_error($db));
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        echo '<div class="card grandParent">
        <div class="card-header">
            '.$row['belongTo'].'
        </div>
        <div class="row">';
        showUser($row);
        echo '</div></div>';
    }else{
        echo '<div class="showError">No Results</div>'.$userId;
    }

}

if(isset($_POST['modalInfo'])){
    $userId = mysqli_real_escape_string($db , $_POST['userId']);
    $sql="SELECT * FROM teams WHERE id=$userId";
    $res=mysqli_query($db,$sql) or die(mysqli_error($db));
    $row=mysqli_fetch_assoc($res);
    $jsonData = json_encode($row);
    echo $jsonData;
}

if(isset($_POST['editUser'])){
    $userId = mysqli_real_escape_string($db , $_POST['userId']);
    $username = mysqli_real_escape_string($db , $_POST['username']);
    $fName = mysqli_real_escape_string($db , $_POST['fName']);
    $lName = mysqli_real_escape_string($db , $_POST['lName']);
    $team = mysqli_real_escape_string($db , $_POST['team']);
    
    $sql = "UPDATE teams SET 
        username='$username' , 
        fName='$fName' , 
        lName='$lName' , 
        belongTo='$team' 
        WHERE id=$userId ";
    $res=mysqli_query($db , $sql);
    if($res){
        echo 'success';
    }else{
        echo 'Failed';
        echo mysqli_error($db);
    }


}

?>