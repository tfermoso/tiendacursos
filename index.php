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
            // Order is created on the server and the order id is returned
            createOrder() {
                return fetch("create-paypal-order.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        // use the "body" param to optionally pass additional order information
                        // like product skus and quantities
                        body: JSON.stringify({
                            cart: [{
                                sku: "YOUR_PRODUCT_STOCK_KEEPING_UNIT",
                                quantity: "YOUR_PRODUCT_QUANTITY",
                            }, ],
                        }),
                    })
                    .then((response) => response.json())
                    .then((order) => order.id);
            },
            // Finalize the transaction on the server after payer approval
            onApprove(data) {
                return fetch("capture-paypal-order.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            orderID: data.orderID
                        })
                    })
                    .then((response) => response.json())
                    .then((orderData) => {
                        // Successful capture! For dev/demo purposes:
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        const transaction = orderData.purchase_units[0].payments.captures[0];
                        alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                        // When ready to go live, remove the alert and show a success message within this page. For example:
                        // const element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  window.location.href = 'thank_you.html';
                    });
            }
        }).render('#paypal-buttons-container');
    </script>
</body>

</html>