<!DOCTYPE html>
<html lang="en">
<head>
    <title>CV a Personal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/iconcv.png" sizes="32x32">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Simple CV Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!-- Custom Theme files -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/font-awesome.css" rel="stylesheet">        <!-- font-awesome icons -->
    <link rel="stylesheet" href="css/swipebox.css">    <!-- swipebox -->
    <!-- //Custom Theme files -->
    <!-- js -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- //js -->
    <!-- web-fonts -->
    <link href="//fonts.googleapis.com/css?family=Kurale" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>
    <!-- //web-fonts -->
</head>
<body>
<!-- main -->
<div class="buttons-wrapper">
    <input id="slide1" class="w3slider-input" type="radio" name="slider" checked>
    <input id="slide2" class="w3slider-input" type="radio" name="slider">
    <input id="slide3" class="w3slider-input" type="radio" name="slider">
    <input id="slide4" class="w3slider-input" type="radio" name="slider">
    <ul class="slider">
        <?php
        include("Pages/About_Me.php");
        include("Pages/Skills.php");
        include("Pages/Experience.php");
        include("Pages/Contact.php");
        ?>
    </ul>
    <label for="slide1"></label>
    <label for="slide2"></label>
    <label for="slide3"></label>
    <label for="slide4"></label>
</div>
<!-- //main -->
<!-- swipe box js -->
<script src="js/jquery.swipebox.min.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $(".swipebox").swipebox();
    });
</script>
<!-- //swipe box js -->
<!-- Skill Bar js -->
<script src="js/skill.bars.jquery.js"></script>
<script>
    $(document).ready(function () {

        $('.skillbar').skillBars({
            from: 0,
            speed: 4000,
            interval: 100,
            decimals: 0,
        });

    });
</script>
<!-- //End Skill Bar js -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/bootstrap.js"></script>
</body>
</html>