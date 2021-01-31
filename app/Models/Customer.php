<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property int $country_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @method static Builder|Customer active()
 * @method static Builder|Customer filter($filters)
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereActive($value)
 * @method static Builder|Customer whereCountryId($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereMobile($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded= ['id'];

    protected $fillable = ['name', 'mobile', 'email', 'country_id', 'active'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereActive(1);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
