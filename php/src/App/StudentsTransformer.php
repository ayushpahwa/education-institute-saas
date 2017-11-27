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

use App\Todo;
use League\Fractal;

class StudentsTransformer extends Fractal\TransformerAbstract
{

    public function transform(Students $students)
    {
        return [
            "id" => ["type" => "integer", "unsigned" => true, "primary" => true, "unique" => true],
            "name" => ["type" => "string"],
            "eid" => ["type" => "string"],
            "phone" => ["type" => "string"],
            "father" => ["type" => "string"],
			"mother" => ["type" => "string"],
			"contact" => ["type" => "string"],
			"class" => ["type" => "integer", "unsigned" => true, "primary" => true, "unique" => true],
            "batch"   => ["type" => "integer", "unsigned" => true, "primary" => true, "unique" => true],
            "sub5" => ["type" => "string"],
			"amount" => ["type" => "string"],
			"feemonth" => ["type" => "string"],
			"feediscount" => ["type" => "string"],
			"feetype" => ["type" => "string"]
            ]
        ];
    }
}
