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

use App\Batches;
use League\Fractal;

//for each table change these

class BatchesTransformer extends Fractal\TransformerAbstract
{

    public function transform(Batches $batches)
    {
        return [
            "statement" => (integer)$batches->id ?: null,
            "status" => (string)$batches->order ?: 0
        ];
    }
}
