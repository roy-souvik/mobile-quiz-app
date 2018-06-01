$(document).ready(function() {
    //$('#manageMemberTable').DataTable();
manageMemberTable = $("#manageMemberTable").DataTable({
		"scrollY": "200px",
        "scrollCollapse": true,
		"ajax": "php_action/retrieve_promoter.php",
		"order": []
});


$("#addMemberModalBtn").on('click', function()
{

		// reset the form 
        $("#createMemberForm")[0].reset();
        // remove the error 
        $(".form-group").removeClass('has-error').removeClass('has-success');
        $(".text-danger").remove();
        // empty the message div
        $(".messages").html("");

        // submit form
        $("#createMemberForm").unbind('submit').bind('submit', function()
        {


        	//-----------------------------------------------------------------------------------------------

        	$(".text-danger").remove();
 
            var form = $(this);
 
            // validation
            var promoter_name = $("#promoter_name").val();
            var promoter_email = $("#promoter_email").val();
            var promoter_pass = $("#promoter_pass").val();
            var promoter_phone = $("#promoter_phone").val();
            var promoter_active = $("#promoter_active").val();
 
            if(promoter_name == "") {
                //$("#promoter_name").closest('.form-group').removeClass('has-error');
                $("#promoter_name").closest('.form-group').addClass('has-error');
                $("#promoter_name").after('The Name field is required');
            } else {
                $("#promoter_name").closest('.form-group').removeClass('has-error');
                $("#promoter_name").closest('.form-group').addClass('has-success');              
            }
 
            if(promoter_email == "") {
                $("#promoter_email").closest('.form-group').addClass('has-error');
                $("#promoter_email").after('The Address field is required');
            } else {
                $("#promoter_email").closest('.form-group').removeClass('has-error');
                $("#promoter_email").closest('.form-group').addClass('has-success');               
            }
 
            if(promoter_pass == "") {
                $("#promoter_pass").closest('.form-group').addClass('has-error');
                $("#promoter_pass").after('The Contact field is required');
            } else {
                $("#promoter_pass").closest('.form-group').removeClass('has-error');
                $("#promoter_pass").closest('.form-group').addClass('has-success');               
            }

            if(promoter_phone == "") {
                $("#promoter_phone").closest('.form-group').addClass('has-error');
                $("#promoter_phone").after('The Contact field is required');
            } else {
                $("#promoter_phone").closest('.form-group').removeClass('has-error');
                $("#promoter_phone").closest('.form-group').addClass('has-success');               
            }
 
            if(promoter_active == "") {
                $("#promoter_active").closest('.form-group').addClass('has-error');
                $("#promoter_active").after('The Active field is required');
            } else {
                $("#promoter_active").closest('.form-group').removeClass('has-error');
                $("#promoter_active").closest('.form-group').addClass('has-success');                
            }
 
            if(promoter_name && promoter_email && promoter_pass && promoter_phone && promoter_active) 
            {
                //submi the form to server
                $.ajax({
                    url : form.attr('action'),
                    type : form.attr('method'),
                    data : form.serialize(),
                    dataType : 'json',
                    success:function(response) 
                    {
 
                        // remove the error 
                        $(".form-group").removeClass('has-error').removeClass('has-success');
 
                        if(response.success == true) 
                        {
                            $(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                             '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                             '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
 
                            // reset the form
                            $("#createMemberForm")[0].reset();      
 
                            // reload the datatables
                            manageMemberTable.ajax.reload(null, false);
                            // this function is built in function of datatables;
                        } else 
                        {
                            $(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                             '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                             '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                        } // /else
                    } // success 
                }); // ajax subit               
            } /// if
 
 
            return false;







        	//-----------------------------------------------------------------------------------------------




        });//SUBMIT FORM

});//ADD MODAL

});

//------------------------------------------REMOVE FUNCTION -------------------------------------------

function removeMember(id = null) {
    if(id) {
        // click on remove button
        $("#removeBtn").unbind('click').bind('click', function() {
            $.ajax({
                url: 'php_action/remove_promoter.php',
                type: 'post',
                data: {promoter_id : id},
                dataType: 'json',
                success:function(response) {
                    if(response.success == true) {                      
                        $(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                             '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                             '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
 
                        // refresh the table
                        manageMemberTable.ajax.reload(null, false);
 
                        // close the modal
                        $("#removeMemberModal").modal('hide');
 
                    } else {
                        $(".removeMessages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                             '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                             '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                    }
                }
            });
        }); // click remove btn
    } else {
        alert('Error: Refresh the page again');
    }
}

//----------------------------------------------REMOVE FUNCTION------------------------------------------------------



//---------------------------------------------EDIT FUNCTION---------------------------------------------------

function editMember(id = null) {
    if(id) {

        // remove the error 
        $(".form-group").removeClass('has-error').removeClass('has-success');
        $(".text-danger").remove();
        // empty the message div
        $(".edit-messages").html("");

        // remove the id
        $("#member_id").remove();

        // fetch the member data
        $.ajax({
            url: 'php_action/get_select_promoter.php',
            type: 'post',
            data: {member_id : id},
            dataType: 'json',
            success:function(response) {
                //$("#editId").val(response.promoter_id);

                $("#editName").val(response.promoter_name);

                $("#editEmail").val(response.promoter_email);

                $("#editPass").val(response.promoter_pass);

                $("#editPhone").val(response.promoter_phone);

                $("#editPoint").val(response.promoter_point);

                $("#editActive").val(response.promoter_active);  

                // mmeber id 
                $(".editMemberModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.promoter_id+'"/>');

                // here update the member data
                $("#updateMemberForm").unbind('submit').bind('submit', function() {
                    // remove error messages
                    $(".text-danger").remove();

                    var form = $(this);

                    // validation
                    var editName = $("#editName").val();
                    var editEmail = $("#editEmail").val();
                    var editPass = $("#editPass").val();
                    var editPhone = $("#editPhone").val();
                    var editPoint = $("#editPoint").val();
                    var editActive = $("#editActive").val();

                    if(editName == "") {
                        $("#editName").closest('.form-group').addClass('has-error');
                        $("#editName").after('<p class="text-danger">The Name field is required</p>');
                    } else {
                        $("#editName").closest('.form-group').removeClass('has-error');
                        $("#editName").closest('.form-group').addClass('has-success');              
                    }

                    if(editEmail == "") {
                        $("#editEmail").closest('.form-group').addClass('has-error');
                        $("#editEmail").after('<p class="text-danger">The Address field is required</p>');
                    } else {
                        $("#editEmail").closest('.form-group').removeClass('has-error');
                        $("#editEmail").closest('.form-group').addClass('has-success');               
                    }

                    if(editPass == "") {
                        $("#editPass").closest('.form-group').addClass('has-error');
                        $("#editPass").after('<p class="text-danger">The Contact field is required</p>');
                    } else {
                        $("#editPass").closest('.form-group').removeClass('has-error');
                        $("#editPass").closest('.form-group').addClass('has-success');               
                    }

                    if(editPhone == "") {
                        $("#editPhone").closest('.form-group').addClass('has-error');
                        $("#editPhone").after('<p class="text-danger">The Contact field is required</p>');
                    } else {
                        $("#editPhone").closest('.form-group').removeClass('has-error');
                        $("#editPhone").closest('.form-group').addClass('has-success');               
                    }

                    if(editPoint == "") {
                        $("#editPoint").closest('.form-group').addClass('has-error');
                        $("#editPoint").after('<p class="text-danger">The Contact field is required</p>');
                    } else {
                        $("#editPoint").closest('.form-group').removeClass('has-error');
                        $("#editPoint").closest('.form-group').addClass('has-success');               
                    }

                    if(editActive == "") {
                        $("#editActive").closest('.form-group').addClass('has-error');
                        $("#editActive").after('<p class="text-danger">The Active field is required</p>');
                    } else {
                        $("#editActive").closest('.form-group').removeClass('has-error');
                        $("#editActive").closest('.form-group').addClass('has-success');                
                    }

                    if(editName && editEmail && editPass && editPhone && editPoint && editActive) {
                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: form.serialize(),
                            dataType: 'json',
                            success:function(response) {
                                if(response.success == true) {
                                    $(".edit-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                      '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                                    '</div>');

                                    // reload the datatables
                                    manageMemberTable.ajax.reload(null, false);
                                    // this function is built in function of datatables;

                                    // close the modal
                                    $("#editMemberModal").modal('hide');

                                    // remove the error 
                                    $(".form-group").removeClass('has-success').removeClass('has-error');
                                    $(".text-danger").remove();
                                } else {
                                    $(".edit-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                      '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                    '</div>')
                                }
                            } // /success
                        }); // /ajax
                    } // /if

                    return false;
                });

            } // /success
        }); // /fetch selected member info

    } else {
        alert("Error : Refresh the page again");
    }
}

//---------------------------------------------------EDIT FUNCTION----------------------------------------------