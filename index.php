<?php
  die('Go to admin section to view and create questions.');

/*
	require_once 'php_action/db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
	<title>QUESTION ENTRY</title>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <style type="text/css">
	 div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
				height: 600px;
    }
	</style>

</head>
<body>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable( {
        "scrollY": 200,
        "scrollX": true
    } );
} );
</script>

<div class="manageMember">
    <a href="create.php"><button type="button">Add New Question</button></a>
</div>

<br><br><br>

<table id="example" class="display nowrap" width="100%" cellspacing="0">
        <thead>
    	    <tr>
    	    	<td>ID</td>
	    	    <td>EN QUEST:</td>
	    		<td>OPTION - 1</td>
	    		<td>OPTION - 2</td>
	    		<td>OPTION - 3</td>
	    		<td>OPTION - 3</td>
	    		<td>ANSWER</td>
	    	    <td>বাংলাা প্রশ্ন</td>
	    		<td>অপশন - 1</td>
	    		<td>অপশন - 2</td>
	    		<td>অপশন - 3</td>
	    		<td>অপশন - 3</td>
	    		<td>উত্তর</td>
	    	    <td>हिंदी सवाल</td>
	    		<td>विकल्प - 1</td>
	    		<td>विकल्प - 2</td>
	    		<td>विकल्प - 3</td>
	    		<td>विकल्प - 3</td>
	    		<td>उत्तर</td>
	    	</tr>
        </thead>
        <tbody>
					<?php
					$sql = "SELECT * FROM tbl_question";
					$result = $connect->query($sql);

					if($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>".$row['qus_id']."</td>
											<td>".$row['qus_en_qustion']."</td>
											<td>".$row['qus_en_option_1']."</td>
											<td>".$row['qus_en_option_2']."</td>
											<td>".$row['qus_en_option_3']."</td>
											<td>".$row['qus_en_option_4']."</td>
											<td>".$row['qus_en_right_ans']."</td>

											<td>".$row['qus_bn_qustion']."</td>
											<td>".$row['qus_bn_option_1']."</td>
											<td>".$row['qus_bn_option_2']."</td>
											<td>".$row['qus_bn_option_3']."</td>
											<td>".$row['qus_bn_option_4']."</td>
											<td>".$row['qus_bn_right_ans']."</td>

											<td>".$row['qus_hn_qustion']."</td>
											<td>".$row['qus_hn_option_1']."</td>
											<td>".$row['qus_hn_option_2']."</td>
											<td>".$row['qus_hn_option_3']."</td>
											<td>".$row['qus_hn_option_4']."</td>
											<td>".$row['qus_hn_right_ans']."</td>
									</tr>";
							}
					} else {
							echo "<tr><td colspan='5'><center>No Data Avaliable</center></td></tr>";
					}
					?>

        </tbody>
    </table>

</body>
</html>
<?php */ ?>
