<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Email mail de reunitialisation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="shortcut icon" href="{{ asset('images/site.jpg') }}">

</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12 card">

					<div class="card-header text-center">
						Mail de réunitialisation
					</div>
					<!-- formulaire -->
					<div class="card-body">

						<p>Salut {{ $data['name'] }}</p>
						<p>{{ $data['message'] }}.</p>
						<p>
							
							{{-- {{ $link = url($data['lien']) }} --}}
							<a href="{{ $data['lien'] }}" class="btn btn-primary btn-block">Reinitialisation Mot mot de passe</a>
						</p>
						
						
						
					</div>
					<!-- fin -->
					
				</div>
			</div>
		</div>
	</div>
</body>
</html>