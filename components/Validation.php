<?php

namespace components;

use components\interfaces\ValidableInterface;

class Validation
{
    /** @var ValidableInterface */
    private $validable;

    /**
     * Validation constructor.
     * @param ValidableInterface $validable
     */
    public function __construct(ValidableInterface $validable)
    {
        $this->validable = $validable;
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     */
    public function required(string $fieldName, $value)
    {
        if (!$value) {
            $this->validable->addError($fieldName, "Поле $fieldName обязательно для заполнения");
        }

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     */
    public function alnum(string $fieldName, $value)
    {
        if (!ctype_alnum($value)) {
            $this->validable->addError($fieldName, "Поле $fieldName должно содержать только буквы или циффры");
        }

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     */
    public function alphaAndDigit(string $fieldName, $value)
    {
        if (ctype_alpha($value) || ctype_digit($value)) {
            $this->validable->addError($fieldName, "Поле $fieldName должно содержать и циффры и буквы");
        }

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     */
    public function email(string $fieldName, $value)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->validable->addError($fieldName, "Поле $fieldName должно содержать адрес электронной почты");
        }

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     */
    public function integer(string $fieldName, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->validable->addError($fieldName, "Поле $fieldName должно быть целым числом");
        }

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     * @param int|null $min
     * @param int|null $max
     * @return $this
     * @throws \Exception
     */
    public function lenght(string $fieldName, $value, int $min = null, int $max = null)
    {
        if (!$min && !$max) {
            throw new \Exception('Укажите значения $min или $max');
        }

        $value = (string) $value;
        $lenght = strlen($value);

        if ($max && ($lenght > $max)) {
            $this->validable->addError($fieldName, "Поле $fieldName должно содержать не более $max символов");
        }

        if ($min && ($lenght < $min)) {
            $this->validable->addError($fieldName, "Поле $fieldName должно содержать не менее $min символов");
        }

        return $this;
    }
}
