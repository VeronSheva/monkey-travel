<?php

namespace App\Service;

class PaginateHelperService
{
    private int $totalPages;

    public function __construct(
        private int $total,
        private int $limit,
        private int $page
    ) {
        $this->setUp();
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getPerPage(): int
    {
        return $this->limit;
    }

    public function getPages(): array
    {
        if (0 === $this->totalPages) {
            return [];
        }
        $pgList = range(1, $this->totalPages);

        if ($this->page < 6) {
            if (isset($pgList[7])) {
                $pgList[7] = '...';
            }

            for ($i = 8; $i < $this->totalPages - 1; ++$i) {
                unset($pgList[$i]);
            }
        } elseif ($this->page > $this->totalPages - 6) {
            if ($pgList[$this->totalPages - 8]) {
                $pgList[$this->totalPages - 8] = '...';
            }

            for ($i = 1; $i < $this->totalPages - 8; ++$i) {
                unset($pgList[$i]);
            }
        } else {
            for ($i = 1; $i <= $this->totalPages; ++$i) {
                if (
                    ($i >= $this->page - 4 && $i <= $this->page + 2) ||
                    0 == $i || $i == $this->totalPages - 1
                ) {
                    if ($i + 4 == $this->page) {
                        $pgList[$i] = '...';
                    }
                    if ($i - 2 == $this->page) {
                        $pgList[$i] = '...';
                    }
                    continue;
                }

                unset($pgList[$i]);
            }
        }

        return $pgList;
    }

    private function setUp(): void
    {
        if ($this->page <= 0) {
            $this->page = 1;
        }
        if ($this->limit <= 0) {
            $this->limit = 1;
        }

        if (0 === $this->total) {
            $this->totalPages = 0;

            return;
        }

        $this->totalPages = intval(($this->total - 1) / $this->limit) + 1;

        if ($this->totalPages < $this->page) {
            $this->page = $this->totalPages;
        }
    }
}
