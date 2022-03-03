<?php

namespace App\Http\Controllers\type_reaction;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Services\type_reaction\type_reactionService;
/** @property type_reactionService $service */
class type_reactionController extends CrudController
{
    public function __construct(type_reactionService $service)
    {
        parent::__construct($service);
    }
}