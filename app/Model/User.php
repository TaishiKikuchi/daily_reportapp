<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel
{
    public $validate = array(
        'username' => array(
            'name_rule' => array(
                'rule' => 'isUnique',
                'message' => '既に使用されています'
            ),
            'name_rule2' => array(
                'rule' => 'notEmpty',
                'message' => 'ユーザネームを入力してください'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('minLength', '8'),
                'message' => '最低8文字です'
            )
        ),
        'departmentcode' => array(
            'valid' => array(
                'rule' => array('inList', array('1', '2', '3','4','5','6','7','8')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
        'trello_id' => array(
            'required' => array(
                'rule' => array('isUnique'),
                'message' => '既に登録されています。'
            )
        ),
        'mail' => array(
            'mail_address_rule_2' => array(
                'rule' => 'isUnique',
                'message' => 'すでに使用されているメールアドレスです'
            ),
            'mail_address_rule_1' => array(
                'rule' => 'email',
                'message' => 'メールアドレスのフォーマットを確認してください'
            ),
        ),
    );

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}
