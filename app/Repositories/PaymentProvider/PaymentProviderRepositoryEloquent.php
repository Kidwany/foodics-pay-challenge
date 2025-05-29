<?php

namespace App\Repositories\PaymentProvider;

use App\Models\PaymentProvider;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PaymentProviderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentProviderRepositoryEloquent extends BaseRepository implements PaymentProviderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PaymentProvider::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getProviderByCode(string $code)
    {
        return $this->model->query()->where('code', $code)->select('id', 'code')->first();
    }
}
