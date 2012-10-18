<? 
class GuiController extends Controller {
    // массив id админов
    private $admins = array(
        1, // Шакшин С.В.
        2  // Трофимов В.А.
    );
    
    
    function actionIndex() {
	if (Yii::app()->user->isGuest) {
	    return $this->actionLogon();
	} else {
	    return $this->actionWork();
	}
    }
    
    function actionLogon() {
	$this->layout = "gui-basic";
	$this->render("login");
    }
    
    function actionWork() {
        if (Yii::app()->user->isGuest) {
	    return $this->actionLogon();
	}
	$this->layout = "gui-basic";
	$this->render("gui");	
    }
    
    function actionAdmin() {
        if (Yii::app()->user->isGuest) {
	    return $this->actionLogon();
	} else {
	    if (array_search(Yii::app()->user->uid, $this->admins) !== false) {
                $this->layout = "gui-basic";
                $this->render("admin");
            } else {
                return $this->actionWork();
            }
	}
        
    }
}
?>