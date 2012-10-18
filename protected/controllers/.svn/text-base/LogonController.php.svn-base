<?php
class LogonController extends Controller {
    private $_identity;
    
    public function actionIndex() {
        if($this->_identity===null) {
            $this->_identity=new UserIdentity($_POST["username"],$_POST["password"]);
            $this->_identity->authenticate();
		}
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
			if (empty($_POST['newpassword'])) {
				$user = User::model()->findByAttributes(array("login" => $_POST["username"]));
				if ($user->changepass) { //необходимо сменить пароль
					?> {success: false, errors: { change: "1"} }<?
					return;
				}
			}
			else { // проверяем установку нового пароля
				$user = User::model()->findByAttributes(array("login" => $_POST["username"]));
				$user->changepass = 0;
				$user->password = md5($_POST['newpassword']);
				if ($user->save()) {
				// необходимо снова прогнать авторизацию в системе
					$this->_identity->password=$_POST["newpassword"];
					$this->_identity->authenticate();
				}
				else {
					?> {success: false, errors: { change: "2"} }<?
					return;
				}
			}
			$duration= 3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			echo "{success: true}";
		}
		else {
			echo "{success: false}";
		}
	}
}
?>
