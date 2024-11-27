<?php 
 require('config.php');
 //require('checkout.php');


 if(isset($_POST['stripeToken']))
  {
        
        \Stripe\Stripe::setVerifySslCerts(false);
        $grand_total=$_POST['total_price'];
        $token=$_POST['stripeToken'];
        
        $data=\Stripe\Charge::create(array(

        "amount" => $grand_total*100,
        "currency"=>"usd",
        "description"=>"Shopie Payment",
        "source"=> $token,

));
    header('location:home.php');
    $_SESSION['message'] = 'Order placed successfully!';
    // echo "<pre>";
    // print_r($data);
 }
?>

