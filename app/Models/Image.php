<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';


    /**
     * @var array
     */
    protected $fillable = ['product_id', 'entity_type', 'thumbnail_image', 'medium_image', 'large_image'];

    /**
     * Get product this belongs to
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
