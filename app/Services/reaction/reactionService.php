<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\reaction;


use App\Core\CrudService;
use App\Repositories\reaction\reactionRepository;

/** @property reactionRepository $repository */
class reactionService extends CrudService
{

    protected $name = "reaction";
    protected $namePlural = "reactions";

    public function __construct(reactionRepository $repository)
    {
        parent::__construct($repository);
    }

}