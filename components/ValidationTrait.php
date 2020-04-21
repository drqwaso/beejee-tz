<?php

namespace components;

trait ValidationTrait
{
    /** @var array */
    private $errors = [];

    /**
     * @param string $field
     * @param string $message
     */
    public function addError(string $field, string $message)
    {
        if (!is_array($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $message;
    }

    /**
     * @param string|null $field
     * @return bool
     */
    public function hasErrors(string $field = null): bool
    {
        return $field
            ? !empty($this->errors[$field])
            : !empty($this->errors);
    }

    /**
     * @param string|null $field
     * @return array|null
     */
    public function getErrors(string $field = null): ?array
    {
        return $field
            ? $this->errors[$field]
            : $this->errors;
    }

    /**
     * @param string|null $field
     * @return string|null
     */
    public function getErrorsList(string $field = null): ?string
    {
        $errors = $this->getErrors($field);
        $errorList = [];
        array_walk_recursive($errors, function ($item) use(&$errorList) {
            $errorList[] = $item;
        });

        return implode('</br>', $errorList);
    }

    /**
     * @param string $field
     * @return string
     */
    public function getValidClass(string $field)
    {
        return $this->hasErrors($field) ? 'is-invalid' : '';
    }
}
