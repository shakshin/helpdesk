<?php
class StatController extends Controller {
    function actionBusy() {
        $res = Yii::app()->db->createCommand("
            select
                user.id as id,
                user.name as name,
                (select 
                    count(worker_request.request_id) 
                 from worker_request 
                 where 
                        (worker_request.user_id = id) 
                        and (worker_request.date_end is null)
                ) as rcount,
                if (user.activity > date_sub(now(), interval 3 minute), 1, 0) as active
            from  user
            order by user.name
        ")->query();
        $data = array();
        foreach ($res as $row) {
            if ($row["rcount"] == 0) {
                $row["status"] = "свободен(на)";
            }
            if ($row["rcount"] == 1) {
                $row["status"] = "занят(а)";
            }
            if ($row["rcount"] > 1) {
                $row["status"] = "очень занят(а)";
            }
            if ($row["active"] == 0) {
                $row["status"] = "приложение не запущено";
            }
            $data[] = $row;
        }
        echo json_encode($data);
    }
}
?>
