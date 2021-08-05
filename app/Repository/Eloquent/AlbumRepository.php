<?php

namespace App\Repository\Eloquent;

use App\Models\Album;
use App\Repository\AlbumRepositoryInterface;

class AlbumRepository extends BaseRepository implements AlbumRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Album $model)
    {
        $this->model = $model;
    }
}
