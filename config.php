<?php 
require ('stripe-php-master/init.php');

$Publishablekey ="pk_test_51OuFHjRooV7dSo9FTbuJknNoaQAyuFjyeEZYkebWblfzZ76DQgGmW7MjhNb7LPYkBFjmyc8J4fAa10QoNtytzC0C00Ss91S1Xs";

$secretkey ="sk_test_51OuFHjRooV7dSo9FPzypJ3DgHrWlRI9JVol9j0P1Inloh5u6bV0a9AK1CuLVL7o6uPhzUyn4sn8qCJLVy1lTrZXg003ts1CwyD";

\Stripe\stripe::setApiKey($secretkey);

?>;