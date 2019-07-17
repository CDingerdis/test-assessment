<?php

namespace App\Hydrators;

use App\Models\Record;
use Illuminate\Support\Collection;

/**
 * Class CsvRecordHydrator
 *
 * @package App\Hydrators
 */
class CsvRecordHydrator
{
    /**
     * Hydrate the raw csv array data from the importer to App\Models\Records
     *
     * @param array $rows
     *
     * @return Collection
     */
    public function hydrate(array $rows): Collection
    {
        $entities = new Collection();
        foreach ($rows as $row) {
            $entities->push($this->hydrateSingle($row));
        }

        return $entities->filter();
    }

    /**
     * @param array $data
     *
     * @return Record
     */
    public function hydrateSingle(array $data): ?Record
    {
        $record = new Record();
        $record->setUserId($data['user_id']);
        $record->setCreatedAt($data['created_at']);
        $record->setOnboardingPercentage($data['onboarding_perentage']);
        $record->setCountApplications($data['count_applications']);
        $record->setCountAcceptedApplications($data['count_accepted_applications']);
        if (!$record->isValid()) {
            return null;
        }

        return $record;
    }
}
