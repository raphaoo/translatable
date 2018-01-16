<?php

namespace Pine\Translatable\Tests;

use Illuminate\Database\Eloquent\Model;
use Pine\Translatable\Translatable as TranslatableTrait;

class Translatable extends Model
{
    use TranslatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'title',
    ];
}
