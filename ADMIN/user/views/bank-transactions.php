<?php $transactions = $userService->getBankTransactions(); ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Bank Transactions</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover">
        <tr>
          <th>Request Date</th>
          <th>Request Amount</th>
          <th>Transaction Date</th>
          <th>Transaction Amount</th>
          <th>Transaction Status</th>
          <th>Comment</th>
        </tr>

        <?php
          if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
        ?>
          <tr>
            <td> <?php echo $transaction['request_date']; ?> </td>
            <td> <?php echo $transaction['request_amount']; ?> </td>
            <td> <?php echo $transaction['transaction_date']; ?> </td>
            <td> <?php echo $transaction['transaction_amount']; ?> </td>
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
