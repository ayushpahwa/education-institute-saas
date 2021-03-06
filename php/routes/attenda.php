<?php
 
use App\Attenda;
use App\AttendaTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/attendas", function ($request, $response, $arguments) {
   
 $attendas = $this->spot->mapper("App\Attenda")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($attendas, new AttendaTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/attendas", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["attenda.all", "attenda.create"])) {
        throw new ForbiddenException("Token not allowed to create attendas.", 403);
    }
    $body = $request->getParsedBody();
    $attenda = new Attenda($body);
    $this->spot->mapper("App\Attenda")->save($attenda);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($attenda, new AttendaTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New attenda created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/attendas/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["attenda.all", "attenda.read"])) {
        throw new ForbiddenException("Token not allowed to list attendas.", 403);
    }
    /* Load existing attenda using provided id */
    if (false === $attenda = $this->spot->mapper("App\Attenda")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Attenda not found.", 404);
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
    $resource = new Item($attenda, new AttendaTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/attendas/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["attenda.all", "attenda.update"])) {
        throw new ForbiddenException("Token not allowed to update attendas.", 403);
    }
    /* Load existing attenda using provided id */
    if (false === $attenda = $this->spot->mapper("App\Attenda")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Attenda not found.", 404);
    };
    $body = $request->getParsedBody();
    $attenda->data($body);
    $this->spot->mapper("App\Attenda")->save($attenda);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($attenda, new AttendaTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Attenda updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/attendas/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["attenda.all", "attenda.update"])) {
        throw new ForbiddenException("Token not allowed to update attendas.", 403);
    }
    /* Load existing attenda using provided id */
    if (false === $attenda = $this->spot->mapper("App\Attenda")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Attenda not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the attenda object first. */
    $attenda->clear();
    $attenda->data($body);
    $this->spot->mapper("App\Attenda")->save($attenda);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($attenda, new AttendaTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Attenda updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/attendas/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["attenda.all", "attenda.delete"])) {
        throw new ForbiddenException("Token not allowed to delete attendas.", 403);
    }
    /* Load existing attenda using provided id */
    if (false === $attenda = $this->spot->mapper("App\Attenda")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Attenda not found.", 404);
    };
    $this->spot->mapper("App\Attenda")->delete($attenda);
    $data["status"] = "ok";
    $data["message"] = "Attenda deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});