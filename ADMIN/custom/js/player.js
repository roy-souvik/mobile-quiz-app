$(document).ready(function() {
    //$('#manageMemberTable').DataTable();
manageMemberTable = $("#manageMemberTable").DataTable({
		"scrollY": "400px",
        "scrollCollapse": true,
		"ajax": "php_action/retrieve_player.php",
		"order": []
});

});

//------------------------------------------REMOVE FUNCTION -------------------------------------------

function removeMember(id = null) {
    if(id) {
        // click on remove button
        $("#removeBtn").unbind('click').bind('click', function() {
            $.ajax({
                url: 'php_action/remove_player.php',
                type: 'post',
                data: {user_id : id},
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
            url: 'php_action/get_select_player.php',
            type: 'post',
            data: {member_id : id},
            dataType: 'json',
            success:function(response) {
                //$("#editId").val(response.promoter_id);

                $("#editName").val(response.user_name);

                $("#editEmail").val(response.user_email);

                $("#editSocial").val(response.user_social_no);

                $("#editPhone").val(response.user_phone_no);

                $("#editPaytm").val(response.user_paytm);

                $("#editBank").val(response.user_bank);

                $("#editBankAc").val(response.user_bank_ac);

                $("#editBankIfsc").val(response.user_bank_ifsc);

                $("#editPoint").val(response.user_point);

                $("#editActive").val(response.user_active);  

                // mmeber id 
                $(".editMemberModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.user_id+'"/>');

                // here update the member data
                $("#updateMemberForm").unbind('submit').bind('submit', function() {
                    // remove error messages
                    $(".text-danger").remove();

                    var form = $(this);

                    // validation
                    
                    var editActive = $("#editActive").val();                    

                    if(editActive == "") {
                        $("#editActive").closest('.form-group').addClass('has-error');
                        $("#editActive").after('<p class="text-danger">The Active field is required</p>');
                    } else {
                        $("#editActive").closest('.form-group').removeClass('has-error');
                        $("#editActive").closest('.form-group').addClass('has-success');                
                    }

                    if(editActive) {
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



function viewMember(id = null) {
    if(id) {
        

        // fetch the member data
        $.ajax({
            url: 'php_action/view_player.php',
            type: 'post',
            data: {member_id : id},
            dataType: 'json',
            success:function(response) {
                //$("#editId").val(response.promoter_id);

                $("#viewName").val(response.user_name);

                $("#viewEmail").val(response.user_email);

                $("#viewSocial").val(response.user_social_no);

                $("#viewPhone").val(response.user_phone_no);

                $("#viewPaytm").val(response.user_paytm);

                $("#viewBank").val(response.user_bank);

                $("#viewBankAc").val(response.user_bank_ac);

                $("#viewIfsc").val(response.user_bank_ifsc);

                $("#viewPoint").val(response.user_point);

                $("#viewAmount").val(response.user_amount);
            } // /success
        }); // /fetch selected member info

    } else {
        alert("Error : Refresh the page again");
    }
}

//---------------------------------------------------EDIT FUNCTION----------------------------------------------