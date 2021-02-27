<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="images/favicon.ico">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="S.D.C. Company Limited Project Consultant & Management.">
  <meta name="keyword" content="S.D.C. Company Limited Project Consultant & Management.">
  <meta name="author" content="S.D.C. Company Limited Project Consultant & Management.">

  <title>S.D.C. Company Limited Project Consultant & Management.</title>

  <link href="https://fonts.googleapis.com/css?family=Sarabun:100,200,300,400,500,600,700,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel='stylesheet' href='css/fullpage.css'>
  <link rel="stylesheet" href="css/coreNavigation-1.1.3.css" />
  <link rel="stylesheet" href="css/icofont.css">
  <link rel="stylesheet" href="css/header.css"> 
  <link rel="stylesheet" href="css/typography.css" />
  <link rel="stylesheet" href="css/custom.css" />
  <link rel="stylesheet" href="css/main-custom.css" />
  <link rel="stylesheet" href="css/footer.css" />



  <!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->

  <!-- Latest compiled and minified CSS -->


  <link href="css/carousel.css" rel="stylesheet" media="all">
  <link href="css/bootstrap-touch-slider.css" rel="stylesheet" media="all">


</head>

<body>





  <div id="fullpage">
    <div class="section">







      <!-- Navigation -->
      @include("header")

      <!-- //Navigation -->

      @include("slide")
      <!-- //Page container -->






      <div class="name">
        <h1>S.D.C. Company Limited<br>
          Project Consultant & Management
        </h1>
      </div>





      <!-- Footer -->

      @include("footer")









    </div>


  </div>





  <script src="js/jquery.js"></script>
  <!-- jQuery library -->

  <!-- Popper JS -->
  <script src="js/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/coreNavigation-1.1.3.js"></script>
  <script>
    $('nav').coreNavigation({
      menuPosition: "right", 
      container: true
    });
  </script>

  <script src="js/scrolloverflow.js"></script>
  <script src='js/fullpage.js'></script>

  <script type="text/javascript">
    new fullpage('#fullpage', {
    sectionsColor: ['#27313d'],
  });
</script>

<!-- 
<script type="text/javascript" src="js/wowslider.js"></script>
<script type="text/javascript" src="js/script.js"></script>
 -->



<script type="text/javascript">


  if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
    backToTop = function () {
      var scrollTop = $(window).scrollTop();
      if (scrollTop > scrollTrigger) {
        $('#back-to-top').addClass('show');
      } else {
        $('#back-to-top').removeClass('show');
      }
    };
    backToTop();
    $(window).on('scroll', function () {
      backToTop();
    });
    $('#back-to-top').on('click', function (e) {
      e.preventDefault();
      $('html,body').animate({
        scrollTop: 0
      }, 2800);
    });
  }




</script>
<script src="js/carousel.js"></script>

<script src="js/jquery.touchSwipe.min.js"></script>


<!-- Bootstrap bootstrap-touch-slider Slider Main JS File -->
<script src="js/bootstrap-touch-slider.js"></script>

<script type="text/javascript">
    $('#bootstrap-touch-slider').bsTouchSlider();
</script>



</body>

</html>