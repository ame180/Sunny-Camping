<?php


namespace App\Repositories\Eloquent;


use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\NullDefaultSupportTrait;

class EloquentRepository
{
    use NullDefaultSupportTrait;
    protected $notNullable;
    protected $defaultValues;
}
