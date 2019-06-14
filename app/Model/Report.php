<?php

class Report extends AppModel
{
    public function isOwnedBy($report, $user)
    {
        return $this->field('id', array('id' => $report, 'user' => $user)) !== false;
    }

    public $hasMany = array(
        'Work' => array(
            'className' => 'Work',
            'order' => 'Work.starttime ASC'
        ),
        'Share' => array(
            'className' => 'Share'
        )
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
}
