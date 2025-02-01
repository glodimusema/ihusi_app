@extends('layouts.master')

@section('content')

 <!-- ======= Breadcrumbs Section ======= -->
   <!-- ========================= blog-section start ========================= -->
	<section id="blog" class="blog-section pt-10">
		<div class="shape shape-7">
			<img src="{{ asset('dev/assets/img/shapes/shape-6.svg') }}" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xl-8 mx-auto">
					<div class="section-title text-center mb-55">
						<span class="wow fadeInDown" data-wow-delay=".2s">Contact</span>
						<h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">LesInformations de contact</h2>
						<p class="wow fadeInUp" data-wow-delay=".4s">Nous sommes ravis de vous rencontrer et répondre à votre préoccupation Pour cela, servez-vous des coordonnées ci-dessus.</p>
					</div>
				</div>
			</div>
			<div class="row mb-4">

	           @foreach ($siteInfo as $row)
		        <!-- ======= Contact Section ======= -->
			    <section id="contact">
			      <div class="container" data-aos="fade-up">
			        <div class="row">

			        

			          <div class="col-lg-6 col-md-4">

			          	 <div class="contact-about text-center">
				              <p>
				              	Nous sommes ici pour vous servir
												N'hesitez pas regoignez déjà notre groupe.
											  </p>
				              <div class="social-links">
					                @if ($row->facebook !='')
					                  {{-- expr --}}
					                  <a href="{{$row->facebook}}" target="_blank" class="facebook"><i class="lni lni-facebook"></i></a>
					                @endif

					                @if ($row->twitter !='')
					                  {{-- expr --}}
					                  <a href="{{$row->twitter}}" target="_blank" class="twitter"><i class="lni lni-twitter"></i></a>
					                @endif

					                 @if ($row->linkedin !='')
					                  {{-- expr --}}
					                  <a href="{{$row->linkedin}}" target="_blank" class="linkedin"><i class="lni lni-linkedin"></i></a>
					                @endif
				                
				                
				              </div>
			            </div>
			            <div class="col-md-12 info">

			            	<div class="row">

			            		{{-- bloc --}}
			            		<div class="col-xl-4 col-lg-4 col-md-6">
									<div class="single-blog mb-30 wow fadeInUp card" data-wow-delay=".2s">
										
										<div class="blog-content card-body">
											<div>
								                <i class="lni lni-home"></i>
								                <p>{{$row->adresse}}</p>
								             </div>
											
										</div>
									</div>
								</div>
			            		{{-- fin bloc --}}

			            		{{-- bloc --}}
			            		<div class="col-xl-4 col-lg-4 col-md-6">
												<div class="single-blog mb-30 wow fadeInUp card" data-wow-delay=".2s">
													
													<div class="blog-content card-body">
														<div>
											                <i class="lni lni-envelope"></i>
											                <p>
											                	<a href="mailto:{{$row->email}}" class="text-muted">{{$row->email}}</a>
											                </p>
											            </div>
														
													</div>
												</div>
											</div>
			            		{{-- fin bloc --}}

			            		{{-- bloc --}}
			            		<div class="col-xl-4 col-lg-4 col-md-6">
												<div class="single-blog mb-30 wow fadeInUp card" data-wow-delay=".2s">
													
													<div class="blog-content card-body">
														<div>
											                <i class="lni lni-phone"></i>
											                <p><a href="tel:{{$row->tel1}}" class="text-muted" style="text-decoration: none;">{{$row->tel1}}</a><br>
											                  <a href="tel:{{$row->tel2}}" class="text-muted" style="text-decoration: none;">{{$row->tel2}}</a>
											                </p>
											            </div>
														
													</div>
												</div>
											</div>
			            		{{-- fin bloc --}}
			            		
			            	</div>	



			              

			            </div>
			          </div>

			          <div class="col-lg-6 col-md-8">

			            <div class="col-md-12">
			              @if (session('success'))

			                    <div class="col-md-12">

			                      <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
			                        <strong>Opération reussie avec succès!!!👌</strong> {{ session('success') }}
			                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                          <span aria-hidden="true">&times;</span>
			                        </button>
			                      </div>
			                      
			                    </div>
			                    
			              @endif

			              @if (session('error'))
			                <div class="col-md-12">
			                  <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
			                    <strong>Une erreur est subvenue!!!🔕</strong> {{ session('error') }}
			                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                      <span aria-hidden="true">&times;</span>
			                    </button>
			                  </div>
			                </div>
			                  
			              @endif
			            </div>
			            <div class="form2">
			              <form action="{{ route('sendMessage') }}" method="post" role="form" class="">
			                @csrf
			                
			                <div class="row">
			                  <div class="form-group col-lg-6">
			                    <input type="text" name="name" class="form-control" id="name" placeholder="Votre nom" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
			                  </div>
			                  <div class="form-group col-lg-6 mt-3 mt-lg-0">
			                    <input type="email" class="form-control" name="email" id="email" placeholder="Votre adresse mail" data-rule="email" data-msg="Please enter a valid email">
			                  </div>
			                </div>
			                <div class="form-group mt-3">
			                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet ou objet de message" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject">
			                </div>

			                <div class="form-group mt-3">
			                  <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Votre numéro de téléphone" data-rule="minlen:4" data-msg="+243...">
			                </div>

			                <div class="form-group mt-3">
			                  <textarea class="form-control" name="message" rows="5" placeholder="Taper votre Message" required></textarea>
			                </div>
			                <div class="my-3 text-center">
			                 <input type="submit" name="envoyer" class="btn btn-primary theme-btn" value="Envoyer le message">
			                </div>
			                
			              </form>
			            </div>
			          </div>

			          <div class="col-lg-12 col-md-8 mt-3">
			          	<iframe class="col-md-12" style="height: 400px;" 
		                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.1088402058804!2d29.227611614103107!3d-1.6772917366491455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dd0f7094de376f%3A0x2fa5d064648e8f80!2sISIG!5e0!3m2!1sfr!2scd!4v1669642075100!5m2!1sfr!2scd"></iframe>
			          </div>
			        </div>

			      </div>
			    </section>
			    <!-- End Contact Section -->

		    @endforeach


			
			</div>
		</div>
	</section>
	<!-- ========================= blog-section end ========================= -->



 

@endsection