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
						<span class="wow fadeInDown" data-wow-delay=".2s">Nous faire un don</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Aidez-nous à les aider!</h2>
						
					</div>
				</div>
			</div>
			<div class="row mb-4">

	          
		      <section class="inner-page">
			      <div class="container">

			        @foreach ($basics as $row)
			          {{-- expr --}}
			          <div class="col-md-12 text-justify">
			             {!! $row->don !!}
			          </div>
			        @endforeach
			       
			      </div>
			    </section>

			
			</div>
		</div>
	</section>
	<!-- ========================= blog-section end ========================= -->



 

@endsection