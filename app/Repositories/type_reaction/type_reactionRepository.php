<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\type_reaction;

use App\Core\CrudRepository;
use App\Models\type_reaction;

/** @property type_reaction $model */
class type_reactionRepository extends CrudRepository
{

    public function __construct(type_reaction $model)
    {
        parent::__construct($model);
    }

}