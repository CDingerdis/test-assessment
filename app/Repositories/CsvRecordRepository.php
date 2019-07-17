<?php

namespace App\Repositories;

use App\Classes\CsvImporter;
use App\Hydrators\CsvRecordHydrator;
use App\Interfaces\RecordRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class CsvRecordRepository
 *
 * @package App\Repositories
 */
Class CsvRecordRepository implements RecordRepositoryInterface
{
    /**
     * @var CsvImporter
     */
    private $csv_importer;

    /**
     * @var CsvRecordHydrator
     */
    private $record_hydrator;

    /**
     * @var string
     */
    private $path;

    /**
     * @var
     */
    private $records;

    /**
     * CsvRecordRepository constructor.
     *
     * @param CsvImporter $csv_importer
     * @param CsvRecordHydrator $record_hydrator
     */
    public function __construct(CsvImporter $csv_importer, CsvRecordHydrator $record_hydrator)
    {
        $this->path = storage_path('app/uploads/export.csv');
        $this->csv_importer = $csv_importer;
        $this->record_hydrator = $record_hydrator;
        $data = $this->csv_importer->import($this->path);
        $this->records = $this->record_hydrator->hydrate($data);
    }

    /**
     * Return all records
     *
     * @return mixed
     */
    public function all()
    {
        return $this->records;
    }

    /**
     * Return all records grouped by weeks
     * @return mixed
     */
    public function allPerWeek(): Collection
    {
        return $this->all()->groupBy(function ($record, $key) {
            return $record->getCreatedAt()->startOfWeek()->weekOfYear;
        });
    }

    /**
     * return counted records grouped by week
     * @return Collection
     */
    public function allPerWeekCounted(): Collection
    {
        return $this->allPerWeek()->map(function ($item) {
            return $item->count();
        });
    }

    /**
     * return all records grouped by week and by step
     * @return Collection
     */
    public function allPerWeekInPercentage(): Collection
    {
        return $this->allPerWeek()->map(function ($items) {
            return $items->groupBy(function ($item) {
                return $item->getOnboardingPercentage();
            });
        });
    }
}
