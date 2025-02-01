<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'une entreprise</title>
	<link rel="stylesheet" type="text/css" href="{{url('css/app.css')}}">
</head>
<body>
<div class="container">
	<div class="col-md-12">
     <div class="row">
         <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card card-body">

                    <div align="center">
                        <a href="{{url('/')}}"><img width="100" src="{{url('images/logo.png')}}"></a>
                    </div>
                
                    <h3>
                      Création d'une entreprise
                    </h3><br>
                    <h4>Nom de l'entreprise : <a href="#"><span> {{ $data['project_name'] }}</span></a></h4>
                    <p>
                        Ceo : <b>{{ $data['name'] }}</b><br/>
                        E-mail :  <b> <a href="mailto:<?php echo $data["email"]; ?>">{{ $data['email'] }}</a> </b> <br>
                       
                        <br>
                        Cordialement, <br>
                        Merci .
                    </p>    
                </div>
            </div>
            <div class="col-md-1"></div>
     </div>   
    </div>
</div>
</body>
</html>