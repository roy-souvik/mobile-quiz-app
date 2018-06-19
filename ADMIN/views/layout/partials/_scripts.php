  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script>

    $(document).ready(function() {
      $('#review-account').click(function(e) {
        e.preventDefault();
        var amount = prompt("Please enter the token amount in INR", 2);
        var transactionId = prompt("Please enter the transaction id");

        if (amount == null || transactionId == null) {
          alert('Wrong details. Please enter again');
          return;
        }

        var userId = $(this).attr('data-userId');

        var url = location.origin + '/QUIZ/UserWebservice.php?req=review_bank_account_by_admin&user_id=' + userId + '&amount=' + amount + '&transaction_id=' + transactionId;
        location.replace(url);
      });
    });

    CKEDITOR.replace('editor1');
  </script>
