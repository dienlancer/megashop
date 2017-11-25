<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<script src="{{asset('public/admin/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('public/admin/css/bootstrap.min.css'); ?>">
	<script type="text/javascript" language="javascript" src="<?php echo asset('public/admin/js/bootstrap.min.js'); ?>"></script>
	<link href="{{asset('public/admin/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo asset('public/admin/css/joomla.css'); ?>">	
</head>
<body class="site com_login view-login layout-default task- itemid- ">
	<!-- Container -->
	<div class="container">
		<div id="content">
			<!-- Begin Content -->
			<div id="element-box" class="login well">
								
				<div id="system-message-container">
	</div>

				<form action="" method="post" id="form-login" class="form-inline">
					{{ csrf_field() }}				
	<fieldset class="loginform">
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					<span class="add-on">
						<i class="fa fa-user" aria-hidden="true"></i>
						<label for="mod-login-username" class="element-invisible">
							Username						</label>
					</span>					
					<input name="username" tabindex="1" id="mod-login-username" type="text" class="input-medium" placeholder="Username" size="15" autofocus="true" />
					<a href="https://www.google.com.vn" class="btn width-auto hasTooltip" title="Forgot your username?">
						<i class="fa fa-question-circle" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					<span class="add-on">
						<i class="fa fa-lock" aria-hidden="true"></i>
						<label for="mod-login-password" class="element-invisible">
							Password						</label>
					</span>
					<input name="password" tabindex="2" id="mod-login-password" type="password" class="input-medium" placeholder="Password" size="15"/>
					<a href="https://www.google.com.vn" class="btn width-auto hasTooltip" title="Forgot your password?">
						<i class="fa fa-question-circle" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
						<div class="control-group">
			<div class="controls">
				<div class="btn-group">
					<button tabindex="5" type="submit" class="btn btn-primary btn-block btn-large login-button">
						<i class="fa fa-lock" aria-hidden="true"></i> Log in					</button>
				</div>
			</div>
		</div>
		</fieldset>
</form>

			</div>
			<noscript>
				Warning! JavaScript must be enabled for proper operation of the Administrator Backend.			</noscript>
			<!-- End Content -->
		</div>
	</div>
	<div class="navbar navbar-fixed-bottom hidden-phone">
		
		
		<a href="<?php echo url('/'); ?>" target="_blank" class="pull-left"><i class="fa fa-sign-out" aria-hidden="true"></i>Go to site home page</a>
	</div>
	
</body>
</html>