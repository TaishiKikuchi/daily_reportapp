<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty','isUnique'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'A password is required'
            )
        ),
        'departmentcode' => array(
            'valid' => array(
                'rule' => array('inList', array('1', '2', '3','4','5','6','7','8')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
        'task' => array(
            'required' => array(
                'rule' => array('notEmpty','isUnique'),
                'message' => 'text is required'
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}
