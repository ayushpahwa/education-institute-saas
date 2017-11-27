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

use App\TestDetails;
use League\Fractal;

class TestDetails extends Fractal\TransformerAbstract
{

    public function transform(TestDetails $testdetails)
    {
        return [
            "id" => ["type" => "integer", "unsigned" => true, "primary" => true, "autoincrement" => true, "unique" => true],
            "name" => ["type" => "string"],
            "studentid" => ["type" => "string"],
			"marks" => ["type" => "string"]
            ]
        ];
    }
}
