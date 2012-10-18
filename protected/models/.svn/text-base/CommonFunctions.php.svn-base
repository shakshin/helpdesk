<?
define("AL_FULL", 3);
define("AL_WORK", 2);
define("AL_VIEW", 1);
define("AL_NONE", 0);

/*
 * Для написания и использования функций, доступных из любого места приложения
 * 
 */

class CommonFunctions {
	
	/**
	 * 
	 * функция, которая выдает по id пользователя группы
	 * 
	 * @param string id если не указан, то считается на пользователя, который авторизован в системе, если == 'ALL' значит вывести всех
	 * @return array позвращает набор групп пользователя(лей) следующего формата
	 *		array (user_id => array (
	 *								login => "login", groups => array(
	 *										group_id => groupname
	 *										)
	 *							)
	 *		)
	 */
	public function getGroupUserByID ($user_id = NULL) {
		
		$data = array();
		
		if ( Yii::app()->user->isGuest ) return $data;
		
		if (empty($user_id)) $user_id = Yii::app()->user->uid;
		
		if (strtoupper($user_id) === 'ALL')
			$rezult = VUserGroup::model()->findAll();
		else
			$rezult = VUserGroup::model()->findAllByAttributes(array('user_id' => $user_id));
		
		foreach ($rezult as $key=>$value) {
			if (!empty($data[$value->user_id]))
				$data[$value->user_id]['groups'][$value->group_id] = $value->groupname;
			else
				$data[$value->user_id] = array('login' => $value->login, 'groups' => array($value->group_id => $value->groupname));
		}
		return $data;
	}

	/**
	 *
	 * получаем в массиве всех пользователей, принадлежащих этой группе
	 * array(
	 *			user_id1, user_id2 )
	 * 
	 * @param type $id код группы
	 * @return array (user_id1, user_id2 ....)
	 */
	public function getUserByGroupId ($id) {
		$data = array();
		$rows = VUserGroup::model()->findAllByAttributes(array("group_id" => $id));
		foreach ($rows as $row)
			$data[] = $row->user_id;
		return array_unique($data);
	}
	
	   /**
         * Функция возвращает список id групп, в которых текущий пользователь состоит
         * @return array
         */
        public function getMyGroupsId() {
            $data = array();
            if ( Yii::app()->user->isGuest ) return $data;
            $r = VUserGroup::model()->findAllByAttributes(array('user_id' => Yii::app()->user->uid));
            foreach ($r as $grec) {
                $data[] =$grec->group_id;
            }
            return $data;
        }
        
        
        /**
         * Функция возвращает списк id типов заявок, к которым текущий пользователь имее полный доступ
         * @return array 
         */
        public function getMyFullRtypesId() {
            $data = array();
            if ( Yii::app()->user->isGuest ) return $data;
            $todo = array();
            $rows = Rtype::model()->findAllByAttributes(array("group_full" => self::getMyGroupsId()));
            foreach ($rows as $row) {
                $data[] = $row->id;
                $todo[] = $row->id;
            }
            while (!empty($todo)) {
                $rows = Rtype::model()->findAllByAttributes(array("parent_id" => $todo[0]));
                foreach ($rows as $row) {
                    $data[] = $row->id;
                    $todo[] = $row->id;
                }
                unset($todo[0]);
                $todo = array_values($todo);
            }
            return array_unique($data);
        }
        
        /**
         * Функция возвращает списк id типов заявок, которые текущий пользователь может брать в работу
         * @return array 
         */
        public function getMyWorkRtypesId() {
            $data = array();
            if ( Yii::app()->user->isGuest ) return $data;
            $todo = array();
            $rows = Rtype::model()->findAllByAttributes(array("group_full" => self::getMyGroupsId()));
            foreach ($rows as $row) {
                $data[] = $row->id;
                $todo[] = $row->id;
            }
            $rows = Rtype::model()->findAllByAttributes(array("group_work" => self::getMyGroupsId()));
            foreach ($rows as $row) {
                $data[] = $row->id;
                $todo[] = $row->id;
            }
            while (!empty($todo)) {
                $rows = Rtype::model()->findAllByAttributes(array("parent_id" => $todo[0]));
                foreach ($rows as $row) {
                    $data[] = $row->id;
                    $todo[] = $row->id;
                }
                unset($todo[0]);
                $todo = array_values($todo);
            }
            return array_unique($data);
        }
        
        /**
         * Функция возвращает списк id типов заявок, которые текущий пользователь может просматривать
         * @return array 
         */
        public function getMyViewRtypesId() {
            $data = array();
            if ( Yii::app()->user->isGuest ) return $data;
            $todo = array();
            $rows = Rtype::model()->findAllByAttributes(array("group_full" => self::getMyGroupsId()));
            foreach ($rows as $row) {
                $data[] = $row->id;
                $todo[] = $row->id;
            }
            $rows = Rtype::model()->findAllByAttributes(array("group_work" => self::getMyGroupsId()));
            foreach ($rows as $row) {
                $data[] = $row->id;
                $todo[] = $row->id;
            }
            $rows = Rtype::model()->findAllByAttributes(array("group_view" => self::getMyGroupsId()));
            foreach ($rows as $row) {
                $data[] = $row->id;
                $todo[] = $row->id;
            }
            while (!empty($todo)) {
                $rows = Rtype::model()->findAllByAttributes(array("parent_id" => $todo[0]));
                foreach ($rows as $row) {
                    $data[] = $row->id;
                    $todo[] = $row->id;
                }
                unset($todo[0]);
                $todo = array_values($todo);
            }
            return array_unique($data);
        }
        
        public function takeRequest($rqId) {
            $w = Worker::model()->findByAttributes(array("user_id" => Yii::app()->user->uid, "request_id" => $rqId));
            if (empty($w)) {
                $w = new Worker;
                $w->request_id = $rqId;
                $w->user_id = Yii::app()->user->uid;
                $w->date_begin = date("Y-m-d H:i:s");
                return $w->save();
            } else {
                $w->date_end = null;
                return $w->save();
            }
        }
		
		/**
		 * функция, по ID заявке возвращает в массиве список групп, которые указаны как Notify
		 * пробегаясь по дереву вверх 
		 * 
		 * @param integer $rid ID заявки
		 * @return array  массив group_notify (group_id1, group_id2 ...)
		 */
		public function getGroupNotifyByRId($rid) {
			$data = array();
			$rows = VRequest::model()->findByAttributes(array("id" => $rid));
			if (empty($rows)) return $data;
			$rows = Rtype::model()->findByAttributes(array("id" => $rows->rtype_id));
			if (!empty($rows->group_notify))
				$data[] = $rows->group_notify;
			while (!empty($rows->parent_id)) {
				$rows = Rtype::model()->findByAttributes(array("id" => $rows->parent_id));
				if (!empty($rows->group_notify))
					$data[] = $rows->group_notify;
			}
			return array_unique($data);
		}

				/**
		 * функция, по ID заявке возвращает в массиве список групп, которые указаны как Notify
		 * пробегаясь по дереву вверх 
		 * 
		 * @param integer $rid ID заявки
		 * @return array  массив group_work (group_id1, group_id2 ...)
		 */
		public function getGroupWorkByRId($rid) {
			$data = array();
			$rows = VRequest::model()->findByAttributes(array("id" => $rid));
			if (empty($rows)) return $data;
			$rows = Rtype::model()->findByAttributes(array("id" => $rows->rtype_id));
			if (!empty($rows->group_work))
					$data[] = $rows->group_work;
			while (!empty($rows->parent_id)) {
				$rows = Rtype::model()->findByAttributes(array("id" => $rows->parent_id));
				if (!empty($rows->group_work))
					$data[] = $rows->group_work;
			}
			return array_unique($data);
		}

		
		/**
		 * отправка сообщения по типу заявки
		 * 
		 * @param int $rid id заявки
		 * @param string $message само сообщение
		 * @param int $whom кому посылать, NULL как обычно, 1 - послать только тем, кто работает по этой заявке
		 */
		public function sendNotify($rid, $message, $whom = 0) {
			$data = array();
			// получаем тип заявки
			$rows = VRequest::model()->findByAttributes(array("id" => $rid));
			if (!empty($rows)) 
				$data[] = '-'.$rows->rtype."\r\n"; //добавляем тип заявки в сообщение
			else return; //нет заявки с таким Id
			$rows = Rtype::model()->findByAttributes(array("id" => $rows->rtype_id));
			while (!empty($rows->parent_id)) {
				$rows = Rtype::model()->findByAttributes(array("id" => $rows->parent_id));					
				if (!empty($rows->name))
					$data[] = '-'.$rows->name.",\r\n";
			}
			for ($i = 0; $i< count($data); $i++)
				$message = str_repeat(' ', (count($data)-$i)*3).$data[$i].$message;
				// $message = preg_replace("/\"/", "\\\"", $message);
			
			$data = array();
			if (!$whom) {
				$groups = self::getGroupNotifyByRId($rid);
				foreach($groups as $group)
					$data[] = $group;
				$groups = self::getGroupWorkByRId($rid);
				foreach($groups as $group)
					$data[] = $group;
			/*
			 * получили список всех групп, которым надо разослать, теперь необходимо добраться
			 * до пользователей этих групп
			 */
				$groups = array_unique($data);
				$data = array();
				foreach ($groups as $group_id) {
					$users = self::getUserByGroupId($group_id);
					foreach ($users as $user_id)
						$data[] = $user_id;
				}
		// теперь необходимо еще проверить таблицу work_request (model Worker)
			}
			
			$users = Worker::model()->findAllByAttributes(array("request_id" => $rid));
			foreach ($users as $user)
				$data[] = $user->user_id;
			// добавляем себя в список рассылки
			$data[] = Yii::app()->user->uid;
			$users = array_unique($data);

			if (empty($users)) return;
						
			/*
			 * Заполняем таблицу notify
			 */
			$message = "Заявка № ".$rid."\r\n".$message;
			foreach ($users as $user_id) {
				$user = User::model()->findByAttributes(array("id" => $user_id));
				$n = new Notify;
				$n->request_id = $rid;
				$n->user_id = $user_id;
//				$n->message = "Уважаемый(я) ".$user->name."\r\n".$message;
				if ($whom == 1)
					$n->message = '(Со)исполнитель: '.$user->name."\r\n".$message;
				else 
					$n->message = $message;
				$n->save();
			}
		}
                
                public function releaseRequest($id) {
                    $w = Worker::model()->findByAttributes(array("request_id" => $id, "user_id" => Yii::app()->user->uid));
                    $w->date_end = date("Y-m-d H:i:s");
                    return $w->save();
                }
                
                public function isWorker($id) {
                    $w = Worker::model()->findByAttributes(array("request_id" => $id, "user_id" => Yii::app()->user->uid));
                    if (empty($w)) {
                        return false;
                    }
                    if (!empty($w->date_end)) {
                        return false;
                    }
                    return true;
                }
                
                public function getAccessLevel($id) {
                    $al = AL_NONE;
                    $rq = UserRequest::model()->findByAttributes(array("id" => $id));
                    if (empty($rq)) {
                        return $al;
                    }
                    $rt = Rtype::model()->findByAttributes(array("id" => $rq->type_request_id));
                    while (!empty($rt)) {
                        
                        $rfull = !is_numeric(array_search($rt->group_full, CommonFunctions::getMyGroupsId())) ? AL_NONE : AL_FULL;
                        $rwork = !is_numeric(array_search($rt->group_work, CommonFunctions::getMyGroupsId())) ? AL_NONE : AL_WORK;
                        $rview = !is_numeric(array_search($rt->group_full, CommonFunctions::getMyGroupsId())) ? AL_NONE : AL_VIEW;
                        
                        $al = max(array($al, $rfull, $rwork, $rview));
                        
                        if ($al == AL_FULL) {
                            return $al;
                        }
                        $rt = Rtype::model()->findByAttributes(array("id" => $rt->parent_id));
                    }
                    return $al;
                }
                
                public function getVersion() {
                    return preg_replace("/\D$/","",preg_replace("/^.*:/", "",`svnversion -n`));
                }
}

?>
