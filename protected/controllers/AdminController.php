<?php

class AdminController extends Controller {
    function actionUsers() {
        $data = array();
        $rows = User::model()->findAll(array("order" => "name"));
        foreach ($rows as $row) {
            $data[] = $row->attributes;
        }
        echo json_encode(array("totalCount" => count($data), "items" => $data));
    }
    
    function actionGetuser() {
        $user = User::model()->findByAttributes(array("id" => $_POST["id"]));
        echo json_encode($user->attributes);
    }
    
    function actionGetgroup() {
        $group = Group::model()->findByAttributes(array("id" => $_POST["id"]));
        echo json_encode($group->attributes);        
    }
    
    function actionSaveuser() {
        $user = User::model()->findByAttributes(array("id" => $_POST["id"]));
        if ($user === null) {
            echo "{success: false}";
            return;
        }
        $user->login = $_POST["login"];
        $user->name = $_POST["name"];
        $user->position = $_POST["position"];
        $user->email = $_POST["email"];
        $user->jabber = $_POST["jabber"];
        $user->razr = $_POST["razr"];
        $user->number = $_POST["number"];
        
        if (!empty($_POST["password"])) {
            $user->password = md5($_POST["password"]);
        }
        if (!empty($_POST["changepass"])) {
            $user->changepass = 1;
        }
        $user->save();
        echo "{success: true}";
    }
    
    function actionSavegroup() {
        $group = Group::model()->findByAttributes(array("id" =>$_POST["id"]));
        if ($group === null) {
            echo "{success: false}";
            return;
        }
        $group->attributes = $_POST;
        $group->save();
        echo "{success: true}";
    }
    
    function actionUserGroups() {
        $data = array();
        $rows = VGroup::model()->findAllByAttributes(array("uid" => $_GET["uid"]), array("order" => "gname"));
        foreach ($rows as $row) {
            $data[] = $row->attributes;
        }
        echo json_encode(array("totalCount" => count($data), "items" => $data));
    }
    
    function actionGroupUsers() {
        $data = array();
        $rows = VGroup::model()->findAllByAttributes(array("gid" => $_GET["gid"]), array("order" => "uname"));
        foreach ($rows as $row) {
            $data[] = $row->attributes;
        }
        echo json_encode(array("totalCount" => count($data), "items" => $data));
    }
    
    function actionChgroup() {
        $ug = User_group::model()->findByAttributes(array("user_id" => $_POST["uid"], "group_id" => $_POST["gid"]));
        if ($ug === null) {
            $ug = new User_group();
            $ug->user_id = $_POST["uid"];
            $ug->group_id = $_POST["gid"];
            $ug->save();
        } else {
            $ug->delete();
        }
        echo "{success: true}";
    }
    
    function actionGroups() {
        $data = array();
        $rows = Group::model()->findAll(array("order" => "groupname"));
        foreach ($rows as $row) {
            $data[] = $row->attributes;
        }
        echo json_encode(array("totalCount" => count($data), "items" => $data));
    }
    
    function actionCreateUser() {
        $user = new User();
        $user->attributes = $_POST;
        $user->password = md5($_POST["password"]);
        $user->changepass = 1;
        $user->save();
        
        echo "{success: true, uid: {$user->id}}";
    }
    
    function actionCreategroup() {
        $group = new Group();
        $group->attributes = $_POST;
        $group->save();
        echo "{success: true, gid: {$group->id}}";
    }
    
    function actionCreatertype() {
        $rt = new Rtype();
        $rt->attributes = $_POST;
        if ($rt->parent_id == 0) { $rt->parent_id = null; }
        if ($rt->norma == 0) { $rt->norma = null; }
        $rt->save();
        echo "{success: true, id: {$rt->id}}";
    }
    
    function actionGetrtype() {
        $rt = Rtype::model()->findByAttributes(array("id" => $_POST["id"]));
        if (empty($rt)) {
            echo "{id: null}";
            return;
        }
        $data = $rt->attributes;
        echo json_encode($data);
    }
    
    function actionSavertype() {
        $rt = Rtype::model()->findByAttributes(array("id" => $_POST["id"]));
        if (empty($rt)) {
            echo "{success: false}";
            return;
        }
        $rt->attributes = $_POST;
        if ($rt->norma == 0) { $rt->norma = null; }
        if ($rt->save()) {
            echo "{success: true}";
        } else {
            echo "{success: false}";
        }
    }
    
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
                $idata["leaf"] = false;
                $idata["has_children"] = false;
                $idata["children"] = array();
            } else {
                $idata["leaf"] = false;
                $idata["has_children"] = true;
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
    
    function actionMovert() {
        $rt = Rtype::model()->findByAttributes(array("id" => $_POST["id"]));
        if (empty($rt)) {
            throw new CException();
            return;
        }
        $rt->parent_id = empty($_POST["parent"]) ? null : $_POST["parent"]  ;
        $rt->save();
        echo "{success: true}";
    }
    
}
?>
