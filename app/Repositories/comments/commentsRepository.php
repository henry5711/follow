<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\comments;

use App\Core\CrudRepository;
use App\Models\comments;

/** @property comments $model */
class commentsRepository extends CrudRepository
{

    public function __construct(comments $model)
    {
        parent::__construct($model);
    }

}