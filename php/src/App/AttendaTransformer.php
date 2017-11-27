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

class AttendaTransformer extends Fractal\TransformerAbstract
{

    public function transform(Attenda $attenda)
    {
        return [
            "id" => (integer)$attenda->id ?: null,
            "name" => (string)$attenda->name ?: 0,
            "studentid" => (integer)$attenda->studentid ?: null,
            "attendance" => !!$attenda->attendance
            
        ];
    }
}
