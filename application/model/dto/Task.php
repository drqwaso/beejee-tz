<?php

namespace application\model\dto;

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_PROGRESS = 'prrogress';
    public const STATUS_DONE = 'done';

    public const UPDATED_TRUE = 1;
    public const UPDATED_FALSE = 0;

    /** @var int */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $email;

    /** @var string */
    private $text;

    /** @var int */
    private $updated;

    /** @var string */
    private $status;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Task
     */
    public function setId(int $id): Task
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Task
     */
    public function setUsername(string $username): Task
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Task
     */
    public function setEmail(string $email): Task
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Task
     */
    public function setText(string $text): Task
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUpdated(): ?int
    {
        return $this->updated;
    }

    /**
     * @param int $updated
     * @return Task
     */
    public function setUpdated(int $updated): Task
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Task
     */
    public function setStatus(string $status): Task
    {
        $this->status = $status;

        return $this;
    }
}
