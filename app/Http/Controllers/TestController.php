<?php

namespace App\Http\Controllers;

use App\Project;
use Languages;
use App\User;
use App\UserRenewals;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Countries\Package\Countries as AppCountries;
// use App\Countries;

class TestController extends BaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return Project::whereNotIn('id',[1])->where(['seller_id'=>2])->first();
    }
}
