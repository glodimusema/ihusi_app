
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token() }} ">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <script>window.Laravel={ csrfToken:'{{csrf_token() }}'} </script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

   
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{$title}}</title>

   
    
    <!-- mes scripts -->
    <link rel="shortcut icon" href="./images/logo.png">
    <!-- fin mes scripts -->

    {{-- swot et canavas --}}
    <link rel="stylesheet" href="{{ asset('css/canvas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beagle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swot.css') }}">
     
    {{-- fin swot et canavas --}}

    <!-- ========================= CSS here ========================= -->
  <link rel="stylesheet" href="{{ asset('dev/assets/css/bootstrap-5.0.5-alpha.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dev/assets/css/LineIcons.2.0.css') }}">
  <link rel="stylesheet" href="{{ asset('dev/assets/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('dev/assets/css/tiny-slider.css') }}">
  <link rel="stylesheet" href="{{ asset('dev/assets/css/main.css') }}">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


  {{-- autres --}}
   <!-- Vendor CSS Files -->
  <link href="{{ asset('dev/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('dev/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('dev/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('dev/assets/css/style.css')}}" rel="stylesheet">
  {{-- fin autre --}}

  

  

    
</head>
<body>
  <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

  <!-- ========================= preloader start ========================= -->
  <div class="preloader">
    <div class="loader">
      <div class="ytp-spinner">
        <div class="ytp-spinner-container">
          <div class="ytp-spinner-rotator">
            <div class="ytp-spinner-left">
              <div class="ytp-spinner-circle"></div>
            </div>
            <div class="ytp-spinner-right">
              <div class="ytp-spinner-circle"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- preloader end -->

  <!-- ========================= header start ========================= -->
  <header id="home" class="header">

    <div class="header-wrapper">

        @foreach ($siteInfo as $row)
          {{-- expr --}}
        <div class="header-top theme-bg">
          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <div class="header-top-left text-center text-md-left">
                  <ul>
                    <li><a href="tel:{{$row->tel1}}"><i class="lni lni-phone"></i> {{$row->tel1}} </a></li>
                    <li><a href="mailto:{{$row->email}}"><i class="lni lni-envelope"></i> {{$row->email}}</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="header-top-right d-none d-md-block">
                  <ul>
                    <li><a target="_blank" href="<?php 

                      if($row->facebook !=''){
                        echo($row->facebook);
                      }else{
                        echo('#');
                      }


                    ?>"><i class="lni lni-facebook-filled"></i></a></li>
                    <li><a target="_blank" href="<?php 

                      if($row->twitter !=''){
                        echo($row->twitter);
                      }else{
                        echo('#');
                      }


                    ?>"><i class="lni lni-twitter-filled"></i></a></li>
                    <li><a target="_blank" href="<?php 

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
        </div>
        @endforeach



        <div class="navbar-area">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                  <a class="navbar-brand" href="index.html">
                    <img src="{{ asset('images/'.$row->logo) }}" width="60" height="60" alt="Logo">
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                  </button>
        
                  <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                   

                    <!-- Right Side Of Navbar -->
                    <ul id="nav" class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- <li class="nav-item">
                              <a class="nav-link2" href="/">Accueil</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/about">A propos</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/services">Service</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/galeryphoto">Image</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/blogs">Blog</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/contact">Contact</a>
                            </li> --}}

                            <li class="nav-item">
                              <a class="nav-link2" href="/login" target="_blank">Se connecter</a>
                            </li>
                        @else

                            {{-- <li class="nav-item">
                              <a class="nav-link2" href="/">Accueil</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/about">A propos</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/services">Service</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/galeryphoto">Image</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/blogs">Blog</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link2" href="/contact">Contact</a>
                            </li> --}}

                            <li class="nav-item">
                              <a class="nav-link2" href="/dashbord" target="_blank">
                                <i class="lni lni-user"></i>
                                {{ Auth::user()->name }}
                              </a>
                            </li>


                           {{--  <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li> --}}
                        @endguest
                    </ul>
                  </div> <!-- navbar collapse -->
                </nav> <!-- navbar -->
              </div>
            </div> <!-- row -->
          </div> <!-- container -->
        </div> <!-- navbar area -->
    </div>

  </header>
  <!-- ========================= header end ========================= -->
  <div class="slider-wrapper">

      @yield('content')



  </div>




  @foreach ($siteInfo as $row)
      {{-- expr --}}
  <!-- ========================= footer start ========================= -->
  <footer class="footer pt-100 img-bg bg-dark" style="background-image:url('dev/assets/img/bg/footer-bg.jpg');">
    <div class="container">
      <div class="footer-widget-wrapper">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="footer-widget mb-30">
              <a href="/" class="logo"><img src="{{ asset('images/'.$row->logo) }}"  alt="" width="200" height="200"></a>
              <p>
                {{$row->description}}
              </p>
              <div class="footer-social-links">
                <ul>
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
                  <li><a href="#"><i class="lni lni-instagram-original"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-lg-3 col-md-6">
            <div class="footer-widget mb-30">
              {{-- <h4>Ressources</h4>
              <ul class="footer-links"> --}}
                {{-- <li><a href="/">Accueil</a></li>
                <li><a href="/about">A propos</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/galeryphoto">Images</a></li>
                <li><a href="/blogs">Blog</a></li>
                <li><a href="/contact">Contact</a></li> --}}
              {{-- </ul> --}}
            </div>
          </div>
          <div class="col-xl-2 col-lg-3 col-md-5">
            <div class="footer-widget mb-30">
              {{-- <h4>Soutien</h4>
              <ul class="footer-links">
                <li><a href="/don"> Nous faire un don</a></li>
               
                <li><a href="/partenariat">Faisons un partenariat</a></li>
                <li><a href="/travail">Ce que nous faisons</a></li>
                <li><a href="/structure">Structure de gestion</a></li>
                <li><a href="/videos">Nos vidéos</a></li>
                <li><a href="/groupe">Notre famille</a></li>
                
              </ul> --}}
            </div>
          </div>
          <div class="col-xl-4 col-lg-12 col-md-7">
            <div class="footer-widget mb-30">
              <h4>Contact pour information</h4>
              <ul class="footer-links">
                <li><a href="tel:{{$row->tel1}}">N° de Téléphone: {{$row->tel1}} </a></li>
                <li><a href="mailto:{{$row->email}}">Adresse mail: {{$row->email}}</a></li>
                <li><a href="javascript:void(0);">Adresse domicile: {{$row->adresse}}</a></li>
               
              </ul>
              <div class="map-canvas">
               

                <iframe class="map" id="gmap_canvas"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.1088402058804!2d29.227611614103107!3d-1.6772917366491455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dd0f7094de376f%3A0x2fa5d064648e8f80!2sISIG!5e0!3m2!1sfr!2scd!4v1669642075100!5m2!1sfr!2scd"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright-area">
        <p class="mb-0 text-center">Conçu et développé par <a href="glodimaley@mail.com" rel="nofollow">glodimaley@mail.com</a></p>
      </div>
    </div>
  </footer>
  <!-- ========================= footer end ========================= -->
  @endforeach  



  <!-- ========================= scroll-top ========================= -->
  <a href="#" class="scroll-top">
    <i class="lni lni-arrow-up"></i>
  </a>

  <!-- ========================= JS here ========================= -->
  <script src="{{ asset('dev/assets/js/bootstrap.bundle-5.0.0.alpha-min.js') }}"></script>
  <script src="{{ asset('dev/assets/js/wow.min.js') }}"></script>
  <script src="{{ asset('dev/assets/js/tiny-slider.js') }}"></script>
  <script src="{{ asset('dev/assets/js/main.js') }}"></script>



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
</html>