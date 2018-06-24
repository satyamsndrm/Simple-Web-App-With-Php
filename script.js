$(document).ready(function(){

    loadUsers();

    $('#inputName').on('input' , function(){
        var input = $('#inputName').val();
       // console.log(input);
        var dataObj = {fetchByString:true,queryString:input}
        if(input!=''){
            $.ajax({
                url:'action.php',
                type:'POST',
                data:dataObj,
                success:function(res){
                    //console.log(res);
                    $('#showUsers').html(res);
                    $('#showUsers').show('fade');
                }
            });
        }
    });

    $('#inputName').blur(function(){
        $('#showUsers').hide('fade');
    });
    $('body').on('click' , 'div.singleUser' , function(e){
        var id = $(this).attr('userid');
        var dataObj={fetchUser:true,userId:id}
        $.ajax({
            url:'action.php',
            type:'POST',
            data:dataObj,
            success:function(res){
                console.log(res);
                $('#showUserDetails').html(res);
            }
        });
       
    });

    function loadUsers(){
        var dataObj={fetchAllUsers:true,team:false,queryString:false}
        $.ajax({
            url:'action.php',
            type:'POST',
            data:dataObj,
            success:function(res){
                //console.log(res);
                $('#showUserDetails').html(res);
               // alert(res);
            }
        });
    }

    $('#teamNo').on('change' , function(){
        var team = $('#teamNo').val();
        console.log(team);
        var dataObj={fetchByTeam:true,team:team}
        $.ajax({
            url:'action.php',
            type:'POST',
            data:dataObj,
            success:function(res){
               // console.log(res);
                $('#showUserDetails').html(res);
            }
        });
    });

});