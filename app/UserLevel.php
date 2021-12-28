<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    
    public $table = "user_level";

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const TYPE_ADMIN = 'admin';
    const TYPE_CLIENT = 'client';
    const TYPE_FREELANCER = 'freelancer';
    const TYPE_COPYWRITER = 'copywriter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'levelType', // static
        'name',
        'description',
        'menu_role',
        'status',
    ];
    
     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'menu_role' => 'array',
    ];

    public static $mrMenuRole = [
        'Marketplace'=> 'Marketplace',
        "Order"=>"My Order",
        "BrowseJobs"=>"Browse Jobs",
        'Financial'=> 'Financial',
        'Affiliate'=> 'Affiliate',
        'Messanges'=> 'Messanges',
        'BrowseCopywriter'=> 'Browse Copywriters',
        'Members'=> 'Members',
        "Projects"=>"Projects",
        'CategoryEditor'=> 'Category Editor',
        'TaxOffices'=> 'Tax Offices',
        'Countries'=> 'Countries',
        'BonusCode'=> 'Bonus Code',
        'Disputes'=> 'Disputes',
        'AllMessages'=> 'All Messages',
        'Documents'=> 'Documents',
        'Statistics'=> 'Statistics',
        'UserManager'=> 'User Manager',
        'UserLevel'=> 'User Level',
        'ServiceLogs'=> 'Service Logs',
        'SettingGlobal'=> 'Setting Global',
        'SettingsGlobal'=> 'Settings Global',
    ];

    public static $clientMenuRole = [
        'Marketplace'=> 'Marketplace',
        "Order"=>"My Order",
        'Financial'=> 'Financial',
        'Affiliate'=> 'Affiliate',
        'Messanges'=> 'Messanges',
        'BrowseCopywriter'=> 'Browse Copywriters',
    ];

    public static $copywriterMenuRole = [
        'Marketplace'=> 'Marketplace',
        "BrowseJobs"=>"Browse Jobs",
        'Financial'=> 'Financial',
        'Affiliate'=> 'Affiliate',
        'Messanges'=> 'Messanges',
    ];

    public static $adminMenuRole = [
        'Members'=> 'Members',
        "Projects"=>"Projects",
        'CategoryEditor'=> 'Category Editor',
        'TaxOfficer'=> 'Tax Officer',
        'Countries'=> 'Countries',
        'BonusCode'=> 'Bonus Code',
        'Marketplace'=> 'Marketplace',
        'Disputes'=> 'Disputes',
        'AllMessages'=> 'All Messages',
        'Documents'=> 'Documents',
        'Financial'=> 'Financial',
        'Statistics'=> 'Statistics',
        'UserManager'=> 'User Manager',
        'UserLevel'=> 'User Level',
        'ServiceLogs'=> 'Service Logs',
        'SettingGlobal'=> 'Setting Global',
        'SettingsGlobal'=> 'Settings Global',
    ];
}
