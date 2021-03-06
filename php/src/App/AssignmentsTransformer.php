<?php

/*
 * This file is part of the Slim API skeleton package
 *
 * Copyright (c) 2016-2017 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/slim-api-skeleton
 *
 */

namespace App;

use App\Assignments;
use League\Fractal;

//for each table change these

class AssignmentsTransformer extends Fractal\TransformerAbstract
{

    public function transform(Assignments $ssignments)
    {
        return [
            "id" => (integer)$assignments->id ?: null,
            "name" => (string)$assignments->order ?: 0,
            "chapter" => (string)$assignments->chapter ?: null,
            "completed" => !!$Assignments->assignments
            
        ];
    }
}
