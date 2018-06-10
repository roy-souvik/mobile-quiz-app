<?php $transactions = $userService->getMobileTransactions(); ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Mobile Recharge Transactions</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover">
        <tr>
          <th>Mobile Number</th>
          <th>Operator</th>
          <th>Request Date</th>
          <th>Request Action Date</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Comment</th>
        </tr>

        <?php
          if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
        ?>
          <tr>
            <td> <?php echo $transaction['recharge_no']; ?> </td>
            <td> <?php echo $transaction['recharge_operator']; ?> </td>
            <td> <?php echo $transaction['transaction_request_date']; ?> </td>
            <td> <?php echo $transaction['transaction_action_date']; ?> </td>
            <td> <?php echo $transaction['transaction_request_amount']; ?> </td>
            <td> <?php echo $transaction['transaction_status']; ?> </td>
            <td> <?php echo $transaction['comment']; ?> </td>
          </tr>
      <?php
          }
        }
      ?>

      </table>

  </div>
</div>
