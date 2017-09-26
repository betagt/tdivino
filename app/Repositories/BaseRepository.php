<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 13/03/2017
 * Time: 14:45
 */

namespace Portal\Repositories;

use Illuminate\Container\Container as Application;
use \Prettus\Repository\Eloquent\BaseRepository as BasePrettus;

class BaseRepository extends BasePrettus
{

    public function __construct(Application $app, $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return $this->model;
    }

    public function onlyTrashed(){
        return $this->parserResult($this->model->onlyTrashed()->get());
    }


}