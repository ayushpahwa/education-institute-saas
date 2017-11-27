
<?php
 
use App\Test;
use App\TestTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/test", function ($request, $response, $arguments) {
   
 $test = $this->spot->mapper("App\Test")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($test, new TestTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/test", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["test.all", "test.create"])) {
        throw new ForbiddenException("Token not allowed to create test.", 403);
    }
    $body = $request->getParsedBody();
    $test = new Test($body);
    $this->spot->mapper("App\Test")->save($test);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($test, new TestTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New test created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/test/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["test.all", "test.read"])) {
        throw new ForbiddenException("Token not allowed to list test.", 403);
    }
    /* Load existing test using provided id */
    if (false === $test = $this->spot->mapper("App\Test")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Test not found.", 404);
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
    $resource = new Item($test, new TestTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/test/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["test.all", "test.update"])) {
        throw new ForbiddenException("Token not allowed to update test.", 403);
    }
    /* Load existing test using provided id */
    if (false === $test = $this->spot->mapper("App\Test")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Test not found.", 404);
    };
    $body = $request->getParsedBody();
    $test->data($body);
    $this->spot->mapper("App\Test")->save($test);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($test, new TestTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Test updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/test/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["test.all", "test.update"])) {
        throw new ForbiddenException("Token not allowed to update test.", 403);
    }
    /* Load existing test using provided id */
    if (false === $test = $this->spot->mapper("App\Test")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Test not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the test object first. */
    $test->clear();
    $test->data($body);
    $this->spot->mapper("App\Test")->save($test);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($test, new TestTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Test updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/test/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["test.all", "test.delete"])) {
        throw new ForbiddenException("Token not allowed to delete test.", 403);
    }
    /* Load existing test using provided id */
    if (false === $test = $this->spot->mapper("App\Test")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Test not found.", 404);
    };
    $this->spot->mapper("App\Test")->delete($test);
    $data["status"] = "ok";
    $data["message"] = "Test deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});