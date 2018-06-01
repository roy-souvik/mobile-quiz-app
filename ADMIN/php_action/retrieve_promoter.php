<?php 

require_once 'db_connect.php';
 
$output = array('data' => array());
 
$sql = "SELECT * FROM tbl_promoter WHERE promoter_delete = 1 ORDER BY promoter_id DESC";
$query = $connect->query($sql);
 
$x = 1;
while ($row = $query->fetch_assoc()) {
    $active = '';
    if($row['promoter_active'] == 1) {
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
     <li><a type="button" data-toggle="modal" data-target="#editMemberModal" onclick="editMember('.$row['promoter_id'].')"> <span class="glyphicon glyphicon-edit"></span> Edit</a></li>
     <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeMember('.$row['promoter_id'].')"> <span class="glyphicon glyphicon-trash"></span> Remove</a></li>   
     </ul>
    </div>';

    $password = '<input type="password" class="form-control" id="editPass" name="editPass" placeholder="Password" value="('.$row['promoter_pass'].')" disabled="true">';

 
    $output['data'][] = array(
        $x,
        $row['promoter_name'],
        $row['promoter_email'],
        //$row['promoter_pass'],
        $password,
        $row['promoter_phone'],
        $row['promoter_point'],        
        $active,
        $actionButton
    );
 
    $x++;
}
 
// database connection close
$connect->close();
 
echo json_encode($output);



 ?>