<?php

class ModelBase extends \Phalcon\Mvc\Model implements \ArrayAccess
{
    use ModelPerfect;
    public function initialize()
    {
        if (function_exists('_initialize')) {
            $this->_initialize();
        }
    }

    public function beforeCreate()
    {
        // Set the creation date
        $this->created_at = time();
        $this->updated_at = time();
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->updated_at = time();
    }

    public function tablePrefix()
    {
        return '';
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}
