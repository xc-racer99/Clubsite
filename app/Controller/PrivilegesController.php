<?php
class PrivilegesController extends AppController {

    var $name = 'Privileges';
    var $helpers = array("Form");
    var $components = array('Email', 'RequestHandler');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'forgot', 'login', 'verify', 'authorized');
    }

    function index() {
        $this->checkAuthorization(Configure::read('Privilege.Privilege.edit'));
        $this->loadModel('User');
        $level = $this->User->getLevel(AuthComponent::user('id'));
        $levelCondition = array('Group.access_level <= ' => $level);
        $this->set('groups', $this->Privilege->Group->find('list', array('conditions'=>$levelCondition)));
        $this->set('users', $this->Privilege->User->find('list'));
        $this->set('privileges', $this->Privilege->find('all', array('conditions'=>$levelCondition)));
        $this->set('groupList', $this->Privilege->Group->find('all', array('conditions'=>$levelCondition, 'recursive' => -1)));
    }

    function edit() {
        $this->checkAuthorization(Configure::read('Privilege.Privilege.edit'));
        if(!empty($this->data)) {
            if($this->Privilege->save($this->data)){
                $this->Session->setFlash('The privilege has been updated.', "flash_success");
            } else {
                $this->Session->setFlash('The privilege could not be updated.');
            }
            $this->redirect('/privileges/');
        }
    }

    function add() {
        if(!empty($this->data)) {
            if($this->Privilege->save($this->data)){
                $this->Session->setFlash('The privilege has been added.', "flash_success");
            } else {
                $this->Session->setFlash('The privilege could not be added.');
            }
            $this->redirect('/privileges/');
        }
    }

    function delete() {
        $this->checkAuthorization(Configure::read('Privilege.Privilege.edit'));
        if(!empty($this->data)) {
            if($this->Privilege->delete($this->data["Privilege"]["id"])){
                $this->Session->setFlash('The privilege has been deleted.', "flash_success");
            } else {
                $this->Session->setFlash('The privilege could not be deleted.');
            }
            $this->redirect('/privileges/');
        }
    }
}
