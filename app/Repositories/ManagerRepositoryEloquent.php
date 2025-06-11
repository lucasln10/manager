<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ManagerRepository;
use App\Entities\Manager;
use App\Validators\ManagerValidator;

/**
 * Class ManagerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ManagerRepositoryEloquent extends BaseRepository implements ManagerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Manager::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
