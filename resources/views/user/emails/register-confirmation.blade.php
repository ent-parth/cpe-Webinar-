<html>
    <head>
        <title>{{ env('SITE_NAME') }}</title>
    </head>
    <body style="background: white; color: black">
        <center><h1>{{$title}}</h1></center>
        <p>Hi! {{$name}},</p>
        <p>Thank you for registering on {{ env('SITE_NAME') }}</p>
        <p>Please confirm your registration by clicking on the following button
			<a href="{{ route('confirm',$id) }}" target="_blank" style="color: blue">VERIFY</a><br>
		</p>
		<p>
			If Above button does't work, please copy this link and paste it into the address bar of your browser.<br>
			<a href="{{ route('confirm',$id) }}" target="_blank" style="color: blue">{{ route('confirm',$id) }}</a><br></p>	
		</p>	
    </body>
</html>