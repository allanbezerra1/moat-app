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

    public function Artist(){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://moat.ai/api/task/',
            ['headers' => ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==',
            'Content-Type' => 'application/json',
            ]
        ]);
        $newArtist =[];
        foreach (json_decode($response->getBody()) as  $value) {
            $newArtist[] =$value[0];
        }
        return $newArtist;
    }

    public function ArtistDetails($id){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://moat.ai/api/task/?id=2',
            ['headers' => ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==',
            'Content-Type' => 'application/json',
            ]
        ]);
         $newArtist =json_decode($response->getBody());

         return $newArtist;
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
        return $this->albumRepository->update($id, $data);
    }

    public function destroy(int $id)
    {
        return  $this->albumRepository->deleteById($id);
    }
}
