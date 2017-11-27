
<?php
 
use App\Classes;
use App\ClassesTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/classes", function ($request, $response, $arguments) {
   
 $classes = $this->spot->mapper("App\Classes")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($classes, new ClassesTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/classes", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["classes.all", "classes.create"])) {
        throw new ForbiddenException("Token not allowed to create classes.", 403);
    }
    $body = $request->getParsedBody();
    $classes = new Classes($body);
    $this->spot->mapper("App\Classes")->save($classes);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($classes, new ClassesTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New classes created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/classes/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["classes.all", "classes.read"])) {
        throw new ForbiddenException("Token not allowed to list classes.", 403);
    }
    /* Load existing classes using provided id */
    if (false === $classes = $this->spot->mapper("App\Classes")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Classes not found.", 404);
    };
    /* If-Modified-Since and If-None-Match request header handling. */
    /* Heads up! Apache removes previously set Last-Modified header */
    /* from 304 Not Modified responses. */
    if ($this->cache->isNotModified($request, $response)) {
        return $response->withStatus(304);
    }
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($classes, new ClassesTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/classes/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["classes.all", "classes.update"])) {
        throw new ForbiddenException("Token not allowed to update classes.", 403);
    }
    /* Load existing classes using provided id */
    if (false === $classes = $this->spot->mapper("App\Classes")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Classes not found.", 404);
    };
    $body = $request->getParsedBody();
    $classes->data($body);
    $this->spot->mapper("App\Classes")->save($classes);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($classes, new ClassesTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Classes updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/classes/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["classes.all", "classes.update"])) {
        throw new ForbiddenException("Token not allowed to update classes.", 403);
    }
    /* Load existing classes using provided id */
    if (false === $classes = $this->spot->mapper("App\Classes")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Classes not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the classes object first. */
    $classes->clear();
    $classes->data($body);
    $this->spot->mapper("App\Classes")->save($classes);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($classes, new ClassesTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Classes updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/classes/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["classes.all", "classes.delete"])) {
        throw new ForbiddenException("Token not allowed to delete classes.", 403);
    }
    /* Load existing classes using provided id */
    if (false === $classes = $this->spot->mapper("App\Classes")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Classes not found.", 404);
    };
    $this->spot->mapper("App\Classes")->delete($classes);
    $data["status"] = "ok";
    $data["message"] = "Classes deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});