<?php


namespace App\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;
use App\Repositories;

class BaseRepository
{
    use Repositories\NullDefaultSupportTrait;
    protected $notNullable;
    protected $defaultValues;
}
