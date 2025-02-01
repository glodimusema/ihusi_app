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
						<span class="wow fadeInDown" data-wow-delay=".2s">Notre galerie photo</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Explorez nos photos</h2>
						<p class="wow fadeInUp" data-wow-delay=".4s">Voir nos recents événements</p>
					</div>
				</div>
			</div>
			<div class="row mb-4">

	          
		    <!-- ======= Gallery Section ======= -->
		    <section id="gallery">
		      <div class="container-fluid" data-aos="fade-up">
		        

		        <div class="row g-0">


		          @foreach ($galeries as $row)
		            {{-- expr --}}

		            <div class="col-lg-4 col-md-6">
		              <div class="gallery-item">
		                <a href="{{ asset('galery/'.$row->photo) }}" data-gall="portfolioGallery" class="gallery-lightbox">
		                  <img src="{{ asset('galery/'.$row->photo) }}" alt="">
		                </a>
		              </div>
		            </div>
		         
		         

		           @endforeach

		          <div class="col-md-12 mt-5">
		              <div class="d-flex justify-content-center">
		                 {!! $galeries->links() !!}
		                
		              </div>
		          </div>  


		        </div>

		      </div>
		    </section>
		    <!-- End Gallery Section -->


			
			</div>
		</div>
	</section>
	<!-- ========================= blog-section end ========================= -->



 

@endsection