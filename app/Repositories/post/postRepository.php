<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\post;

use App\Core\CrudRepository;
use App\Models\post;

/** @property post $model */
class postRepository extends CrudRepository
{

    public function __construct(post $model)
    {
        parent::__construct($model);
    }

}