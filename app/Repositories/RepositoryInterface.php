<?php


namespace App\Repositories;


use phpDocumentor\Reflection\Types\Integer;

interface RepositoryInterface
{
    public function all();

    public function show($id);

    public function create(array $data);

    public function update(array $data, int $id);

    public function with($relation);
}
