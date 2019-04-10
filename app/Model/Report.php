<?php

class Report extends AppModel {
    public function isOwnedBy($report, $user) {
        return $this->field('id', array('id' => $report, 'user' => $user)) !== false;
    }
    /*
    public function getReport($id){
        $sql = "SELECT * FROME sample WHERE sample.id = :id;";

        $params = array(
            'id'=> $id
        );

        $report = $this->query($sql,$params);
        return $report;
    }
    */
    public $hasMany = array(
        'Work' => array(
            'className' => 'Work',
            //'conditions' => array('Work.report_id' => ''),
            'order' => 'Work.starttime ASC'
        ),
        'Share' => array(
            'className' => 'Share',
            //'conditions' => array('Share.report_id' => ''),
        )
    );
}