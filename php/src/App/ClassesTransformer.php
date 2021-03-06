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

use App\Classes;
use League\Fractal;

//for each table change these

class ClassesTransformer extends Fractal\TransformerAbstract
{

    public function transform(Classes $classes)
    {
        return [
            "id" => (integer)$classes->id ?: null,
            "name" => (string)$classes->name ?: 0,
            ]
        ];
    }
}
