<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadCsvRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var ResponseFactory
     */
    protected $response_factory;

    /**
     * UploadController constructor.
     *
     * @param Filesystem      $filesystem
     * @param ResponseFactory $response_factory
     */
    public function __construct (Filesystem $filesystem, ResponseFactory $response_factory)
    {
        $this->filesystem = $filesystem;
        $this->response_factory = $response_factory;
    }

    /**
     * @param UploadCsvRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function upload (UploadCsvRequest $request) : Response
    {
        $request->file('file')->storeAs('uploads', 'export.csv');

        return $this->response_factory->make('success', 200);
    }
}
