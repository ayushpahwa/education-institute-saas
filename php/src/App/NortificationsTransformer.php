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

use App\Nortifications;
use League\Fractal;

//for each table change these

class NortificationsTransformer extends Fractal\TransformerAbstract
{

    public function transform(Nortifications $nortifications)
    {
        return [
            "id" => (integer)$nortifications->id ?: null,
            "class" => (string)$nortifications->class ?: 0,
            "batch" => (string)$nortifications->batch ?: null,
            "title" => (string)$nortifications->title ?: null,
            "message" => (string)$nortifications->message ?: null,
            "status" => (string)$nortifications->status ?: null,
            "date" => (string)$nortifications->date ?: null,
            "type" => (string)$nortifications->type ?: null
            ]
        ];
    }
}
