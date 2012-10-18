<?php
class TestController extends Controller {

	function actionIndex() {
        
		//$data = CommonFunctions::getGroupNotifyByRId(1);
		//$data = CommonFunctions::getUserByGroupId(7);
        $data = CommonFunctions::sendNotify(28, '<b>ВНИМАНИЕ</b><br>это тест');
		//echo "<pre>"; var_dump($data); echo "</pre>";
		
    }
    function actionTest2() {
        var_dump(Yii::app()->user->getState("rtfilter"));
    }
    
    
}
?>
