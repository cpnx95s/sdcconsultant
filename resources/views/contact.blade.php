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



  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen"> 

</head>

<body>





  <div id="fullpage">
        <div class="section" data-parallax="scroll" data-image-src="upload/banner4.jpg">
          <div class="overlay-insite"></div>
      <!-- Navigation -->
      @include("header")
      <!-- //Navigation -->
      <!-- //Page container -->
      <div class="name-in">
        <h1>Contact Us
        </h1>
      </div>


      @include("navigator")




    </div>

    <div id="insite-section" class="section" >
      <div id="d-body" class="body">
        <div class="container">






      <div class="row mb-0">
        <div class="col-lg-6">

        <h4 class="text-primary">{{$row->company_name}}</h4>

        <p class="mb-5">{{$row->address}}</p>


          <h5 class="text-primary">TEL
          </h5>  

          <p class="mb-0">
            {!!$row->tel!!}
          &#8203;

          <h5 class="text-primary">FAX</h5>       

          <p>{{$row->fax}}</p>



          <h5 class="text-primary">Email</h5>       

          <p>{{$row->email}}</p>






          <div class="box-social mb-4 mt-4">
          <a href="{{$row->line}}" onclick="showFunction(this)" class="social" id="social2" title="Ultimatefilms"><i class="icofont-line"></i> </a>
           <a href="{{$row->facebook}}" onclick="showFunction(this)" class="social" id="social1" title="Ultimatefilms"><i class="icofont-facebook"></i></a>
           <a href="{{$row->twitter}}" onclick="showFunction(this)" class="social" id="social3" title="Ultimatefilms"><i class="icofont-twitter"></i></a>
         </div>








         <div id="show_social1" class="show_social mt-2" style="display: none;">

         <a href="https://www.facebook.com/ultimatefilmsthailand/" target="_blank">
            <img class="img-fluid" src="images/f.webp">
          </a>
        </div>

        <div id="show_social2" class="show_social mt-2" style="display: none;">
          <a href="https://line.me/R/ti/p/%40256vmwej" target="_blank">
            <img class="img-fluid" src="images/l.webp">
          </a>
        </div>

        <div id="show_social3" class="show_social mt-2" style="display: none;">
          <a href="https://www.instagram.com/ultimatefilms_official/?hl=th" target="_blank">
            <img class="img-fluid" src="images/i.webp">
          </a>
        </div>




        <input type="hidden" id="savesocial" value="">




      </div>
      <div class="col-lg-6">




        <div class="row mt-0 mb-0">
          <div class="col-lg-6">
            <div class="form-group">
              <input type="text" class="form-control rounded-0" placeholder="Name" id="name" name="name" required="" onblur="check_email(this)" aria-required="true">

            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <input type="email" class="form-control rounded-0" placeholder="E-mail" id="email" name="email" required="" aria-required="true">

            </div>
          </div>
        </div>
        <div class="form-group">
          <input type="text" class="form-control rounded-0" placeholder="Subject" id="subject" name="subject" required="" aria-required="true">

        </div>



        <div class="form-group">
          <textarea class="form-control rounded-0" placeholder="Message" id="msg" name="msg" required="" title="Please enter a message." style="height: 248px;" aria-required="true"></textarea>

        </div>



        <div class="mt-1 mb-3"><img src="images/Captcha-demo.gif" width="280" height="76" alt=""></div>

        <button type="button" id="submit-form" class="btn btn-dark">Send Message</button>
        <button type="button" id="submit-form" class="btn btn-dark">Reset</button>



      </div>


<div class="col-12 mt-lg-5">
  
<iframe src="{{$row->map}}" width="1200" height="456" frameborder="0" style="border:0; width: 100%;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
  
</div>


    </div>







        </div>
      </div>
    </div>

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
    menuPosition: "center", 
    container: true
  });
</script>

<script src="js/scrolloverflow.js"></script>
<script src='js/fullpage.js'></script>

<script type="text/javascript">
    new fullpage('#fullpage', {
    // sectionsColor: ['yellow', 'orange', '#C0C0C0', '#ADD8E6'],
    anchors: ['home', 'down'],
    css3: true,
    scrollBar: true,
    scrollingSpeed: 1000,
    navigation: true,
    slidesNavigation: true,
    responsiveHeight: 330,
    controlArrows: false,
    scrollOverflow: true
  });
</script>





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
      }, 1000);
    });
  }




</script>

<script src="js/parallax.min.js"></script>

<script src="js/jquery.chocolat.js"></script>
<script type="text/javascript">
  $(function() {
    $('.view-seventh a').Chocolat();
    $('.view-seventh2 a').Chocolat();
    $('.view-seventh3 a').Chocolat();
  });
</script>


<script type="text/javascript">
  var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
    isMobile = true;
}

var is_iPad = navigator.userAgent.match(/iPad/i) != null;


if (isMobile==true || is_iPad==true) {


    $('#d-body').removeClass('body');

}

</script>

</body>

</html>