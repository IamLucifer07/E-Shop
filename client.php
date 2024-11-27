<?php
require('config.php');
?>
<form action="submit.php" class="stripeForm"  method="POST">
<input type="hidden" name="total_price" value="<?php echo $_GET['total']; ?>">
 <script
             src="https://checkout.stripe.com/checkout.js" class="stripe-button";
             name="order";
             data-key="<?php echo $Publishablekey?>"
             data-amount="<?= $_GET['total']*100; ?>"
             data-name="Pay with Stripe"
             data-description="Payment"
             data-image=""
             data-currency="usd">

       </script>

   
</form>