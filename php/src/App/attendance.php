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

use Spot\EntityInterface;
use Spot\MapperInterface;
use Spot\EventEmitter;
use Tuupola\Base62;
use Psr\Log\LogLevel;

class Attendance extends \Spot\Entity
{
    protected static $table = "attendance";

//copy for each table in database
    public static function fields()
    {
        return [
            "attendanceid" => ["type" => "integer", "unsigned" => true, "primary" => true, "autoincrement" => true],
            "batch" => ["type" => "string"],
            "date" => ["type" => "string"],
            "subject" => ["type" => "string"],
            "class" => ["type" => "string"],
            "percent" => ["type" => "integer"]
            
        ];
    }
/*
    public static function events(EventEmitter $emitter)
    {
        $emitter->on("beforeInsert", function (EntityInterface $entity, MapperInterface $mapper) {
            $entity->uid = (new Base62)->encode(random_bytes(9));
        });

        $emitter->on("beforeUpdate", function (EntityInterface $entity, MapperInterface $mapper) {
            $entity->updated_at = new \DateTime();
        });
    }
    */
    public function timestamp()
    {
        return $this->updated_at->getTimestamp();
    }

   
}
