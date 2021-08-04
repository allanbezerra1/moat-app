<?php

namespace App\Services;

use App\Repository\AlbumRepositoryInterface;
use App\Models\Album;

class AlbumService
{
    protected $albumRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function All()
    {
        return $this->albumRepository->All();
    }

    public function FindById(int $id)
    {
        return $this->albumRepository->findById($id);
    }
    public function create(array $data)
    {

        return $this->albumRepository->create($data);
    }

    public function update(int $id, array $data)
    {


        $albumTasks = Album::with('tasks')->find($id);
        foreach ($albumTasks->tasks as  $value) {
            if ( $data['status'] =='done' && $value->status != 'done'){
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry , It is not possible to complete the album as there are still pending tasks',
                ],400);
            }
        }
        $this->albumRepository->update($id, $data);
        return response()->json(['message' => 'User Updated'], 200);
    }

    public function destroy(int $id)
    {
        $this->albumRepository->deleteById($id);
        return response()->json(['message' => 'User Deleted'], 200);
    }
}
