<?php

namespace Dasumi\BaseApiWrapper;

class Snapshot
{
    protected $request;
    protected $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function handle($request, $response)
    {
        $snapshot = new self($request, $response);
        $snapshot->make();
    }

    public function make()
    {
        $filename = $this->filename();
        $this->makeDirectory($filename);
        $this->makeFile($filename, $this->response->getBody());
    }

    public function filename() : string
    {
        return 'snapshots/' . $this->request->getUri()->getPath() . '.json';
    }

    protected function makeDirectory(string $filename) : string
    {
        @mkdir(dirname($filename), 0755, true);

        return $filename;
    }

    protected function makeFile(string $filename, string $data)
    {
        file_put_contents($filename, $data);
    }
}