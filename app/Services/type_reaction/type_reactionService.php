<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\type_reaction;


use App\Core\CrudService;
use App\Repositories\type_reaction\type_reactionRepository;

/** @property type_reactionRepository $repository */
class type_reactionService extends CrudService
{

    protected $name = "type_reaction";
    protected $namePlural = "type_reactions";

    public function __construct(type_reactionRepository $repository)
    {
        parent::__construct($repository);
    }

}
