<?php

namespace IgnitionWolf\API\Modules\Validator;

class RequestValidator extends \IgnitionWolf\API\Validator\RequestValidator
{
    /**
     * Get the base namespace string.
     * @param string $class
     * @return string
     */
    protected function getNamespace(string $class): string
    {
        if (strpos($class, 'Modules\\') !== false) {
            return substr($class, 0, strpos($class, '\\', 9));
        }

        return parent::getNamespace($class);
    }
}
