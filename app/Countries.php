<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Countries as AppCountries;

class Countries extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', // Review for this user
        'code',
        'currency',
        'status',
    ];

    public static function generate(){
        $countries = AppCountries::all()->hydrate('currencies')->toArray();
        foreach ($countries as $country) {
            if(!isset($country)) continue;
            $query = new Countries();
            $query->fill([
                'name'=> isx($country['name']['common'],""),
                'code'=>isx($country['cca3'],""),
                'currency'=>"USD",
            ])->save();
        }
        return ["code"=>200,"message"=>"generate countries successfully"];
    }
}
