<?php

namespace Tests\Unit;

use App\Hydrators\CsvRecordHydrator;
use Carbon\Carbon;
use Tests\TestCase;

class CsvRecordHydratorTest extends TestCase
{

    private $hydrator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hydrator = app()->make(CsvRecordHydrator::class);
    }

    /**
     * @dataProvider countHydratorProvider
     */
    public function testCountRecords($records, $count)
    {
        $result = $this->hydrator->hydrate($records);
        $this->assertCount($count, $result);
    }

    public function testCorrectOutputData()
    {
        $data = [['user_id' => 2, 'created_at' => '2019-01-01', 'onboarding_perentage' => 40, 'count_applications' => 0, 'count_accepted_applications' => 0]];
        $result = $this->hydrator->hydrate($data);
        $item = $result->first();

        $this->assertSame(2, $item->getUserId());
        $this->assertSame(40, $item->getOnboardingPercentage());
        $this->assertSame(Carbon::parse('2019-01-01')->format('Y-m-d'), $item->getCreatedAt()->format('Y-m-d'));
        $this->assertSame(0, $item->getCountApplications());
        $this->assertSame(0, $item->getCountAcceptedApplications());
    }

    public function countHydratorProvider()
    {
        return [
            [[['user_id' => 2, 'created_at' => '2019-01-01', 'onboarding_perentage' => 40, 'count_applications' => 0, 'count_accepted_applications' => 0]], 1],
            [[['user_id' => 2, 'created_at' => '2019-01-01', 'onboarding_perentage' => 40, 'count_applications' => 0, 'count_accepted_applications' => 0], ['user_id' => 2, 'created_at' => '2019-01-01', 'onboarding_perentage' => 40, 'count_applications' => 0, 'count_accepted_applications' => 0]], 2],
            [[['user_id' => 2, 'created_at' => '2019-01-01', 'onboarding_perentage' => "", 'count_applications' => 0, 'count_accepted_applications' => 0], ['user_id' => 2, 'created_at' => '2019-01-01', 'onboarding_perentage' => 40, 'count_applications' => 0, 'count_accepted_applications' => 0]], 1]
        ];
    }
}
