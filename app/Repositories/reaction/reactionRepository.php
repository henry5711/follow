<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\reaction;

use App\Core\CrudRepository;
use App\Models\reaction;

/** @property reaction $model */
class reactionRepository extends CrudRepository
{

    public function __construct(reaction $model)
    {
        parent::__construct($model);
    }

}