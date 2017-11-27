<?php

use App\Nortifications;
use App\NortificationsTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/Nortifications", function ($request, $response, $arguments) {
   
 $Nortifications = $this->spot->mapper("App\Nortifications")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($Nortifications, new NortificationsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/Nortifications", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["nortifications.all", "nortifications.create"])) {
        throw new ForbiddenException("Token not allowed to create Nortifications.", 403);
    }
    $body = $request->getParsedBody();
    $nortifications = new Nortifications($body);
    $this->spot->mapper("App\Nortifications")->save($nortifications);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($nortifications, new NortificationsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New nortifications created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/Nortifications/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["nortifications.all", "nortifications.read"])) {
        throw new ForbiddenException("Token not allowed to list Nortifications.", 403);
    }
    /* Load existing nortifications using provided id */
    if (false === $nortifications = $this->spot->mapper("App\Nortifications")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Nortifications not found.", 404);
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
    $resource = new Item($nortifications, new NortificationsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/Nortifications/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["nortifications.all", "nortifications.update"])) {
        throw new ForbiddenException("Token not allowed to update Nortifications.", 403);
    }
    /* Load existing nortifications using provided id */
    if (false === $nortifications = $this->spot->mapper("App\Nortifications")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Nortifications not found.", 404);
    };
    $body = $request->getParsedBody();
    $nortifications->data($body);
    $this->spot->mapper("App\Nortifications")->save($nortifications);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($nortifications, new NortificationsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Nortifications updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/Nortifications/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["nortifications.all", "nortifications.update"])) {
        throw new ForbiddenException("Token not allowed to update Nortifications.", 403);
    }
    /* Load existing nortifications using provided id */
    if (false === $nortifications = $this->spot->mapper("App\Nortifications")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Nortifications not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the nortifications object first. */
    $nortifications->clear();
    $nortifications->data($body);
    $this->spot->mapper("App\Nortifications")->save($nortifications);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($nortifications, new NortificationsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Nortifications updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/Nortifications/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["nortifications.all", "nortifications.delete"])) {
        throw new ForbiddenException("Token not allowed to delete Nortifications.", 403);
    }
    /* Load existing nortifications using provided id */
    if (false === $nortifications = $this->spot->mapper("App\Nortifications")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Nortifications not found.", 404);
    };
    $this->spot->mapper("App\Nortifications")->delete($nortifications);
    $data["status"] = "ok";
    $data["message"] = "Nortifications deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});