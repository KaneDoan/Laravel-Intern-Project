<?php

namespace App\Events\Backend\Gym;

use Illuminate\Queue\SerializesModels;

/**
 * Class ClientCreated.
 */
class GymCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $gyms;

    /**
     * @param $gyms
     */
    public function __construct($gyms)
    {
        $this->gyms = $gyms;
    }
}
