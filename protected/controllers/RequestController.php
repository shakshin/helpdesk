<?php

class RequestController extends Controller {
    function actionCreate() {
        $rq = new UserRequest;
        $rq->atl_lastuser = Yii::app()->user->uid;
        $rq->atl_lastdatetime = date("Y-m-d H:i:s");
        $rq->type_request_id = $_POST["rtype"];
        $rq->request_datetime = date("Y-m-d H:i:s");
        $rq->who_ip = $_SERVER["REMOTE_ADDR"];
        $rq->request_user_id = Yii::app()->user->uid;
        $rq->department = $_POST["department"];
        $rq->position = $_POST["position"];
        $rq->fio = $_POST["fio"];
        $rq->phone = $_POST["phone"];
        $rq->pc = $_POST["pc"];
        $rq->description = $_POST["description"];
        if ($rq->save()) {       
            $msg = 
"В системе создана новая заявка (№{$rq->id}):
    Пользователь: {$rq->fio}
    Подразделение: {$rq->department}
    Должность: {$rq->position}
    Описание заявки: {$rq->description}";
                     
            if (!empty($_POST["worker"])) {
                if (!CommonFunctions::takeRequest($rq->id)) {
                    echo "{success: false}";
                    return;
                }
                $u = User::model()->findByAttributes(array("id" => Yii::app()->user->uid));
                $msg .= "\nЗаявке назначен исполнитель: {$u->name}";
            }
            echo "{success: true}";
            CommonFunctions::sendNotify($rq->id,  $msg);
        } else {
            
            echo "{success: false},{errors: ";
            foreach ($rq->getErrors() as $at => $msg) {
                echo "{$at}: \"{$msg}\"";
            }
            echo "}";
        }
    }
    function actionOpen() {
        $data = array();
        $rtfilter = Yii::app()->user->getState("rtfilter") == null 
                ? CommonFunctions::getMyViewRtypesId() 
                : array_intersect(CommonFunctions::getMyViewRtypesId(), Yii::app()->user->getState("rtfilter"));
        $rtfilter = array_values($rtfilter);
        $rows = VRequestOpen::model()->findAllByAttributes(array("wcount" => 0, "rtype_id" => $rtfilter));
        foreach ($rows as $row) {
            $data[] = $row->attributes;
        }
        $tdata = array(
            "totalCount" => count($data),
            "items" => $data
        );
        echo json_encode($tdata);
    }
    
    function actionMy() {
        $id = Yii::app()->user->uid;
        Yii::app()->db->createCommand("update user set activity=now() where id = {$id}")->query();
        $data = array();
        $filter = array("closed" => 0, "worker_id" => Yii::app()->user->uid, "date_end" => null);
        if (Yii::app()->user->getState("rtfilter") != null) {
            $filter["rtype_id"] = Yii::app()->user->getState("rtfilter");
        }
        $rows = VRequestWork::model()->findAllByAttributes($filter);
        foreach ($rows as $row) {
            $data[] = $row->attributes;
        }
        $tdata = array(
            "totalCount" => count($data),
            "items" => $data
        );
        echo json_encode($tdata);
    }
    
    function actionWork() {
        $data = array();
        $filter = array("closed" => 0);
        if (Yii::app()->user->getState("rtfilter") != null) {
            $filter["rtype_id"] = Yii::app()->user->getState("rtfilter");
        }
        $rows = VRequestWork::model()->findAllByAttributes($filter);
        foreach ($rows as $row) {
            $subdata = $row->attributes;
            $ws = VWorker::model()->findAllByAttributes(array("request_id" => $row->id));
            $wks = array();
            if (!empty($ws)) {
                foreach ($ws as $w) {
                    $wks[] = $w->name;
                }
            }
            $subdata["workers"] = implode(", ", $wks);
            $data[] = $subdata;
        }
        $tdata = array(
            "totalCount" => count($data),
            "items" => $data
        );
        echo json_encode($tdata);
    }
    
    function actionComplete() {
        $data = array();
        $filter = array("closed" => 1);
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition($filter);
        if (Yii::app()->user->getState("rtfilter") != null) {
            $criteria->addInCondition("rtype_id", Yii::app()->user->getState("rtfilter"));
        }
        
        
        $advfilter = Yii::app()->user->getState("advfilter");
        switch ($advfilter["date"]) {
            case 1: 
                $criteria->addCondition("(DATE(regtime) = DATE(NOW())) OR (DATE(date_end) = DATE(NOW())) ");
                break;
            case 2:
                $criteria->addCondition("((WEEK(regtime) = WEEK(NOW())) AND (YEAR(regtime) = YEAR(NOW()))) OR (WEEK(date_end) = WEEK(NOW())) AND (YEAR(date_end) = YEAR(NOW()))" );
                break;
            case 3:
                $criteria->addCondition("((MONTH(regtime) = MONTH(NOW())) AND (YEAR(regtime) = YEAR(NOW()))) OR (MONTH(date_end) = MONTH(NOW())) AND (YEAR(date_end) = YEAR(NOW()))");
                break;
            case 4:
                $criteria->addCondition("((month(regtime) = month(date_sub(now(), interval 1 month))) AND (year(regtime) = year(date_sub(now(), interval 1 month)))) or (month(date_end) = month(date_sub(now(), interval 1 month))) AND (year(date_end) = year(date_sub(now(), interval 1 month)))");
                break;
        }
        
        $rows = VRequest::model()->findAll($criteria);
        foreach ($rows as $row) {
            $subdata = $row->attributes;
            $ws = VWorker::model()->findAllByAttributes(array("request_id" => $row->id));
            $wks = array();
            $iwks = array();
            if (!empty($ws)) {
                foreach ($ws as $w) {
                    $wks[] = $w->name;
                    $iwks[] = $w->uid;
                }
            }
            $subdata["workers"] = implode(", ", $wks);
            if (!empty($advfilter['worker']) && array_search($advfilter['worker'], $iwks) === false) {
                
            } else {
                $data[] = $subdata;
            }
        }
        $tdata = array(
            "totalCount" => count($data),
            "items" => $data
        );
        echo json_encode($tdata);
    }
    
    function actionDetails() {
        $data = array();
        $rq = VRequest::model()->findByAttributes(array("id" => $_POST["id"]));
        $al = CommonFunctions::getAccessLevel($_POST["id"]);
        $data = $rq->attributes;
        
        $data["isWorker"] = CommonFunctions::isWorker($_POST["id"]);
        $data["alView"] = ($al >= AL_VIEW);
        $data["alWork"] = ($al >= AL_WORK);
        $data["alFull"] = ($al == AL_FULL);
        $data["isClosed"] = ($rq->closed > 0);
        
        $u = User::model()->findByAttributes(array("id" => $data["uuser"]));
        $data["uuser"] = $u->name;
        $w = Worker::model()->findByAttributes(array("request_id" => $_POST["id"], "user_id" => Yii::app()->user->uid));
        $data["comment"] = empty($w) ? "" : $w->comment;
        $data["comments"] = "";
        $ws = Worker::model()->findAllByAttributes(array("request_id" => $_POST["id"]));
        foreach ($ws as $w) {
            if (!empty($w["comment"])) {
                $u = User::model()->findByAttributes(array("id" => $w["user_id"]));
                $data["comments"] .= "<strong>{$u["name"]}</strong>:<br/>".preg_replace("/\n/","<br/>",$w["comment"])."<br/><hr/>";
            }
        }
        
        
        echo json_encode($data);
    }
    
    function actionWorkers() {
        $data = array();
        $wk = Worker::model()->findAllByAttributes(array("request_id" => $_GET["id"]));
        foreach ($wk as $w) {
            $u = User::model()->findByAttributes(array("id" => $w->user_id));
            $data[] = array(
                "id" => $w->user_id,
                "name" => $u->name,
                "date_end" => $w->date_end,
                "date_begin" => $w->date_begin,
                "status" => empty($w->date_end) ? "в работе" : "выполнено"
            );
            
        }
        $tdata = array(
            "totalCount" => count($data),
            "items" => $data
        );
        echo json_encode($tdata);
    }
    
    function actionApplyworker() {
        $w = Worker::model()->findByAttributes(array("request_id" => $_POST['request'], "user_id" => $_POST['worker']));
        if (empty($w)) {
            $w = new Worker;
            $w->date_begin = date("Y-m-d H:i:s");
            $w->request_id = $_POST['request'];
            $w->user_id = $_POST['worker'];
            if ($w->save()) {
                $u = User::model()->findByAttributes(array("id" => $w->user_id));
                CommonFunctions::sendNotify($w->request_id, "Заявке №{$w->request_id} назначен (со)исполнитель: {$u->name}");
            }
        } else {
            $w->date_end = null;
            if ($w->save()) {
                $u = User::model()->findByAttributes(array("id" => $w->user_id));
                CommonFunctions::sendNotify($w->request_id, "Заявка №{$w->request_id} повторно отдана на исполнение сотруднику: {$u->name}");
            }
        }
    }
    
    function actionDeleteworker() {
        $w = Worker::model()->findByAttributes(array("request_id" => $_POST['request'], "user_id" => $_POST['worker']));
        $w->delete();
        $u = User::model()->findByAttributes(array("id" => $_POST['worker']));
        CommonFunctions::sendNotify($w->request_id, "С заявки №{$w->request_id} снят (со)исполнитель: {$u->name}");
        $w = Worker::model()->findAllByAttributes(array("request_id" => $_POST["request"]));
        if (empty($w)) {
            echo "{success: true}";
            return;
        }
        $w = Worker::model()->findAllByAttributes(array("request_id" => $_POST["request"], "date_end" => null));
        var_dump($w);
        if (empty($w)) {
            $rq = UserRequest::model()->findByAttributes(array("id" => $_POST["request"]));
            if (empty($rq)) {
                echo "{success: false}";
                return;
            }
            $rq->closed = 1;
            $rq->date_end = date("Y-m-d H:i:s");
            if (!$rq->save()) {
                echo "{success: false}";
                return;
            }            
        }
        echo "{success: true}";
    }
    
    function actionSave()  {
        $notice = array();
        $rq = UserRequest::model()->findByAttributes(array("id" => $_POST["id"]));
        $old = $rq->attributes;
        $rq->attributes = $_POST;
        $diff = array_diff_assoc($old, $rq->attributes);
        if (!empty($diff)) {
            $rq->atl_lastdatetime = date("Y-m-d H:i:s");
            $rq->atl_lastuser = Yii::app()->user->uid;
            if (!$rq->save()) {
                echo "{success: false}";
                return;
            }
            $notice[] = "    Обновлены данные";
        }
        
        if (CommonFunctions::isWorker($_POST["id"])) {
            $w = Worker::model()->findByAttributes(array("request_id" => $_POST["id"], "user_id" => Yii::app()->user->uid));
            if ($w->comment !== $_POST["comment"]) {
                $w->comment = $_POST["comment"];
                if (!$w->save()) {
                    echo "{success: false}";
                    return;
                }
                $notice[] = "    Обновлен или добавлен комментарий";
            }
        }
        $u = User::model()->findByAttributes(array("id" => Yii::app()->user->uid));
        $n = implode("\n", $notice);
/*        CommonFunctions::sendNotify($rq->id, 
                "В заявке №{$rq->id} зафиксированы следующие изменения:\n{$n}\nИзменения внес сотрудник: {$u->name}"
        ); */
        echo "{success: true}";
    }
    
    function actionTake() {
        if (CommonFunctions::takeRequest($_POST["id"])) {
            $u = User::model()->findByAttributes(array("id" => Yii::app()->user->uid));
            CommonFunctions::sendNotify($_POST["id"], "Заявка №{$_POST["id"]} взята в работу сотрудником {$u->name}");
            echo "{success: true}";
            return;
        } else {
            echo "{success: false}";
            return;
        }
            
    }
    
    function actionClose() {
        if (!CommonFunctions::releaseRequest($_POST["id"])) {
            echo "{success: false}";
            return;
        }
        $rq = null;
        $w = Worker::model()->findAllByAttributes(array("request_id" => $_POST["id"], "date_end" => null));
        if (empty($w)) {
            $rq = UserRequest::model()->findByAttributes(array("id" => $_POST["id"]));
            if (empty($rq)) {
                echo "{success: false}";
                return;
            }
            $rq->closed = 1;
            $rq->date_end = date("Y-m-d H:i:s");
            if (!$rq->save()) {
                echo "{success: false}";
                return;
            }            
        }
        $u = User::model()->findByAttributes(array("id" => Yii::app()->user->uid));
        CommonFunctions::sendNotify($rq->id, "Заявка №{$rq->id} выполнена и закрыта сотрудником {$u->name}");
        echo "{success: true}";
        return;
    }
    
    function actionRelease() {
        if (!CommonFunctions::releaseRequest($_POST["id"])) {
            echo "{success: false}";
            return;
        }
        CommonFunctions::sendNotify($_POST["id"], "Заявка №{$_POST["id"]} вернулась в очередь открытых заявок");
        echo "{success: true}";
        return;
    }
	
    /*
     *  дополнительное оповещение о работе
     */
    function actionForcework() {
        CommonFunctions::sendNotify($_POST["id"], "Начните отрабатывать!\nЛибо доложите о причине задержки исполнения.",1);
        echo "{success: true}";
        return;
    }
    
    function actionSetfilter() {
        $filter = array(
            "worker" => null,
            "date" => 1
        );
        if (!empty($_POST["worker"])) {
            $filter["worker"] = $_POST["worker"];
        }
        $filter["date"] = $_POST["date"];
        Yii::app()->user->setState("advfilter", $filter);
        echo "{success: true}";
    }

}
?>
