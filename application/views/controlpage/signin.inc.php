<div class="panel panel-default animation scale-in">
	<div class="panel-body">
		<div class="page-header">
			<h3>Регистрация</h3>
		</div>
		<form class="form-horisontal validate-form" method="post" action="/controlpage/signin/1">
			<input type="hidden" name="time" value="<?=time()?>" required readonly>
			<input type="hidden" name="ip" value="<?=$_SERVER["REMOTE_ADDR"]?>" required readonly>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Login: </span>
					<input type="text" class="form-control" name="login" value="" required placeholder="Придумайте логин" pattern="^[а-яА-ЯёЁa-zA-Z][а-яА-ЯёЁa-zA-Z0-9_ -]{2,28}[а-яА-ЯёЁa-zA-Z0-9]$"  maxlength="30">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Password: </span>
					<input type="password" class="form-control" id="inputPassword3" name="pass1" value="" required placeholder="Придумайте пароль" pattern="^.{4,20}$" maxlength="20">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Password: </span>
					<input type="password" class="form-control" id="inputPassword3" name="pass2" value="" required placeholder="Повторите пароль" pattern="^.{4,20}$" maxlength="20">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 input-group">
					<span class="input-group-addon" style="width:100px;text-align:right;">Key: </span>
					<input type="text" class="form-control" id="inputPassword3" name="key" value="" required placeholder="ХХХХ-ХХХХ-ХХХХ-ХХХХ" pattern="^[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}$" maxlength="19">
				</div>
			</div>
			<button type="submit" class="btn btn-default btn-block checkSubmit">Зарегистрироватся</button>
		</form>
	</div>
</div>