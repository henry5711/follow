<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\seguidores;


use App\Core\CrudService;
use App\Repositories\seguidores\seguidoresRepository;

/** @property seguidoresRepository $repository */
class seguidoresService extends CrudService
{

    protected $name = "seguidores";
    protected $namePlural = "seguidores";

    public function __construct(seguidoresRepository $repository)
    {
        parent::__construct($repository);
    }

}