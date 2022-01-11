<!doctype html>
<html>
<head>
    <title>Absensi Monstergroup</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('style/assets/css/login.css') }}">
    <style>
        .monstergroup img {
            width: 100%;
        }
    </style>
</head>
<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap py-5">
                        <div class="monstergroup">
                            <img src="{{ asset('style/assets/images/logo/monster-group.png') }}" width="40px;" alt="">
                        </div>
						<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/bg.jpg);"></div>
						<h3 class="text-center mb-0">History Attendence</h3>
						<p class="text-center">Welcome</p>
						<form action="{{ url('employee/login') }}" method="post" class="login-form">
                            @csrf
							<div class="form-group">
								<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
								<input name="username" type="text" class="form-control" placeholder="Username" required>
							</div>
							<div class="form-group">
								<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span></div>
								<input name="password" type="password" class="form-control" placeholder="Password" required>
							</div>
							<div class="form-group">
								<button name="submit" type="submit" class="btn form-control btn-primary rounded submit px-3">Login</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="{{ asset('style/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('style/assets/js/popper.js') }}"></script>
	<script src="{{ asset('style/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('style/assets/js/main.js') }}"></script>
</body>
</html>
