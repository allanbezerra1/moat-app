<?php

namespace App\Repository\Eloquent;

use App\Models\Project;
use App\Repository\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
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
    public function __construct(Project $model)
    {
        $this->model = $model;
    }
}
