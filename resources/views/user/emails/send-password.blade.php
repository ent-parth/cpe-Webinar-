<html>
    <head>
        <title>{{env('SITE_NAME')}}</title>
    </head>
    <body style="background: white; color: black">
        <center>
			<h1>{{$title}}</h1>
		</center>
        <p>Hi! {{$name}},</p>
        <p>You have request for update your password.</p>
        @if($url_link != '')
        <p>Click <a href="{{ route('change-password',$url_link) }}" target="_blank" style="color: blue">here</a> to change your password.</p>
        <p>
			If Above button does't work, please copy this link and paste it into the address bar of your browser.<br>
			<a href="{{ route('change-password',$url_link) }}" target="_blank" style="color: blue">{{ route('change-password',$url_link) }}</a><br></p>	
		</p>
        @else
        <p>You are register on {{ env('SITE_NAME') }} </p>
        @endif
        <p>If you are not requested for your password, please ignore it.</p>
		<p>Kind regards,
		MYCPA Team </p>
    </body>
</html>
<?php //exit;?>