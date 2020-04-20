<?php

namespace MilesChou\Rest\Traits;

use MilesChou\Rest\Group;

trait GroupAwareTrait
{
    /**
     * @var Group
     */
    protected $group;

    /**
     * @param Group $group
     * @return static
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;
        return $this;
    }
}
