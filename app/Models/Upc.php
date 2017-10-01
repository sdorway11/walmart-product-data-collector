<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upc extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upcs';

    /**
     * @var string
     */
    protected $fillable = ['upc'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
