<?php
 
use App\Students;
use App\StudentsTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/Students", function ($request, $response, $arguments) {
   
 $Students = $this->spot->mapper("App\Students")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($Students, new StudentsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/Students", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Students.all", "Students.create"])) {
        throw new ForbiddenException("Token not allowed to create Students.", 403);
    }
    $body = $request->getParsedBody();
    $Students = new Students($body);
    $this->spot->mapper("App\Students")->save($Students);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($Students, new StudentsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New Students created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/Students/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Students.all", "Students.read"])) {
        throw new ForbiddenException("Token not allowed to list Students.", 403);
    }
    /* Load existing Students using provided id */
    if (false === $Students = $this->spot->mapper("App\Students")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Students not found.", 404);
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
    $resource = new Item($Students, new StudentsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/Students/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Students.all", "Students.update"])) {
        throw new ForbiddenException("Token not allowed to update Students.", 403);
    }
    /* Load existing Students using provided id */
    if (false === $Students = $this->spot->mapper("App\Students")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Students not found.", 404);
    };
    $body = $request->getParsedBody();
    $Students->data($body);
    $this->spot->mapper("App\Students")->save($Students);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($Students, new StudentsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Students updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/Students/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Students.all", "Students.update"])) {
        throw new ForbiddenException("Token not allowed to update Students.", 403);
    }
    /* Load existing Students using provided id */
    if (false === $Students = $this->spot->mapper("App\Students")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Students not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the Students object first. */
    $Students->clear();
    $Students->data($body);
    $this->spot->mapper("App\Students")->save($Students);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($Students, new StudentsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Students updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/Students/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Students.all", "Students.delete"])) {
        throw new ForbiddenException("Token not allowed to delete Students.", 403);
    }
    /* Load existing Students using provided id */
    if (false === $Students = $this->spot->mapper("App\Students")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Students not found.", 404);
    };
    $this->spot->mapper("App\Students")->delete($Students);
    $data["status"] = "ok";
    $data["message"] = "Students deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});