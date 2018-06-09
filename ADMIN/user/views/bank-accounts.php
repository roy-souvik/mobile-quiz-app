<?php $bankAccount = $userService->getBankDetails(); ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Bank Details</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover">
        <tr>
          <th>Owner Name</th>
          <th>Account Number</th>
          <th>IFSC</th>
          <th>Branch Address</th>
          <th>Approved</th>
          <th>Created On</th>
        </tr>

        <?php if (!empty($bankAccount)) { ?>
          <tr>
            <td> <?php echo $bankAccount['owner_name']; ?> </td>
            <td> <?php echo $bankAccount['account_number']; ?> </td>
            <td> <?php echo $bankAccount['ifsc']; ?> </td>
            <td> <?php echo $bankAccount['branch_address']; ?> </td>
            <td> <?php echo $bankAccount['is_approved']; ?> </td>
            <td> <?php echo $bankAccount['created_at']; ?> </td>
          </tr>
      <?php } ?>

      </table>


  </div>
</div>
