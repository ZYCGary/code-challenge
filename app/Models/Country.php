<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = ['country'];

    public $timestamps = false;
}
