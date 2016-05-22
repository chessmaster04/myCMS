<div class="panel panel-default animation scale-in">
	<div class="panel-body">
		<div class="page-header">
			<h3>Вход</h3>
		</div>
		<form class="form-horisontal validate-form" method="post" action="/controlpage/login">
			<input type="hidden" name="time" value="<?=time()?>" required readonly>
			<input type="hidden" name="ip" value="<?=$_SERVER["REMOTE_ADDR"]?>" required readonly>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Login: </span>
					<input type="text" class="form-control validate-item" name="login" value="" required placeholder="Введите логин" pattern="^[а-яА-ЯёЁa-zA-Z][а-яА-ЯёЁa-zA-Z0-9_ -]{2,28}[а-яА-ЯёЁa-zA-Z0-9]$" maxlength="30">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Password: </span>
					<input type="password" class="form-control validate-item" name="pass" value="" required placeholder="Введите пароль" pattern="^[\w_]{4,20}$" maxlength="20">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Image: </span>
					<div style="
						#border:1px solid black;
						box-shadow:inset 0px 0px 3px #888;
						padding:3px;
						border-top-right-radius:5px;
						border-bottom-right-radius:5px;
					">
					<img style="
						display:block;
						margin:0px auto;
						#border:5px solid #EEEEEE;
						#border-radius:20px;
						
					" src="/components/img/adminka/capchaLogIn.php">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Capcha: </span>
					<input type="text" class="form-control" name="capcha" value="" required placeholder="Введите то, что вы видите на картинке" maxlength="5" pattern="^\d{4,5}$">
				</div>
			</div>
			<button type="submit" class="btn btn-default btn-block validate-submit"><i class="fa fa-sign-in"></i> Войти</button>
		</form>
	</div>
</div>