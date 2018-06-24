
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalHeader">User:-</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="username" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="username">
          </div>
          <div class="form-group">
            <label for="fName" class="col-form-label">First Name:</label>
            <input type="text" class="form-control" id="fName">
          </div>
          <div class="form-group">
            <label for="lName" class="col-form-label">Last Name:</label>
            <input type="text" class="form-control" id="lName">
          </div>
          <div class="row">
              <div class="col-sm-3">
                  <label class="col-form-label" for="team">Select Team:-</label>
              </div>
              <div class="col-sm-7">
                <select class="form-control" name="team" id="team">
                    <option value="team1">Team1</option>
                    <option value="team2">Team2</option>
                </select>
              </div>
          </div>
          <input type="hidden" id="userId" value="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editUserButton">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="showFlashMessages" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
            Successfully Edited
      </div>
    </div>
  </div>

<script>
$('#userModal').on('show.bs.modal', function (event) {
    console.log('modlClicked');
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  $.ajax({
      url:'action.php',
      type:'POST',
      data:{modalInfo:true , userId:id},
      success: function(data){
          console.log(data);
          var json = JSON.parse(data);
          modal.find('input#userId').val(id);
          modal.find('input#username').val(json.username);
          modal.find('input#fName').val(json.fName);
          modal.find('input#lName').val(json.lName);
          modal.find('select#team').val(json.belongTo);
          modal.find('.modal-title').text('User :- ' + json.username);

      }
  });
});

$('body').on('click', '#editUserButton',function(e){
    var mdl = $(this).parents().find('.modal-content');
    var userId = mdl.find('input#userId').val();
    var username = mdl.find('input#username').val();
    var fName = mdl.find('input#fName').val();
    var lName = mdl.find('input#lName').val();
    var team = mdl.find('select#team').val();
    var dataObj={editUser:true , username:username , fName:fName , lName:lName , team:team , userId:userId};
    console.log(dataObj);
    $.ajax({
        url:'action.php',
        type:'POST',
        data:dataObj,
        success:function(data){
            $('#userModal').modal('hide');
            $('#showFlashMessages').modal('show');
            setTimeout(() => {
                $('#showFlashMessages').modal('hide');
                window.location.href='admin.php';
            }, 1000);
        }
    })
});

</script>

    </body>
</html>