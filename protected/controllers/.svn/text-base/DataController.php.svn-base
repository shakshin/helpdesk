<?php
class DataController extends Controller {
    private function getSubtree($id) {
        $data = array();
        $items = Rtype::model()->findAllByAttributes(array("parent_id" => $id));
        
        foreach ($items as $item) {            
            $children = $this->getSubtree($item->id);
            $idata = array(
                "id" => $item->id,
                "text" => $item->name                
            );
            if (empty($children)) {
                $idata["leaf"] = true;
            } else {
                $idata["leaf"] = false;
                $idata["children"] = $children;
            }
            $data[] = $idata;
        }
        return $data;
    }
    
    function actionRtypes() {
        $data = array();
        $data = $this->getSubtree(null);
        echo json_encode($data);
    }
    
    function actionDeps() {
        $jdata = array();
        $data = Yii::app()->db->createCommand("select distinct department from request order by department")->query();
        while (($row = $data->read()) !==false) {
            $jdata[] = array("dep" => $row["department"]);
        }
        echo json_encode($jdata);
    }
    
    function actionPositions() {
        $jdata = array();
        $data = Yii::app()->db->createCommand("select distinct position from request order by position")->query();
        while (($row = $data->read()) !==false) {
            $jdata[] = array("pos" => $row["position"]);
        }
        echo json_encode($jdata);
    }
    
    function actionFio() {
        $jdata = array();
        $data = Yii::app()->db->createCommand("select distinct fio from request order by fio")->query();
        while (($row = $data->read()) !==false) {
            $jdata[] = array("fio" => $row["fio"]);
        }
        echo json_encode($jdata);
    }
    
    function actionUdata() {
        $rq = VRequest::model()->findByAttributes(array("fio" => $_POST["fio"]), array("order" => "regtime desc"));
        if (empty($rq)) {
            $data = array(
                "phone" => null,
                "pc" => null
            );
        } else {
            $data = $rq->attributes;
        }
        echo json_encode($data);
    }
    
    function actionUsers() {
        $data = array();
        $users = User::model()->findAll(array("order" => "name"));
        foreach ($users as $user) {
            $data[] = $user->attributes;
        }
        $tdata = array(
            "totalCount" => count($data),
            "items" => $data
        );
        echo json_encode($tdata);
    }
    
    function actionCanwork() {
        $a = CommonFunctions::getMyWorkRtypesId();
        $rt = $_POST["rtype"];
        if (array_search($rt, $a) !== false) {
            echo "true";
        } else {
            echo  "false";
        }
    }
    
    function actionSetrtfilter() {
        $rtypes= array();
        $rid = $_POST['id'];
        if ($rid > 0) {
            $todo = array($rid);
            while (!empty($todo)) {
                $rtypes[] = $todo[0];
                $rows = Rtype::model()->findAllByAttributes(array("parent_id" => $todo[0]));
                foreach ($rows as $row) {
                    $todo[] = $row->id;
                }
                unset($todo[0]);
                $todo = array_values($todo);
            }
            Yii::app()->user->setState("rtfilter", array_unique($rtypes));
        } else {
            Yii::app()->user->setState("rtfilter", null);
        }
        echo "{success: true}";
    }

    function actionVersion() {
        echo CommonFunctions::getVersion();
    }
    
    function actionAppinfo() {
        echo json_encode(array(
            "revision" => CommonFunctions::getVersion()
        ));
    }
    
    function actionUinfo() {
        echo json_encode(array(
            "id" => Yii::app()->user->getState('uid'),
            "name" => Yii::app()->user->getId() 
        ));
    }
    
    function actionRmonth() {
        $data = array();
        $res = Yii::app()->db->createCommand("
            select 
                distinct month(date_end) as mnum, year(date_end) as yr, concat(month(date_end),'.',year(date_end)) as `month`
            from worker_request 
            where date_end is not null
            order by date_end
        ")->query();
        $m = array(
            1 => "январь",
            2 => "февраль",
            3 => "март",
            4 => "апрель",
            5 => "май",
            6 => "июнь",
            7 => "июль",
            8 => "август",
            9 => "сентябрь",
            10 => "октябрь",
            11 => "ноябрь",
            12 => "декабрь",
        );
        foreach ($res as $row) {
            $d = array();
            $d["month"] = $row["month"];
            $d["name"] = $m[$row["mnum"]]." ".$row["yr"];
            $data[] = $d;
        }
        echo json_encode(array("totalCount" => count($data), "items" => $data));
    }
    
}
?>
