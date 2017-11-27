<?php
 
use App\Batch;
use App\BatchTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/batches", function ($request, $response, $arguments) {
   
 $batches = $this->spot->mapper("App\Batch")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($batches, new BatchTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/batches", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["batches.all", "batches.create"])) {
        throw new ForbiddenException("Token not allowed to create batches.", 403);
    }
    $body = $request->getParsedBody();
    $batches = new Batch($body);
    $this->spot->mapper("App\Batch")->save($batches);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($batches, new BatchTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New batches created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/batches/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["batches.all", "batches.read"])) {
        throw new ForbiddenException("Token not allowed to list batches.", 403);
    }
    /* Load existing batches using provided id */
    if (false === $batches = $this->spot->mapper("App\Batch")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Batch not found.", 404);
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
    $resource = new Item($batches, new BatchTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/batches/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["batches.all", "batches.update"])) {
        throw new ForbiddenException("Token not allowed to update batches.", 403);
    }
    /* Load existing batches using provided id */
    if (false === $batches = $this->spot->mapper("App\Batch")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Batch not found.", 404);
    };
    $body = $request->getParsedBody();
    $batches->data($body);
    $this->spot->mapper("App\Batch")->save($batches);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($batches, new BatchTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Batch updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/batches/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["batches.all", "batches.update"])) {
        throw new ForbiddenException("Token not allowed to update batches.", 403);
    }
    /* Load existing batches using provided id */
    if (false === $batches = $this->spot->mapper("App\Batch")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Batch not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the batches object first. */
    $batches->clear();
    $batches->data($body);
    $this->spot->mapper("App\Batch")->save($batches);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($batches, new BatchTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Batch updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/batches/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["batches.all", "batches.delete"])) {
        throw new ForbiddenException("Token not allowed to delete batches.", 403);
    }
    /* Load existing batches using provided id */
    if (false === $batches = $this->spot->mapper("App\Batch")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Batch not found.", 404);
    };
    $this->spot->mapper("App\Batch")->delete($batches);
    $data["status"] = "ok";
    $data["message"] = "Batch deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});