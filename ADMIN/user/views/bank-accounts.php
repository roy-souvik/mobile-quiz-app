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
          <th>Initial Transaction Id</th>
          <th>Initial Amount</th>
          <th>Approved</th>
          <th>Updated On</th>
          <th>Created On</th>
          <th>Action</th>
        </tr>

        <?php if (!empty($bankAccount)) { ?>
          <tr>
            <td> <?php echo $bankAccount['owner_name']; ?> </td>
            <td> <?php echo $bankAccount['account_number']; ?> </td>
            <td> <?php echo $bankAccount['ifsc']; ?> </td>
            <td> <?php echo $bankAccount['branch_address']; ?> </td>
            <td> <?php echo $bankAccount['verified_transaction_id']; ?> </td>
            <td> <?php echo $bankAccount['verified_amount']; ?> </td>
            <td> <?php echo $bankAccount['is_approved']; ?> </td>
            <td> <?php echo $bankAccount['updated_at']; ?> </td>
            <td> <?php echo $bankAccount['created_at']; ?> </td>
            <td>
              <a href="javascript:void(0);" class="review-account"
               data-userId="<?php echo $userService->user->id; ?>">
                <span class="text-success">Review Account</span>
              </a>
            </td>
          </tr>
      <?php } ?>

      </table>

  </div>
</div>
