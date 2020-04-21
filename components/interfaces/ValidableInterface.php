<?php

namespace components\interfaces;

interface ValidableInterface
{
    /**
     * @return bool
     */
    public function validate(): bool;

    /**
     * @param string $field
     * @param string $message
     * @return void
     */
    public function addError(string $field, string$message);

    /**
     * @param string|null $field
     * @return bool
     */
    public function hasErrors(string $field = null): bool;
}
