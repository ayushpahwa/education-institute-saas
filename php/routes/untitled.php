
<?php
 
use App\Inquiry;
use App\InquiryTransformer;
use Exception\NotFoundException;
use Exception\ForbiddenException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
$app->get("/inquiry", function ($request, $response, $arguments) {
   
 $inquiry = $this->spot->mapper("App\Inquiry")
        ->all()//->with('students')
        ;
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Collection($inquiry, new InquiryTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->post("/inquiry", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["inquiry.all", "inquiry.create"])) {
        throw new ForbiddenException("Token not allowed to create inquiry.", 403);
    }
    $body = $request->getParsedBody();
    $inquiry = new Inquiry($body);
    $this->spot->mapper("App\Inquiry")->save($inquiry);
    /* Serialize the response data. */
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($inquiry, new InquiryTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "New inquiry created";
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->withHeader("Location", $data["data"]["links"]["self"])
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->get("/inquiry/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["inquiry.all", "inquiry.read"])) {
        throw new ForbiddenException("Token not allowed to list inquiry.", 403);
    }
    /* Load existing inquiry using provided id */
    if (false === $inquiry = $this->spot->mapper("App\Inquiry")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Inquiry not found.", 404);
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
    $resource = new Item($inquiry, new InquiryTransformer);
    $data = $fractal->createData($resource)->toArray();
    return $response->withStatus(200)
        ->withHeader("Content-Type", "appliaction/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->patch("/inquiry/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["inquiry.all", "inquiry.update"])) {
        throw new ForbiddenException("Token not allowed to update inquiry.", 403);
    }
    /* Load existing inquiry using provided id */
    if (false === $inquiry = $this->spot->mapper("App\Inquiry")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Inquiry not found.", 404);
    };
    $body = $request->getParsedBody();
    $inquiry->data($body);
    $this->spot->mapper("App\Inquiry")->save($inquiry);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($inquiry, new InquiryTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Inquiry updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->put("/inquiry/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["inquiry.all", "inquiry.update"])) {
        throw new ForbiddenException("Token not allowed to update inquiry.", 403);
    }
    /* Load existing inquiry using provided id */
    if (false === $inquiry = $this->spot->mapper("App\Inquiry")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Inquiry not found.", 404);
    };
    /* PUT requires If-Unmodified-Since or If-Match request header to be present. */
    if (false === $this->cache->hasStateValidator($request)) {
        throw new PreconditionRequiredException("PUT request is required to be conditional.", 428);
    }
    $body = $request->getParsedBody();
    /* PUT request assumes full representation. If any of the properties is */
    /* missing set them to default values by clearing the inquiry object first. */
    $inquiry->clear();
    $inquiry->data($body);
    $this->spot->mapper("App\Inquiry")->save($inquiry);
    $fractal = new Manager();
    $fractal->setSerializer(new DataArraySerializer);
    $resource = new Item($inquiry, new InquiryTransformer);
    $data = $fractal->createData($resource)->toArray();
    $data["status"] = "ok";
    $data["message"] = "Inquiry updated";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
$app->delete("/inquiry/{id}", function ($request, $response, $arguments) {
    /* Check if token has needed scope. */
    if (true === $this->token->hasScope(["inquiry.all", "inquiry.delete"])) {
        throw new ForbiddenException("Token not allowed to delete inquiry.", 403);
    }
    /* Load existing inquiry using provided id */
    if (false === $inquiry = $this->spot->mapper("App\Inquiry")->first([
        "id" => $arguments["id"]
    ])) {
        throw new NotFoundException("Inquiry not found.", 404);
    };
    $this->spot->mapper("App\Inquiry")->delete($inquiry);
    $data["status"] = "ok";
    $data["message"] = "Inquiry deleted";
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});