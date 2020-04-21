<?php

namespace components;

class Sorting
{
    public const SORT_DIRECTION_ASC = 'asc';
    public const SORT_DIRECTION_DESC = 'desc';

    /** @var array */
    private $sortingTypes;

    /** @var string */
    private $defaultSorting;

    /** @var string */
    private $currenSorting;

    /** @var string */
    private $currenDirection;

    /**
     * Sorting constructor.
     * @param array $SortingTypes
     * @param string $defaultSorting
     */
    public function __construct(
        array $SortingTypes,
        string $currenSorting = null,
        string $currenDirection = null,
        string $defaultSorting = null
    ) {
        $this->sortingTypes = $SortingTypes;
        $this->defaultSorting = $defaultSorting;
        $this->currenSorting = $currenSorting;
        $this->currenDirection = $currenDirection;
    }

    /**
     * @param string $sortingType
     * @return bool
     */
    public function isDefaultSorting(string $sortingType): bool
    {
        return $this->defaultSorting === $sortingType;
    }

    /**
     * @param string $sortingType
     * @return bool
     */
    public function isCurrentSorting(string $sortingType): bool
    {
        return $this->currenSorting === $sortingType;
    }

    public function isCurrentDirection(string $sortingDirection): bool
    {
        return $this->currenDirection === $sortingDirection;
    }

    /**
     * @return string
     */
    public function getCurrenSorting(): ?string
    {
        return $this->currenSorting;
    }

    /**
     * @return string
     */
    public function getCurrenDirection(): ?string
    {
        return $this->currenDirection;
    }

    /**
     * @return string
     */
    public function getNextDirection(): ?string
    {
        return ($this->currenDirection === self::SORT_DIRECTION_ASC)
            ? self::SORT_DIRECTION_DESC
            : self::SORT_DIRECTION_ASC;
    }

    /**
     * @return array
     */
    public function getSortingTypes(): array
    {
        return $this->sortingTypes;
    }
}
