@extends('layouts.master')

@section('content')

	<!--========================= service-section start ========================= -->
	<section id="services" class="service-section pt-50">
		<div class="shape shape-3">
			<img src="{{ asset('dev/assets/img/shapes/shape-3.svg') }}" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Vidéos</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Nous vous aidons et nous vous formons sur le bien être de la santé!</h2>
						<p class="wow fadeInUp" data-wow-delay=".6s">
							Explorez nos vidéos.
						</p>
					</div>
				</div>
			</div>
			<div class="row">

				@foreach ($videos as $row)
					{{-- expr --}}
					<div class="col-lg-4 col-md-6">
						<div class="service-item mb-30">
							<div class="service-icon mb-25">
								<div class="we-do-icon mb-25 text-center">
									<div class="embed-responsive embed-responsive-16by9">
				                        <iframe style="width: 100%;" class="embed-responsive-item" src="{{$row->url}}" allowfullscreen></iframe>
				                    </div>
								</div>
							</div>
							<div class="service-content">
								<h4>{{$row->titre}}</h4>
								<p>{{$row->description}}</p>
								
							</div>
							<div class="service-overlay img-bg"></div>
						</div>
					</div>
				@endforeach


				 <div class="col-md-12 mt-2 mb-4">
		              <div class="d-flex justify-content-center">
		                 {!! $videos->links() !!}
		                
		              </div>
		          </div>  
				


			
			</div>
		</div>
	</section>
	<!--========================= service-section end ========================= -->
  

@endsection