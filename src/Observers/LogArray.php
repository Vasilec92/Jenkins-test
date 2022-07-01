<?php

namespace Cart\Observers;

use SplObserver, SplSubject;

class LogArray implements SplObserver{

    protected array $logs = [];

    public function update(SplSubject $subject):void{
        $this->logs[] = $subject->total();
    }
}