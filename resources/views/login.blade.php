<html>
<head>
<?php session_start();
 ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ckyc Portal - Login</title>
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
<script src="{{ asset('js/jquery-1.11.3.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<style>
    .visible-lg {
    @media (max-width: @screen-phone-max) {
        .responsive-invisibility();
    }
    &.visible-xs {
        @media (max-width: @screen-phone-max) {
        .responsive-visibility();
        }    
    }
    @media (min-width: @screen-tablet) and (max-width: @screen-tablet-max) {
        .responsive-invisibility();
    }
    &.visible-sm {
        @media (min-width: @screen-tablet) and (max-width: @screen-tablet-max) {
        .responsive-visibility();
        }    
    }
    @media (min-width: @screen-desktop) and (max-width: @screen-desktop-max) {
        .responsive-invisibility();
    }
    &.visible-md {
        @media (min-width: @screen-desktop) and (max-width: @screen-desktop-max) {
        .responsive-visibility();
        }    
    }
    @media (min-width: @screen-large-desktop) {
        .responsive-visibility();
    }
    }
    h5{
        font-size: 1.4em;
    }      
    body {
		font-family: 'Varela Round', sans-serif;
	}
	.modal-login {		
		color: #636363;
		width: 350px;
	}
	.modal-login .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
	}
	.modal-login .modal-header {
		border-bottom: none;   
        position: relative;
        justify-content: center;
	}
	.modal-login h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -15px;
	}
	.modal-login .form-control:focus {
		border-color: #70c5c0;
	}
	.modal-login .form-control, .modal-login .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-login .close {
        position: absolute;
		top: -5px;
		right: -5px;
	}	
	.modal-login .modal-footer {
		background: #ecf0f1;
		border-color: #dee4e7;
		text-align: center;
        justify-content: center;
		margin: 0 -20px -20px;
		border-radius: 5px;
		font-size: 13px;
	}
	.modal-login .modal-footer a {
		color: #999;
	}		
	.modal-login .avatar {
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -70px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #00838f;
		padding: 15px;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.modal-login .avatar img {
		width: 100%;
	}
	.modal-login.modal-dialog {
		margin-top: 80px;
	}
    .modal-login .btn {
        color: #fff;
        border-radius: 4px;
		background: #00838f;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
        border: none;
    }
	.modal-login .btn:hover, .modal-login .btn:focus {
		background: #45aba6;
		outline: none;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$("#logInModal").modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#logInModal').modal('show');
		$("#userId").focus();
		$('#logInBtn').click(function(e) {
			// prevent click action
			e.preventDefault();
			// your code here
			return false;
		});
	});

	function checkNumber(evt){
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}

		return true;
	}

</script>
</head>

<body class="container-fluid">
<style>
body{
    background-color: #607d8b !important;
}
</style>
<input type = "hidden" name = "user" id = "user" value = "">
<div id="logInModal" class="modal">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
            <div class="modal-header">
				<div class="avatar">
					<img src="{{ asset('images/avatar.png')}}" alt="Avatar">
				</div>
				<h4 class="modal-title">APGVB Employee Login</h4>
			</div>
			<div class="modal-body">
				@if (Session::has('error'))
					<div class="note note-info">
						<div class="alert alert-secondary" role="alert">{{ Session::get('error') }}</div>
					</div>
				@endif
				@if ($errors->count() > 0)
					<div class="note note-danger">
						<ul class="list-unstyled">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				@if (Session::has('wrongpwd'))
				<div>
				    <div class="alert alert-danger" role="alert" style="font-size:14px;">{{ Session::get('wrongpwd') }}</div>
				</div>
				@endif
                @if (session('logout'))
                    <div class="alert alert-success"> {{ session('logout') }}</div>
                @endif
                <form class="container-fluid" method = "post" action = "{{route('login')}}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="employee_id" placeholder="Employee Id" required="required" id = "employee_id" onkeypress = "return checkNumber(event)" maxlength = "5">		
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Vikas net Password" required="required" id = "password">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary btn-lg btn-block login-btn" type = "submit" value = "Login"></span>
                    </div>
                </form>
				<span class = "pull-right"><a href = 'http://10.64.1.121:100/ForGotPwd.aspx'target="_blank" style = 'color:#ff3e00'>Forgot Password?</a></span><br>
			</div>
		</div>
	</div>
</div>

</body>
</html>
