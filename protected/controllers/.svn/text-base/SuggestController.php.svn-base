<?php
class SuggestController extends Controller {
    function actionFio() {
        $q = preg_replace("/'/", '', $_GET["q"]);
        $data = Yii::app()->db->createCommand("select distinct fio from request where fio like '{$q}%' order by fio")->query();
        foreach ($data as $row) {
            echo $row["fio"]."|".$row["fio"]."\n";
        }
    }
    
    function actionPosition() {
        $q = preg_replace("/'/", '', $_GET["q"]);
        $data = Yii::app()->db->createCommand("select distinct position from request where position like '{$q}%' order by position")->query();
        foreach ($data as $row) {
            echo $row["position"]."|".$row["position"]."\n";
        }
    }
    
    function actionDepartment() {
        $q = preg_replace("/'/", '', $_GET["q"]);
        $data = Yii::app()->db->createCommand("select distinct department from request where department like '{$q}%' order by department")->query();
        foreach ($data as $row) {
            echo $row["department"]."|".$row["department"]."\n";
        }
    }
}
?>
