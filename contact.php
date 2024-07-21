<?php
include ('dbcon.php');
include ('authentication.php')
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="s1.css">
    <script src="https://smtpjs.com/v3/smtp.js">
    </script>

    <script type="text/javascript">
        function sendEmail() {
            Email.send({
                Host: "smtp.elasticemail.com",
                Username: "adityagurav54@gmail.com",
                Password: "67EBB78E493ECBF441776BC4A8C721BF9803",
                To: 'adityagurav54@gmail.com',
                From: "adityagurav54@gmail.com",
                Subject: "New Enquiry",
                Body: "Name : " + document.getElementById("name").value
                    + "<br> Email : " + document.getElementById("mail").value
                    + "<br> Phone No." + document.getElementById("phone").value
                    + "<br> Message : " + document.getElementById("message").value,
            })
                .then(function (message) {
                    alert("mail sent successfully")
                });
        }
    </script>
</head>

<body>
    <form class="form" onsubmit="sendEmail(); reset(); return false;">
        <h1>CONTACT US</h1>
        <input type="text" id="name" placeholder="Full Name">
        <input type="email" id="mail" placeholder="mail">
        <input type="text" id="phone" placeholder="Phone No.">
        <textarea id="message" rows="5" placeholder="How can we help you ?"></textarea>
        <form method="post">
            <input type="button" value="Submit" onclick="sendEmail(); reset(); return false;" />
        </form>
    </form>
</body>

</html>