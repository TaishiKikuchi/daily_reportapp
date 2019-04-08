<?php

class Report extends AppModel {
    public function isOwnedBy($report, $user) {
        return $this->field('id', array('id' => $report, 'user' => $user)) !== false;
    }
    
}