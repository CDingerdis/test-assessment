<?php

namespace App\Classes;

use Illuminate\Support\Collection;

/**
 * Class ChartRecordMapper
 *
 * @package App\Classes
 */
Class ChartRecordMapper
{

    /**
     * All visible steps
     */
    private const VISIBLE_STEPS = [
        0 => 'Create account',
        20 => 'Activate account',
        40 => 'Provide profile information',
        50 => 'What jobs are you interested in?',
        70 => 'Do you have relevant experience in these jobs?',
        90 => 'Are you a freelancer?',
        99 => 'Waiting for approval',
        100 => 'Approval',
    ];

    /**
     * get the steps
     *
     * @return array
     */
    public function getSteps(): array
    {
        return self::VISIBLE_STEPS;
    }

    /**
     * map the records to the correct format for the chart
     *
     * @param Collection $percentage_per_week
     * @param            $total_per_week
     *
     * @return Collection
     */
    public function mapToChart(Collection $percentage_per_week, $total_per_week): Collection
    {
        return $percentage_per_week->map(function ($records, $week) use ($total_per_week) {
            $steps = $this->getAllSteps($records);

            return $this->calculateDropOff($records, $steps, $total_per_week[$week]);
        });
    }

    /**
     * get the keys (percentages) of the steps
     *
     * @return array
     */
    private function getStepsKeys(): array
    {
        return array_keys(self::VISIBLE_STEPS);
    }

    /**
     * get all steps that have been provided in the document and append them with the steps in the records
     *
     * @param $records
     *
     * @return array
     */
    private function getAllSteps($records): array
    {
        $all_steps = array_unique(array_merge($records->keys()->toArray(), array_keys(self::VISIBLE_STEPS)),
            SORT_REGULAR);
        sort($all_steps);

        return $all_steps;
    }

    /**
     * Calculate the drop off every step per week
     *
     * @param $records
     * @param $steps
     * @param $total
     *
     * @return array
     */
    private function calculateDropOff($records, $steps, $total): array
    {
        $next_drop_off = 0;
        $result = [];
        foreach ($steps as $step) {
            $drop_off = $records->has($step) ? $records[$step]->count() : 0;
            $drop_off_percentage = round($next_drop_off / $total * 100);
            if (in_array($step, $this->getStepsKeys(), true)) {
                $result[] = [$this->getSteps()[$step], 100 - $drop_off_percentage];
            }
            $next_drop_off += $drop_off;
        }

        return $result;
    }
}
