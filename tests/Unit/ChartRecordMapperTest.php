<?php

namespace Tests\Unit;

use App\Classes\ChartRecordMapper;
use App\Models\Record;
use Tests\TestCase;

class ChartRecordMapperTest extends TestCase
{
    private $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = app()->make(ChartRecordMapper::class);
    }

    public function testGetAllStepsIsSame()
    {
        $steps = $this->mapper->getSteps();
        $this->assertSame([
            0 => "Create account",
            20 => "Activate account",
            40 => "Provide profile information",
            50 => "What jobs are you interested in?",
            70 => "Do you have relevant experience in these jobs?",
            90 => "Are you a freelancer?",
            99 => "Waiting for approval",
            100 => "Approval"
        ], $steps);
    }

    public function testMapToChartToCorrectData() {
        $percentages = collect([3 => 1]);
        $record = $this->getMockBuilder(Record::class)->setMethods(['count'])->getMock();
        $record->expects($this->any())->method('count')->willReturn(1);
        $total = collect([3 => collect([40 => $record])]);
        $data = $this->mapper->mapToChart($total, $percentages);

        $this->assertSame([
            ['Create account', 100.0],
            ['Activate account', 100.0],
            ['Provide profile information', 100.0],
            ['What jobs are you interested in?', 0.0],
            ['Do you have relevant experience in these jobs?', 0.0],
            ['Are you a freelancer?', 0.0],
            ['Waiting for approval', 0.0],
            ['Approval', 0.0],
        ],$data->get(3));
    }
}
