<?php

namespace App;

use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Languages;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    const TYPE_ADMIN = 'admin';
    const TYPE_CLIENT = 'client';
    const TYPE_FREELANCER = 'freelancer';
    const TYPE_COPYWRITER = 'copywriter';

    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_REJECT = 'reject';
    const STATUS_BANNED = 'banned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'first_name',
        'last_name',
        'email',
        'phone_prefix',
        'phone',
        'password',
        'rate',
        'accepted',
        'declined',
        'userType',
        'isCompany',
        'companyName',
        'apartment_number',
        'street',
        'city',
        'post_code',
        'comp_apartment_number',
        'comp_street',
        'comp_city',
        'comp_post_code',
        'bank_account',
        'tax_office_id',
        'country_id',
        'level_id',
        'about',
        'rate_positive',
        'rate_negative',
        'status',
        'request_string',
        'vat_number',
        'affiliate_code',
        'affiliated',
        'locale',
        'languages',
        'menu_role',
    ];

    protected $guarded = ['password_confirmation', 'terms', 'fname', 'lname'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'languages' => 'array',
        'menu_role' => 'array',
    ];


    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)->send(new ResetPasswordMail($this, $token));
    }

    public function getFullnameAttribute($value)
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getPublicId()
    {
        return str_pad($this->id, 6, STR_PAD_LEFT, '0');
    }

    public function getICRate()
    {
        if($this->declined<1&&$this->accepted<1) return 0;
        return $this->accepted / ($this->accepted + $this->declined) * 100;
    }

    public function getICRateText()
    {
        return round($this->getICRate(), 2).'%';
    }

    public function getCategoriesTitle()
    {
        return $this->categories->implode('title', ' | ');
    }

    public function getLanguagesTitle()
    {
        $mrlanguages = Languages::lookup();
        $languages = [];
        foreach (isset($this->languages)?$this->languages:[] as $value) {
            if(!isset($mrlanguages[$value])) continue;
            $languages[] = $mrlanguages[$value];
        }
        return implode(' | ',$languages);
    }

    public function isCanAddFunds()
    {
        return ! empty($this->first_name)
               && ! empty($this->last_name)
               && ! empty($this->email)
               && ! empty($this->phone)
               && ! empty($this->street)
               && ! empty($this->city)
               && ! empty($this->post_code)
               && ! empty($this->apartment_number);
    }

    public function getAddress()
    {
        if($this->isCompany) return $this->comp_street.', '.$this->comp_apartment_number.' '.$this->comp_city;
        return $this->street.', '.$this->apartment_number.' '.$this->city;
    }

    public function role()
    {
        $id = Auth::user()->level_id;
        $level = UserLevel::find($id);
        return $level['levelType']?:"";
    }

    public function menuRole()
    {
        $id = Auth::user()->level_id;
        $level = UserLevel::find($id);
        return $level['menu_role']?:[];
    }

    public function getStatus()
    {
        return auth()->user()->status;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function country()
    {
        // return $this->hasOne(Countries::class,'id', 'country_id');
        return $this->belongsTo('App\Countries', 'country_id');
    }

    public function wallet_lock()
    {
        return $this->belongsTo(WalletLock::class);
    }

    public function tax_office()
    {
        return $this->taxOffice();
    }

    public function taxOffice()
    {
        return $this->hasOne(Taxoffice::class, 'id', 'tax_office_id');
    }

    public function scopeUserLevel($q)
    {
        return $q->leftjoin('user_level', function($join) {
            $join->on('users.level_id', '=',  'user_level.id');
        })->select('users.*','user_level.levelType','user_level.menu_role');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function userRates()
    {
        return $this->hasMany(UserRate::class);
    }

    public function reviews()
    {
        return $this->copywriterReviews();
    }

    public function copywriterReviews()
    {
        return $this->hasMany(CopywriterReview::class);
    }

    public function setLocale($locale){
        return $this->update(['locale'=>$locale]);
    }

    public static function generateAffiliate(){
        $users = User::get();
        foreach ($users as $user) {
            if($user->affiliate_code) continue;
            $code = generateRandomString(3).$user->id.generateRandomString(3);
            $user->update(['affiliate_code'=>$code]);
        }
        return ['code'=>200,'message'=>'success'];
    }
    /* affiliate single */
    public function generateCode(){
        if($this->affiliate_code) return;
        $code = generateRandomString(3).$this->id.generateRandomString(3);
        $this->update(['affiliate_code'=>$code]);
        return ['code'=>200,'message'=>'success'];
    }
}
