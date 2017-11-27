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

use App\Inquiry;
use League\Fractal;

//for each table change these

class InquiryTransformer extends Fractal\TransformerAbstract
{

    public function transform(Inquiry $inquiry)
    {
        return [
            "id" => (integer)$inquiry->id ?: null,
            "name" => (string)$inquiry->name ?: 0,
            "gender" => (string)$inquiry->gender ?: null,
            "class" => (string)$inquiry->class ?: null,
            "number" => (string)$inquiry->number ?: null,
            "date" => (string)$inquiry->date ?: null,
            "email" => (string)$inquiry->email ?: null
            ]
        ];
    }
}
