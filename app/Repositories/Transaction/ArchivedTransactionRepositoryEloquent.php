<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\ArchivedTransaction;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ArchivedTransactionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ArchivedTransactionRepositoryEloquent extends BaseRepository implements ArchivedTransactionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ArchivedTransaction::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
