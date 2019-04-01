<!DOCTYPE html>
<html>
    <head>
        <title>Ohh You Lost.</title>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico" />

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
				background:#23303e;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
			.btn{cursor:pointer; position: relative; text-decoration: none; text-transform: uppercase; vertical-align: middle;}
.btn-4{overflow:hidden; position:relative;}
.btn-4:after{background:#fff; content:""; height:155px; left:-75px; opacity:0.2; position:absolute; top:-50px; -webkit-transform:rotate(35deg); transform:rotate(35deg); -webkit-transition: all 5s cubic-bezier(0.19, 1, 0.22, 1); transition: all 5s cubic-bezier(0.19, 1, 0.22, 1); width:50px;  z-index:9;}
.btn-4:hover:after{left:120%; -webkit-transition: all 5s cubic-bezier(0.19, 1, 0.22, 1); transition: all 5s cubic-bezier(0.19, 1, 0.22, 1);}
a.moreKnowSS{max-width:140px; display:block; margin:20px auto 0; background:#f54f36; border-radius:3px; padding:8px 20px; text-decoration:none; font-size:14px; text-transform:uppercase; color:#fff; font-weight:700; font-family: 'Open Sans', sans-serif;}

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {color:#fff; font-weight:400; font-family: 'Open Sans', sans-serif; line-height:1;
                font-size:40px;
                margin-bottom:20px;
            }
			@media (max-width: 767px) {
				.title{font-size:40px;}
			}
        </style>
    </head>
    <body>
    
        <div class="container">
            <div class="content">
                <div class="title">Opps! Something went wrong. It seems You Lost or  We have not found any activity from your side from last sometime so your session is expired because of security reason. </div>
            </div>
        </div>
    </body>
</html>
