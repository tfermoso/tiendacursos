<?php
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= ClientID ?>"></script>
</head>

<body>
    <div id="paypal-buttons-container"></div>

    <script>
        // Render the PayPal buttons
        paypal.Buttons({
            onApprove(data) {
                console.log(data);
            }
        }).render('#paypal-buttons-container');
    </script>
</body>

</html>