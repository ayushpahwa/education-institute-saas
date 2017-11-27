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

use App\Test;
use League\Fractal;

//for each table change these

class TestTransformer extends Fractal\TransformerAbstract
{

    public function transform(Test $test)
    {
        return [
            "testid" => (integer)$test->testid ?: null,
            "class" => (string)$test->classs ?: 0,
            "subject" => (string)$test->subject ?: null,
            "batch" => (string)$test->batch ?: null,
            "date" => (string)$test->date ?: null,
            "name" => (string)$test->name ?: null,
            "mm" => (float)$test->mm ?: null,
            ]
        ];
    }
}
