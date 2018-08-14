<?php

namespace App;

use App\Listener\AuthListener;
use Lean\Event\Events;

class Kernel extends \Lean\Kernel
{
    public function __construct()
    {
        parent::__construct();

        $this->registerListener(Events::REQUEST, new AuthListener());
    }
}
