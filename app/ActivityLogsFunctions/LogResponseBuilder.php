<?php

namespace App\ActivityLogsFunctions;

class LogResponseBuilder
{
    private LogResponse $response;

    public function __construct(LogResponse $response)
    {
        $this->response = $response;
    }

    public function withName(string $name)
    {
        $this->response->setName($name);
        return $this;
    }

    public function withDescription(string $description)
    {
        $this->response->setDescription($description);
        return $this;
    }

    public function withEvent(?string $event)
    {
        $this->response->setEvent($event);
        return $this;
    }

    public function withProperties(array $properties)
    {
        $this->response->setProperties($properties);
        return $this;
    }

    public function withLevel(int $level)
    {
        $this->response->setLevel($level);
        return $this;
    }

    public function logging(): LogResponse
    {
        return $this->response;
    }

}
