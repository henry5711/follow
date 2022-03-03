<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\comments;


use App\Core\CrudService;
use App\Repositories\comments\commentsRepository;
use Illuminate\Http\Request;

/** @property commentsRepository $repository */
class commentsService extends CrudService
{

    protected $name = "comments";
    protected $namePlural = "comments";

    public function __construct(commentsRepository $repository)
    {
        parent::__construct($repository);
    }

    public function _store(Request $request)
    {
        $request['sta']="Activo";

        return parent::_store($request);
    }

}