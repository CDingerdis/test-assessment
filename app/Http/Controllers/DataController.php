<?php

namespace App\Http\Controllers;

use App\Classes\ChartRecordMapper;
use App\Repositories\CsvRecordRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
Class DataController extends Controller
{

    /**
     * @var ChartRecordMapper
     */
    protected $record_mapper;

    /**
     * @var CsvRecordRepository
     */
    protected $record_repository;

    /**
     * @var ResponseFactory
     */
    protected $response_factory;

    /**
     * HomeController constructor.
     *
     * @param ResponseFactory $response_factory
     * @param ChartRecordMapper $record_mapper
     * @param CsvRecordRepository $record_repository
     */
    public function __construct(
        ResponseFactory $response_factory,
        ChartRecordMapper $record_mapper,
        CsvRecordRepository $record_repository
    )
    {
        $this->record_mapper = $record_mapper;
        $this->record_repository = $record_repository;
        $this->response_factory = $response_factory;
    }

    /**
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        $total_per_week = $this->record_repository->AllPerWeekCounted();
        $percentage_per_week = $this->record_repository->allPerWeekInPercentage();
        $data = $this->record_mapper->mapToChart($percentage_per_week, $total_per_week);
        $steps = $this->record_mapper->getSteps();

        return $this->response_factory->json(['values' => $data, 'steps' => $steps]);
    }
}
