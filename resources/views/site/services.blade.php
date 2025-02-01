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
						<span class="wow fadeInDown" data-wow-delay=".2s">Services</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Nos services quotidiens</h2>
						<p class="wow fadeInUp" data-wow-delay=".6s">
							Les Services sur lesquels nous nous appuyons pour satisfaire nos clients et nos partenaires.
						</p>
					</div>
				</div>
			</div>
			<div class="row">

				@foreach ($services as $row)
					{{-- expr --}}
					<div class="col-lg-4 col-md-6">
						<div class="service-item mb-30">
							<div class="service-icon mb-25">
								<div class="we-do-icon mb-25 text-center">
									<img src="{{ asset('fichier/'.$row->photo) }}" style="width: 100px; height: 100px; border-radius: 100%;" alt="">
								</div>
							</div>
							<div class="service-content">
								<h4>{{$row->nom}}</h4>
								<p>{{$row->titre}}</p>
								<a href="/service/{{$row->id}}" class="read-more">Lire la suite <i class="lni lni-arrow-right"></i></a>
							</div>
							<div class="service-overlay img-bg"></div>
						</div>
					</div>
				@endforeach


				 <div class="col-md-12 mt-2 mb-4">
		              <div class="d-flex justify-content-center">
		                 {!! $services->links() !!}
		                
		              </div>
		          </div>  
				


			
			</div>
		</div>
	</section>
	<!--========================= service-section end ========================= -->
  

@endsection