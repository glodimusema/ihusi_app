<!DOCTYPE html>
<html class="no-js" lang="">

<!-- Mirrored from preview.uideck.com/items/softbit/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 24 Dec 2022 12:00:08 GMT -->

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>IHUSI-GROUP</title>
  {{-- <title>HOTEL</title> --}}
  <meta name="description" content="" />

  <meta name="csrf-token" content="{{csrf_token() }} ">
  <meta name="csrf-token" value="{{ csrf_token() }}"/>
  <script>window.Laravel={ csrfToken:'{{csrf_token() }}'} </script>
  
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

 
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>{{$title}}</title>

 
  
  <!-- mes scripts -->
  <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
  <!-- fin mes scripts -->

 
  <link rel="stylesheet" href="{{ asset('dev2/assets/css/bootstrap-5.0.0-beta2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('dev2/assets/css/LineIcons.2.0.css') }}" />
  <link rel="stylesheet" href="{{ asset('dev2/assets/css/tiny-slider.css') }}" />
  <link rel="stylesheet" href="{{ asset('dev2/assets/css/animate.css') }}" />
  <link rel="stylesheet" href="{{ asset('dev2/assets/css/main.css') }}" />


  {{-- mes scripts --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


  {{-- autres --}}
  <!-- Vendor CSS Files -->
  <link href="{{ asset('dev/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('dev/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('dev/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('dev/assets/css/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('dev/assets/css/main.css') }}">
  {{-- fin autre --}}
  {{-- fin mes scripta  --}}

  <style type="text/css">
    .hero-section2{
        position: relative;
        overflow: hidden;
        height: 90px;
        display: flex;
        align-items: center;
        background-image: url({{ asset('dev2/assets/images/hero/logo.png') }});
        background-size: cover;
        background-position: bottom center;
        background-repeat: no-repeat;
        z-index: 1;

    }


  </style>





</head>

<body>
  <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

  <div class="preloader">
    <div class="loader">
      <div class="spinner">
        <div class="spinner-container">
          <div class="spinner-rotator">
            <div class="spinner-left">
              <div class="spinner-circle"></div>
            </div>
            <div class="spinner-right">
              <div class="spinner-circle"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


 


  <!-- ========================= header start ========================= -->

   <header class="header">
    @foreach ($siteInfo as $row)
      {{-- expr --}}
      <div class="navbar-area">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index-2.html">
                  <img src="{{ asset('images/'.$row->logo) }}" width="60" height="60" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                  aria-label="Toggle navigation">
                  <span class="toggler-icon"></span>
                  <span class="toggler-icon"></span>
                  <span class="toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                  <div class="ms-auto">
                    <ul id="nav" class="navbar-nav ms-auto">
                     <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                              <a class="nav-link2" href="/login" target="_blank">Se connecter</a>
                            </li>
                        @else

                           <li class="nav-item">
                              <a class="nav-link2" href="/dashbord" target="_blank">
                                <i class="lni lni-user"></i>
                                {{ Auth::user()->name }}
                              </a>
                            </li>

                        @endguest
                    </ul>
                  </div>
                </div>
                

              </nav>

            </div>
          </div>

        </div>

      </div>
    @endforeach

  </header>
 
  <!-- ========================= header end ========================= -->

  @if ($title=="Accueil vous soit doux!")
    {{-- expr --}}

     

     @foreach ($carousels as $row)
        {{-- expr --}}
        <section id="home" class="hero-section">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-xl-6 col-lg-6 col-md-10">
                <div class="hero-content">
                  <h1>{{$row->titre}}</h1>
                  <p> {{$row->description}}</p>
                  <a href="/contact" class="main-btn btn-hover">Laissez nous un message</a>
                </div>
              </div>
              <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="hero-image text-center text-lg-end">
                  <img src="{{ asset('fichier/'.$row->photo) }}" alt="">
                </div>
              </div>
            </div>
          </div>
        </section>
        {{-- bloc --}}
        
        {{-- fin bloc --}}
      @endforeach




  @else

  <section id="home" class="hero-section2">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-6 col-lg-6 col-md-10">
            <div class="hero-content">
              
            </div>
          </div>
          <div class="col-xxl-6 col-xl-6 col-lg-6">
           
          </div>
        </div>
      </div>
    </section>

  @endif

 

    @yield('content')


  @foreach ($siteInfo as $row)
    {{-- expr --}}
    <footer class="footer pt-100">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-10">
            <div class="footer-widget">
              <div class="logo">
                <a href="/" class="logo"><img src="{{ asset('images/'.$row->logo) }}"  alt="" width="180" height="180"></a>
              </div>
              <p class="desc">{{$row->description}}</p>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h5>Liens rapides</h5>
              <ul class="links">
              </ul>
            </div>
          </div>
          <div class="col-xl-3 col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">

            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="footer-widget">
              <h5>Suivre sur</h5>

              <ul class="links">
                  <li><a href="tel:{{$row->tel1}}">N° de Téléphone: {{$row->tel1}} </a></li>
                  <li><a href="mailto:{{$row->email}}">Adresse mail: {{$row->email}}</a></li>
                  <li><a href="javascript:void(0);">Adresse domicile: {{$row->adresse}}</a></li>
              </ul>
              <ul class="social-links">

                 <li><a href="<?php 

                    if($row->facebook !=''){
                      echo($row->facebook);
                    }else{
                      echo('#');
                    }


                  ?>"><i class="lni lni-facebook-filled"></i></a></li>
                <li><a href="<?php 

                    if($row->twitter !=''){
                      echo($row->twitter);
                    }else{
                      echo('#');
                    }


                  ?>"><i class="lni lni-twitter-filled"></i></a></li>
                <li><a href="<?php 

                    if($row->linkedin !=''){
                      echo($row->linkedin);
                    }else{
                      echo('#');
                    }


                  ?>"><i class="lni lni-linkedin-original"></i></a></li>

               

              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="copyright">
           <p class="mb-0 text-center">Conçu et développé par <a href="glodimaley@mail.com" rel="nofollow">glodimaley@mail.com</a></p>
        </div>
      </div>
    </footer>


    <a href="#" class="scroll-top btn-hover">
      <i class="lni lni-chevron-up"></i>
    </a>
  @endforeach


  <script src="{{ asset('dev2/assets/js/bootstrap-5.0.0-beta2.min.js') }}"></script>
  <script src="{{ asset('dev2/assets/js/tiny-slider.js') }}"></script>
  <script src="{{ asset('dev2/assets/js/wow.min.js') }}"></script>
  <script src="{{ asset('dev2/assets/js/polyfill.js') }}"></script>
  <script src="{{ asset('dev2/assets/js/main.js') }}"></script>

  {{-- mes scripts --}}
   {{-- autres --}}
  <script src="{{ asset('dev/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('dev/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('dev/assets/js/main2.js')}}"></script>

  {{-- fin autre --}}

  <script type="text/javascript">
    $(document).ready(function(){
      // alert("Cool");
    });
  </script>


  <script type="text/javascript">

        $(document).ready(function() {

            /*

            DEBIT SCRIPT PARTAGE DE BUTTON RESEAUX SOCIAUX

            */

            var url_default = window.location.pathname;

            var domaine ="http://localhost:8000"+url_default;

            var url_share = domaine;

            // console.log(url_share);

            var popupCenter = function(url, title, width, height){

                var popupWidth = width || 640;

                var popupHeight = height || 320;

                var windowLeft = window.screenLeft || window.screenX;

                var windowTop = window.screenTop || window.screenY;

                var windowWidth = window.innerWidth || document.documentElement.clientWidth;

                var windowHeight = window.innerHeight || document.documentElement.clientHeight;

                var popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2 ;

                var popupTop = windowTop + windowHeight / 2 - popupHeight / 2;

                var popup = window.open(url, title, 'scrollbars=yes, width=' + popupWidth + ', height=' + popupHeight + ', top=' + popupTop + ', left=' + popupLeft);

                popup.focus();

                return true;

            };

            $(document).on('click', '.btn_twitter', function(event) {

                event.preventDefault();

                /* Act on the event */

                var url = url_share;

                var shareUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(document.title) +

                    "&via=RogerPatrona" +

                    "&url=" + encodeURIComponent(url);

                popupCenter(shareUrl, "Partager sur Twitter");

            });



            $(document).on('click', '.btn_facebook', function(event) {

                event.preventDefault();

                /* Act on the event */

                var url = url_share;

                var shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url);

                popupCenter(shareUrl, "Partager sur facebook");

            });



            $(document).on('click', '.btn_google', function(event) {

                event.preventDefault();

                /* Act on the event */

                var url = url_share;

                var shareUrl = "https://plus.google.com/share?url=" + encodeURIComponent(url);

                popupCenter(shareUrl, "Partager sur Google+");

            });



            $(document).on('click', '.btn_linkedin', function(event) {

                event.preventDefault();

                /* Act on the event */

                var url = url_share;

                var shareUrl = "https://www.linkedin.com/shareArticle?url=" + encodeURIComponent(url);

                popupCenter(shareUrl, "Partager sur Linkedin");

            });



            /*

                FIN SCRIPT PARTAGE DE BUTTON RESEAUX SOCIAUX

            */



            var limit = 7;

            var start = 0;

            var action = 'inactive';



            function lazzy_loader(limit)

            {

              var output = '';

              for(var count=0; count<limit; count++)

              {

                output += '<div class="post_data">';

                output += '<p><span class="content-placeholder" style="width:100%; height: 30px;">&nbsp;</span></p>';

                output += '<p><span class="content-placeholder" style="width:100%; height: 100px;">&nbsp;</span></p>';

                output += '</div>';

              }

              $('#load_data_message').html(output);

            }



            lazzy_loader(limit);



            setTimeout(function(){

                 $('#load_data').append('');

                 $('#load_data_message').html("");

            }, 1000);

        });

  </script>
  {{-- fin mes scripts --}}

</body>

<!-- Mirrored from preview.uideck.com/items/softbit/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 24 Dec 2022 12:00:14 GMT -->

</html>


