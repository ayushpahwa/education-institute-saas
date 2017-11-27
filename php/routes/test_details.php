<?php
 
use App\TestDetails;
use App\TestDetailsTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/TestDetails", function ($request, $response, $arguments) {
   
 $TestDetails = $this->spot->mapper("App\TestDetails")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($TestDetails, new TestDetailsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/TestDetails", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["TestDetails.all", "TestDetails.create"])) {
        throw new ForbiddenException("Token not allowed to create TestDetails.", 403);
    }
    $body = $request->getParsedBody();
    $TestDetails = new TestDetails($body);
    $this->spot->mapper("App\TestDetails")->save($TestDetails);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($TestDetails, new TestDetailsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New TestDetails created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/TestDetails/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["TestDetails.all", "TestDetails.read"])) {
        throw new ForbiddenException("Token not allowed to list TestDetails.", 403);
    }
    /* Load existing TestDetails using provided id */
    if (false === $TestDetails = $this->spot->mapper("App\TestDetails")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("TestDetails not found.", 404);
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
    $resource = new Item($TestDetails, new TestDetailsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/TestDetails/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["TestDetails.all", "TestDetails.update"])) {
        throw new ForbiddenException("Token not allowed to update TestDetails.", 403);
    }
    /* Load existing TestDetails using provided id */
    if (false === $TestDetails = $this->spot->mapper("App\TestDetails")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("TestDetails not found.", 404);
    };
    $body = $request->getParsedBody();
    $TestDetails->data($body);
    $this->spot->mapper("App\TestDetails")->save($TestDetails);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($TestDetails, new TestDetailsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "TestDetails updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/TestDetails/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["TestDetails.all", "TestDetails.update"])) {
        throw new ForbiddenException("Token not allowed to update TestDetails.", 403);
    }
    /* Load existing TestDetails using provided id */
    if (false === $TestDetails = $this->spot->mapper("App\TestDetails")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("TestDetails not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the TestDetails object first. */
    $TestDetails->clear();
    $TestDetails->data($body);
    $this->spot->mapper("App\TestDetails")->save($TestDetails);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($TestDetails, new TestDetailsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "TestDetails updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/TestDetails/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["TestDetails.all", "TestDetails.delete"])) {
        throw new ForbiddenException("Token not allowed to delete TestDetails.", 403);
    }
    /* Load existing TestDetails using provided id */
    if (false === $TestDetails = $this->spot->mapper("App\TestDetails")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("TestDetails not found.", 404);
    };
    $this->spot->mapper("App\TestDetails")->delete($TestDetails);
    $data["status"] = "ok";
    $data["message"] = "TestDetails deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});