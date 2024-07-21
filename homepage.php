<?php
include_once ('dbcon.php');
include ('authentication.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- custom cdn -->
    <link rel="stylesheet" href="sty1.css">

</head>

<body>
    <header>
        <h1>LET'S CLEAN THE WORLD</h1>
        <a href="logout.php"><button class="logout-button">Logout</button></a>
    </header>
    <div class="main-container">
        <section class="main1">
            <a href="homepage1.php"><button>DAILY TIMELINE</button></a><br>
            <a href="locator.php"><button>GO TO E-WASTE LOCATOR</button></a><br>
            <a href="type.php"><button>LET'S LEARN</button></a><br>
            <a href="contact.php"><button>CONTACT US</button></a>
        </section>
        <section class="main2">
            <p>E-waste, or electronic waste, consists of discarded electronic devices and components, which, if not
                properly managed, can lead to significant environmental and health hazards. Cleaning up e-waste involves
                a multi-step process including collection, transportation, recycling, and safe disposal. Properly
                handling e-waste ensures that valuable materials are recovered and reused, reducing the strain on
                natural resources and minimizing harmful emissions from improper disposal methods like landfilling or
                incineration.

                Our website is a comprehensive platform dedicated to addressing the challenges of e-waste management. It
                provides a user-friendly interface for locating nearby e-waste facility centers, making it convenient
                for individuals and businesses to dispose of their electronic waste responsibly. Users can also contact
                us directly through the site for any queries or assistance regarding e-waste collection and disposal.
                Additionally, our website is a valuable educational resource, offering insights and information on the
                importance of e-waste recycling, the potential hazards of improper disposal, and best practices for
                reducing electronic waste. By raising awareness and facilitating proper e-waste management, we aim to
                create a more sustainable future for our community and the environment.</p>
        </section>
    </div>
</body>

</html>