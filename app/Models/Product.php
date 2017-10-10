<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';


    /**
     * @var array
     */
    protected $fillable = ['item_id'];

    /**
     * Get images this has
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

}
