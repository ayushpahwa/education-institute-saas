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

use App\Attendance;
use League\Fractal;

//for each table change these

class AttendanceTransformer extends Fractal\TransformerAbstract
{

    public function transform(Attendance $attendance)
    {
        return [
            "attendanceid" => (integer)$attendanceid->attendanceid ?: null,
            "batch" => (string)$attendance->batch ?: 0,
            "date" => (string)$attendance->date ?: null,
            "subject" => !!$attendance->subject
            
        ];
    }
}
