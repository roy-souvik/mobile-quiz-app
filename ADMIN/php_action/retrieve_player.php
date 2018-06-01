<?php 

require_once 'db_connect.php';
 
$output = array('data' => array());
 
$sql = "SELECT * FROM tbl_user WHERE user_delete = 1 ORDER BY user_id DESC";
$query = $connect->query($sql);
 
$x = 1;
while ($row = $query->fetch_assoc()) {
    $active = '';
    if($row['user_active'] == 1) {
        $active = '<label class="label label-success">Active</label>';
    } else {
        $active = '<label class="label label-danger">Deactive</label>'; 
    }
 
    $actionButton = '
    <div class="btn-group">
     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     Action <span class="caret"></span>
     </button>
     <ul class="dropdown-menu">
     <li><a type="button" data-toggle="modal" data-target="#viewMemberModal" onclick="viewMember('.$row['user_id'].')"> <span class="glyphicon glyphicon-zoom-in"></span> View</a></li>      
     <li><a type="button" data-toggle="modal" data-target="#editMemberModal" onclick="editMember('.$row['user_id'].')"> <span class="glyphicon glyphicon-edit"></span> Edit</a></li>
     <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeMember('.$row['user_id'].')"> <span class="glyphicon glyphicon-trash"></span> Remove</a></li>   
     </ul>
    </div>';

    $userImage = ' <img src="../../IMAGE/USER/'.$row['user_image'].'" class="img-responsive img-circle img-thumbnail" height=50% width=50% alt="User Image">';
 
    $output['data'][] = array(
        $x,
        $row['user_name'],
        $row['user_email'], 
        //$row['user_image'],      
        $userImage,
        $row['user_phone_no'],        
        $active,
        $actionButton
    );
 
    $x++;
}
 
// database connection close
$connect->close();
 
echo json_encode($output);



 ?>