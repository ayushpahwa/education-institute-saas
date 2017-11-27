<?php
 
use App\Subjects;
use App\SubjectsTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/Subjects", function ($request, $response, $arguments) {
   
 $Subjects = $this->spot->mapper("App\Subjects")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($Subjects, new SubjectsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/Subjects", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Subjects.all", "Subjects.create"])) {
        throw new ForbiddenException("Token not allowed to create Subjects.", 403);
    }
    $body = $request->getParsedBody();
    $Subjects = new Subjects($body);
    $this->spot->mapper("App\Subjects")->save($Subjects);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($Subjects, new SubjectsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New Subjects created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/Subjects/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Subjects.all", "Subjects.read"])) {
        throw new ForbiddenException("Token not allowed to list Subjects.", 403);
    }
    /* Load existing Subjects using provided id */
    if (false === $Subjects = $this->spot->mapper("App\Subjects")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Subjects not found.", 404);
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
    $resource = new Item($Subjects, new SubjectsTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/Subjects/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Subjects.all", "Subjects.update"])) {
        throw new ForbiddenException("Token not allowed to update Subjects.", 403);
    }
    /* Load existing Subjects using provided id */
    if (false === $Subjects = $this->spot->mapper("App\Subjects")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Subjects not found.", 404);
    };
    $body = $request->getParsedBody();
    $Subjects->data($body);
    $this->spot->mapper("App\Subjects")->save($Subjects);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($Subjects, new SubjectsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Subjects updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/Subjects/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Subjects.all", "Subjects.update"])) {
        throw new ForbiddenException("Token not allowed to update Subjects.", 403);
    }
    /* Load existing Subjects using provided id */
    if (false === $Subjects = $this->spot->mapper("App\Subjects")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Subjects not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the Subjects object first. */
    $Subjects->clear();
    $Subjects->data($body);
    $this->spot->mapper("App\Subjects")->save($Subjects);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($Subjects, new SubjectsTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Subjects updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/Subjects/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["Subjects.all", "Subjects.delete"])) {
        throw new ForbiddenException("Token not allowed to delete Subjects.", 403);
    }
    /* Load existing Subjects using provided id */
    if (false === $Subjects = $this->spot->mapper("App\Subjects")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Subjects not found.", 404);
    };
    $this->spot->mapper("App\Subjects")->delete($Subjects);
    $data["status"] = "ok";
    $data["message"] = "Subjects deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});