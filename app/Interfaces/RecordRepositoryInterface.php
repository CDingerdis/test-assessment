<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

/**
 * Interface RecordRepositoryInterface
 *
 * @package App\Repositories
 */
interface RecordRepositoryInterface
{
    /**
     * Return all records
     *
     * @return mixed
     */
    public function all();

    /**
     * Return all records grouped by weeks
     * @return mixed
     */
    public function allPerWeek(): Collection;

    /**
     * return counted records grouped by week
     * @return Collection
     */
    public function allPerWeekCounted(): Collection;

    /**
     * return all records grouped by week and by step
     * @return Collection
     */
    public function allPerWeekInPercentage(): Collection;
}