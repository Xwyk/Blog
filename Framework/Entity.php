<?php

namespace Blog\Framework;

/**
 * Represents an entity in database
 */
abstract class Entity
{
    /**
     * Hydrate object by setting values passed by an array. Doesn't affect directly variables, passing by setters
     * @param array data Associative array containing values for variables
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            //Configure setter name to setXxx
            $method = 'set'.ucfirst($key);
            // If db's attribute name contains '_', split name, and configure setter name to setXxx
            if (strpos($key, "_")) {
                $keyName = explode("_", $key);
                $method = 'set';
                for ($i=0; $i < count($keyName); $i++) {
                    $method.=ucfirst($keyName[$i]);
                }
            }
            // If value isn't null and method exists, call the setter
            if (!($value===null)) {
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }
}