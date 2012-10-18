<?php

class ReportController extends Controller {
    function actionIndex() {
        return $this->actionMonthReport();
    }
    
    function actionMonthReport() {
        $uid = Yii::app()->user->getState('uid');
        $period = explode(".", $_GET["month"]);
        $m = $period[0];
        $y = $period[1];
        $mths = array(
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
        $u = User::model()->findByAttributes(array("id" => Yii::app()->user->getState('uid')));
        $res = Yii::app()->db->createCommand("
            select 
                rtype, 
                rtype_name, 
                count(id) as cnt, 
                round(sum(wtime)/60, 1) as wt 
            from v_works 
            where 
                uid={$uid} and ((month(date_end) = {$m} and year(date_end) = {$y}) or (month(date_begin) = {$m} and year(date_begin) = {$y}))
            group by rtype, rtype_name
            order by rtype_name
        ")->query();
        $t = 0;
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache"/>
	<meta name="language" content="ru" />
        <title>Отчет (<?=$mths[$m] ?> <?=$y ?>)</title>
        <style>
            table {
                border: 1px solid black;
                border-collapse: collapse;
                width: 100%
            }
            td, th {
                border: 1px solid black;
                padding-left: 5px;
                padding-right: 5px;
            }
            .header {
                background: #c1c1c1;
                font-weight: bold;
                text-align: center
            }
            .column-header th {
                font-weight: bold;
                text-align: center
            }
            .data-string {
                text-align: left
            }
            .data-number {
                text-align: right
            }
            .total-string {
                text-align: center
            }
            .total-number {
                text-align: right
            }
            .total {
                background: #c1c1c1;
                font-weight: bold;
            }
        </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td colspan="11" class="header">Группа по развитию и сопровождению ИС ЗАО "МРК"</td>
            </tr>
            <tr class="column-header">
                <th>№ п/п</th>
                <th>Должность</th>
                <th>Личн. №</th>
                <th>Фамилия, Имя, Отчество</th>
                <th>Разряд оплаты</th>
                <th>Заказчик</th>
                <th>Наименование работ</th>
                <th>Количество</th>
                <th>Сложность</th>
                <th>Трудозатраты по видам работ (чел/час)</th>
                <th>Описание работ</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($res as $row) { ?>
            <tr>
                <td>&nbsp;</td>
                <td><?= $t==0 ? $u->position : "" ?></td>
                <td><?= $t==0 ? $u->number : "" ?></td>
                <td><?= $t==0 ? $u->name : "" ?></td>
                <td class="data-number"><?= $t==0 ? $u->razr : "" ?></td>
                <td>&nbsp;</td>
                <td class="data-string"><?=$row["rtype_name"] ?></td>
                <td class="data-number"><?=$row["cnt"] ?></td>
                <td>&nbsp;</td>
                <td class="data-number"><?=$row["wt"] ?></td>
                <td>&nbsp;</td>
            </tr>
            <? $t += $row["wt"]; }?>
            <tr class="total">
                <td class="total-string" colspan="9"><?=$u->name ?></td>
                <td class="total-number"><?=$t ?></td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

        <?
    }
}
?>
