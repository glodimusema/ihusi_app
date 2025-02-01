@extends('layouts.master')

@section('content')

	@foreach ($services as $key)
		{{-- expr --}}
		<!--========================= service-section start ========================= -->
	<section id="services" class="service-section pt-50">
		<div class="shape shape-3">
			<img src="{{ asset('dev/assets/img/shapes/shape-3.svg') }}" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Détail sur le service</span>
						<h5 class="mb-15 wow fadeInUp" data-wow-delay=".4s"> {{$key->titre}} </h5>

						{!! html_entity_decode($key->description) !!}
						
					</div>
				</div>
			</div>
			
		</div>
	</section>
	<!--========================= service-section end ========================= -->

	<!--========================= faq-section start ========================= -->
	<section class="faq-section theme-bg">
		
		<div class="container">
			<div class="row">
				<div class="col-xl-12 offset-xl-12 col-lg-12 col-md-12">
					<div class="faq-content-wrapper pt-90 pb-90">
						
						<div class="faq-wrapper accordion" id="accordionExample">

							<div class="section-title">
								<span class="text-white wow fadeInDown text-center" data-wow-delay=".2s">Sous services
									Questions</span>
								
							</div>


							@foreach (\App\Models\SouServiceEntrep\SouServiceEntrep::where('id_service', $key->id)->get() as $row)
								{{-- expr --}}

								<div class="faq-item mb-20">
									<div id="headingTwo">
										<h5 class="mb-0">
											<button class="faq-btn btn collapsed" type="button" data-toggle="collapse"
												data-target="#collapseTwo{{$row->id}}" aria-expanded="true" aria-controls="collapseTwo{{$row->id}}">
												{{$row->titre}} <i class="lni"></i>
											</button>
										</h5>
									</div>

									<div id="collapseTwo{{$row->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
										<div class="faq-content">
											{!! html_entity_decode($key->description) !!}
										</div>
									</div>
								</div>
							@endforeach

							
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--========================= faq-section end ========================= -->
	@endforeach
  

@endsection