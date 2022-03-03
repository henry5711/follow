<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\seguidores;

use App\Core\CrudRepository;
use App\Models\seguidores;

/** @property seguidores $model */
class seguidoresRepository extends CrudRepository
{

    public function __construct(seguidores $model)
    {
        parent::__construct($model);
    }

}