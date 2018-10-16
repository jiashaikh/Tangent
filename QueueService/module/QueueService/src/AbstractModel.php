<?php

namespace Application;

abstract class AbstractModel
{
    /**
     * Returns an array copy of this object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
