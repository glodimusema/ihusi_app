@extends('layouts.master')

@section('content')

	<!-- ========================= blog-section start ========================= -->
	<section id="blog" class="blog-section pt-50">
		<div class="shape shape-7">
			<img src="{{ asset('dev/assets/img/shapes/shape-6.svg') }}" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Article de blog</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Dernières nouvelles</h2>
						<p class="wow fadeInUp" data-wow-delay=".4s">Explorez des articles sur nos actualités du monde .</p>
					</div>
				</div>
			</div>
			<div class="row">

				@foreach ($blogs as $row)
					{{-- expr --}}
				<div class="col-xl-4 col-lg-4 col-md-6">
					<div class="single-blog mb-30 wow fadeInUp" data-wow-delay=".2s">
						<div class="blog-img">
							<a href="javascript:void(0);"><img src="{{ asset('article/'.$row->photo) }}" alt="" height="300"></a>
						</div>
						<div class="blog-content">
							<h4><a href="/blog/{{$row->slug}}"> {{$row->titre}} </a></h4>
							<p></p>
							<a class="read-more" href="/blog/{{$row->slug}}">Lire la suite <i class="lni lni-arrow-right"></i></a>
						</div>
					</div>
				</div>
				@endforeach

				<div class="col-md-12 mt-2 mb-4">
	              <div class="d-flex justify-content-center">
	                 {!! $blogs->links() !!}
	                
	              </div>
	          </div> 


			
			</div>
		</div>
	</section>
	<!-- ========================= blog-section end ========================= -->

 

@endsection