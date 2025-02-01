@extends('layouts.master')

@section('content')

	<!-- ========================= blog-section start ========================= -->
	<section id="blog" class="blog-section pt-50">
		<div class="shape shape-7">
			<img src="{{ asset('dev/assets/img/shapes/shape-6.svg') }}" alt="">
		</div>

		@foreach ($blogs as $row)
		<div class="container">

			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Détail de l'article</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">{{$title}}</h2>
						<p class="wow fadeInUp" data-wow-delay=".4s">
							Publié le <?php echo(nl2br(substr(date(DATE_RFC822, strtotime($row->created_at)), 0, 23))); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="row">

				
					{{-- expr --}}
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="single-blog mb-30 wow fadeInUp" data-wow-delay=".2s">
						<div class="blog-img">
							<a href="javascript:void(0);"><img src="{{ asset('article/'.$row->photo) }}" alt=""></a>
						</div>
						<div class="blog-content">
							<h4><a href="/blog/{{$row->slug}}"> {{$row->titre}} </a></h4>
							
							<div class="col-md-12 text-justify">
								{!! html_entity_decode($row->description) !!}
							</div>
						</div>
					</div>
				</div>



				<div class="col-md-12 mt-1 mb-4 text-center">
					<h5>Le partager sur:</h5> 
					<a href="javascript:void(0);" class="btn btn-outline-primary my-2 my-sm-0 btn_facebook"><i class="lni lni-facebook mr-1"></i> Facebook
                    </a> 
                    <a href="javascript:void(0);" class="btn btn-outline-primary my-2 my-sm-0 btn_twitter"><i class="lni lni-twitter mr-1"></i> Twitter
                    </a> 
                    <a href="javascript:void(0);" class="btn btn-outline-primary my-2 my-sm-0 btn_linkedin"><i class="lni lni-linkedin mr-1"></i> LinkedIn
                    </a>
                </div>
				

				


			
			</div>
		</div>


		@endforeach
	</section>
	<!-- ========================= blog-section end ========================= -->

 

@endsection