<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Factory;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var Factory
     */
    private $view_factory;

    /**
     * HomeController constructor.
     *
     * @param Factory $view_factory
     */
    public function __construct (Factory $view_factory)
    {
        $this->view_factory = $view_factory;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index () : View
    {
        return $this->view_factory->make('home');
    }
}
