@extends('layouts.master')

@section('content')

 <!-- ======= Breadcrumbs Section ======= -->
   <!-- ========================= blog-section start ========================= -->
	<section id="blog" class="blog-section pt-50">
		<div class="shape shape-7">
			<img src="{{ asset('dev/assets/img/shapes/shape-6.svg') }}" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Notre groupe</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Explorez nos agents et leurs talents</h2>
						<p class="wow fadeInUp" data-wow-delay=".4s">Nous ici pour vous</p>
					</div>
				</div>
			</div>
			<div class="row mb-4">

	          
		     <!-- ======= Team Section ======= -->
			    <section id="team" class="section-bg">
			      <div class="container" data-aos="fade-up">
			        
			        <div class="row">

			          @foreach ($teams as $row)
			            {{-- expr --}}
			         
			          <div class="col-lg-3 col-md-6">
			            <div class="member">
			              <div class="pic"><img src="{{ asset('team/'.$row->photo) }}" alt=""></div>
			              <h4>{{$row->nom}}</h4>
			              <span>{{$row->titre}}</span>
			              <div class="social">

			                 @if ($row->telephone != '')
			                   {{-- expr --}}
			                    <a href="tel:{{$row->telephone}}"><i class="bi bi-phone"></i></a>
			                 @endif

			                 @if ($row->email != '')
			                   {{-- expr --}}
			                   
			                    <a href="mailto:{{$row->email}}"><i class="bi bi-envelope"></i></a>
			                 @endif

			                 @if ($row->facebook != '')
			                   {{-- expr --}}
			                   
			                    <a href="{{$row->facebook}}" target="_blank"><i class="bi bi-facebook"></i></a>
			                 @endif

			                 @if ($row->twitter != '')
			                   {{-- expr --}}
			                   
			                    <a href="{{$row->twitter}}" target="_blank"><i class="bi bi-twitter"></i></a>
			                 @endif

			                 @if ($row->linkedin != '')
			                   {{-- expr --}}
			                  <a href="{{$row->linkedin}}" target="_blank"><i class="bi bi-linkedin"></i></a>
			                 @endif
			                
			               
			              </div>
			            </div>
			          </div>

			           @endforeach

			          <div class="col-md-12 mt-5 text-center">
			              <div class="d-flex justify-content-center">
			                 {!! $teams->links() !!}
			                
			              </div>
			          </div>  




			         
			        </div>

			      </div>
			    </section><!-- End Team Section -->


			
			</div>
		</div>
	</section>
	<!-- ========================= blog-section end ========================= -->



 

@endsection