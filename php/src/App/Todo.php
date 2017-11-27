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

class Todo extends \Spot\Entity
{
    protected static $table = "todos";

    public static function fields()
    {
        return [
<<<<<<< Updated upstream
            "id" => ["type" => "integer", "unsigned" => true, "primary" => true, "autoincrement" => true],
            "name" => ["type" => "text", "unsigned" => true]
=======
            "id" => ["type" => "integer", "unsigned" => true, "primary" => true, "autoincrement" => true, "unique" => true],
            "name" => ["type" => "string"],
            "eid" => ["type" => "string"],
            "phone" => ["type" => "string"],
            "father" => ["type" => "string"],
			"mother" => ["type" => "string"],
			"contact" => ["type" => "string"],
			"class" => ["type" => "integer", "unsigned" => true, "primary" => true, "autoincrement"=> true, "unique" => true],
            "batch"   => ["type" => "integer", "unsigned" => true, "primary" => true, "autoincrement"=> true, "unique" => true],
            "sub5" => ["type" => "string"],
			"amount" => ["type" => "string"],
			"feemonth" => ["type" => "string"],
			"feediscount" => ["type" => "string"],
			"feetype" => ["type" => "string"],
			
			"updated_at"   => ["type" => "datetime", "value" => new \DateTime()]
>>>>>>> Stashed changes
        ];
    }

    public static function events(EventEmitter $emitter)
    {
        $emitter->on("beforeInsert", function (EntityInterface $entity, MapperInterface $mapper) {
            $entity->uid = (new Base62)->encode(random_bytes(9));
        });

        $emitter->on("beforeUpdate", function (EntityInterface $entity, MapperInterface $mapper) {
            $entity->updated_at = new \DateTime();
        });
    }
    public function timestamp()
    {
        return $this->updated_at->getTimestamp();
    }

    public function etag()
    {
        return md5($this->uid . $this->timestamp());
    }

    public function clear()
    {
        $this->data([
            "order" => null,
            "title" => null,
            "completed" => null
        ]);
    }
}
