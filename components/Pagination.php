<?php

namespace components;

class Pagination
{
    private const PAGES_AROUND = 2;
    private const PAGES_MIDDLE = 3;

    /** @var int */
    private $currentPage;

    /** @var int */
    private $totalPages;

    /** @var int */
    private $showPages;

    /** @var int */
    private $perpage;

    /**
     * Pagination constructor.
     * @param int $total
     * @param int $perpage
     * @param int $showPages
     * @param int|null $currentPage
     */
    public function __construct(int $total, int $perpage, int $showPages, int $currentPage = null)
    {
        $this->totalPages = (int) ceil($total / $perpage);
        $this->currentPage = min($currentPage ?? 1, $this->totalPages);
        $this->showPages = min($showPages, $this->totalPages);
        $this->perpage = $perpage;
    }

    /**
     * @param int $page
     * @return bool
     */
    public function isCurrentPage(int $page): bool
    {
        return $page === $this->currentPage;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return (int) ($this->currentPage ? ($this->currentPage - 1) * $this->perpage : 0);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->perpage;
    }

    /**
     * @return bool
     */
    public function hasPrevPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function getPrevPage(): ?int
    {
        return $this->hasPrevPage()
            ? $this->currentPage - 1
            : null;
    }

    /**
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->currentPage !== $this->totalPages;
    }

    /**
     * @return int|null
     */
    public function getNextPage(): ?int
    {
        return $this->hasNextPage()
            ? $this->currentPage + 1
            : null;
    }

    /**
     * @return \Generator
     */
    public function getLeftPages(): \Generator
    {
        $min = 1;

        if ($this->totalPages <= $this->showPages) {
            $max = $this->totalPages;
        }

        if ($this->totalPages > $this->showPages) {
            if ($this->currentPage < ((self::PAGES_AROUND * 2) + 2)) {
                $max = $this->showPages - self::PAGES_AROUND;
            } else {
                $max = $min + 1;
            }
        }

        for ($page = $min; $page <= $max; $page++) {
            yield $page;
        }
    }

    /**
     * @return bool
     */
    public function hasMiddlePages(): bool
    {
        return ($this->totalPages > $this->showPages)
            && ($this->currentPage >= ((self::PAGES_AROUND * 2) + 2));
    }

    /**
     * @return int|mixed
     */
    private function getRest()
    {
        return $this->totalPages - ($this->showPages + self::PAGES_AROUND + 1);
    }

    /**
     * @return \Generator
     */
    public function getMiddlePages(): \Generator
    {
        if ($this->hasMiddlePages()) {

            if ($this->hasRightPages()) {
                $min = max(self::PAGES_AROUND, ($this->currentPage - 2));
                $max = min($min + $this->getMiddleCount(), $this->totalPages);
            } elseif ($this->getRest() <= 0) {
                $min = $this->totalPages - ($this->showPages - self::PAGES_AROUND - 1 );
                $max = $this->totalPages;
            }

            for ($page = $min; $page <= $max; $page++) {
                yield $page;
            }
        }
    }

    /**
     * @return float|int|mixed
     */
    private function getMiddleCount()
    {
        return $this->showPages - (self::PAGES_AROUND * 2 + 2);
    }

    /**
     * @return bool
     */
    public function hasRightPages(): bool
    {
        return ($this->totalPages > $this->showPages)
            && (($this->currentPage + 2) < $this->getRightMin())
            && $this->getMiddleCount() >= self::PAGES_MIDDLE;
    }

    /**
     * @return \Generator
     */
    public function getRightPages(): \Generator
    {
        if ($this->hasRightPages()) {
            $min = $this->getRightMin();
            $max = $this->totalPages;

            for ($page = $min; $page <= $max; $page++) {
                yield $page;
            }
        }
    }

    /**
     * @return int
     */
    private function getRightMin()
    {
        return $this->totalPages - (self::PAGES_AROUND - 1);
    }
}
