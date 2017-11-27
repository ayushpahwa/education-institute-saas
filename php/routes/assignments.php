<?php
 
use App\College;
use App\CollegeTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/assignments", function ($request, $response, $arguments) {
   
 $assignments = $this->spot->mapper("App\College")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($assignments, new CollegeTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/assignments", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["assignment.all", "assignment.create"])) {
        throw new ForbiddenException("Token not allowed to create assignments.", 403);
    }
    $body = $request->getParsedBody();
    $assignment = new College($body);
    $this->spot->mapper("App\College")->save($assignment);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($assignment, new CollegeTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New assignment created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/assignments/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["assignment.all", "assignment.read"])) {
        throw new ForbiddenException("Token not allowed to list assignments.", 403);
    }
    /* Load existing assignment using provided id */
    if (false === $assignment = $this->spot->mapper("App\College")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("College not found.", 404);
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
    $resource = new Item($assignment, new CollegeTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/assignments/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["assignment.all", "assignment.update"])) {
        throw new ForbiddenException("Token not allowed to update assignments.", 403);
    }
    /* Load existing assignment using provided id */
    if (false === $assignment = $this->spot->mapper("App\College")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("College not found.", 404);
    };
    $body = $request->getParsedBody();
    $assignment->data($body);
    $this->spot->mapper("App\College")->save($assignment);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($assignment, new CollegeTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "College updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/assignments/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["assignment.all", "assignment.update"])) {
        throw new ForbiddenException("Token not allowed to update assignments.", 403);
    }
    /* Load existing assignment using provided id */
    if (false === $assignment = $this->spot->mapper("App\College")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("College not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the assignment object first. */
    $assignment->clear();
    $assignment->data($body);
    $this->spot->mapper("App\College")->save($assignment);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($assignment, new CollegeTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "College updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/assignments/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["assignment.all", "assignment.delete"])) {
        throw new ForbiddenException("Token not allowed to delete assignments.", 403);
    }
    /* Load existing assignment using provided id */
    if (false === $assignment = $this->spot->mapper("App\College")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("College not found.", 404);
    };
    $this->spot->mapper("App\College")->delete($assignment);
    $data["status"] = "ok";
    $data["message"] = "College deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});