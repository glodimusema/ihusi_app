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
						<span class="wow fadeInDown" data-wow-delay=".2s">Faisons un partenariat</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Comment devenir partenaire et commencer à travailler avec nous?</h2>
						
					</div>
				</div>
			</div>
			<div class="row mb-4">

	          
		      <section class="inner-page">
			      <div class="container">

			        @foreach ($basics as $row)
			          {{-- expr --}}
			          <div class="col-md-12 text-justify">
			             {!! $row->structure !!}
			          </div>
			        @endforeach
			       
			      </div>
			    </section>

			
			</div>
		</div>
	</section>
	<!-- ========================= blog-section end ========================= -->

		<!--========================= partainer========================= -->
	<section class="we-do-section pt-50">
		<div class="shape shape-1">
			<img src="{{ asset('dev/assets/img/shapes/shape-2.svg') }}" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Nos partenaires</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Ils nous accompagnent et nous font confiance!</h2>
						
					</div>
				</div>
			</div>
			<div class="row">
				

				@foreach ($partenaires as $row)
					{{-- expr --}}
					<div class="col-lg-3">
						<div class="we-do-item mb-10">
							<div class="we-do-icon mb-20" style="cursor: pointer;">
								<a style="cursor: pointer;" href="<?php
								if($row->url !='')
								{
									echo($row->url);
								}
								else{
									echo("#");
								}
								?>" target="_blank">
									<img src="{{ asset('partenaire/'.$row->photo) }}" alt="">
								</a>
							</div>
							
						</div>
				    </div>
				@endforeach
				
				
			</div>
		</div>
	</section>
	<!--========================= fin  partainer========================= -->



 

@endsection