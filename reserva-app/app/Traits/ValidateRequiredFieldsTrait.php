<?php

namespace App\Traits;

trait ValidateRequiredFieldsTrait
{
    public function hasRequiredModelAttributes(object $model, array $keys): bool
    {
        if (empty($model)) {
            return false;
        }

        $attribs = $model->getAttributes();

        if (empty($attribs) || empty($keys)) {
            return false;
        }

        $required = true;
        foreach ($keys as $key) {
            if (!isset($attribs[$key])) {
                $required = false;
            }
        }

        return $required;
    }

    public function hasNullValueModelAttributes(object $model, array $keys): bool
    {
        if (empty($model)) {
            return false;
        }

        $attribs = $model->getAttributes();

        if (empty($attribs) || empty($keys)) {
            return false;
        }

        foreach ($keys as $key) {
            if (!(array_key_exists($key, $attribs))) {
                continue;
            }

            if (
                is_null($attribs[$key])
                || trim('' . $attribs[$key]) == ''
            ) {
                return true;
            }
        }

        return false;
    }
}
