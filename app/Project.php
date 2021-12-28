<?php

namespace App;

use App\Http\Traits\Hashidable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Hashidable;

    const STATUS_OPEN = 'open';
    const STATUS_SKETCH = 'sketch';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_PENDING = 'pending';
    const STATUS_CHECKING_PLAGIARISM = 'checking_plagiarism';
    const STATUS_REJECTED = 'rejected';
    const STATUS_AMENDMENT = 'amendment';
    const STATUS_WRITTEN = 'written';

    const PLAGIARISM_STATUS_PENDING = 1;
    const PLAGIARISM_STATUS_CHECKED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'order_id',
        'seller_id',
        'title',
        'seller_title',
        'amendment_comment',
        'description',
        'min_chars',
        'rate',
        'cp_write_title',
        'cp_bold_keyword',
        'payment_method',
        'quality',
        'status',
        'notified_not_reserved',
        'budget',
        'text',
        'language',
        'plagiarism_status',
        'unique_percent',
        'rated',
        'reserved_at',
    ];

    public $guarded = ['cp_write_title', 'cp_bold_keyword'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reserved_at' => 'datetime',
    ];

    public function getBudgetAttribute($value)
    {
        return roundPrice($value);
    }

    public function isCanBeAcceptedByClient()
    {
        return $this->status == self::STATUS_PENDING && ! empty($this->seller_title) && ! empty($this->text);
    }

    public function getDeadLineExtraMinutes()
    {
        foreach (config('settings.project_time_to_complete') as $letters => $time) {
            if ($letters >= $this->min_chars) {
                return $time;
            }
        }

        return config('settings.project_time_to_complete_max');
    }

    public function getDeadLineDate()
    {
        return $this->reserved_at ? $this->reserved_at->addMinutes($this->getDeadLineExtraMinutes()) : null;
    }

    public function doSellerJumpOut()
    {
        $this->update(['seller_id' => null, 'status' => Project::STATUS_OPEN, 'reserved_at' => null]);
    }

    public function getRate()
    {
        return (float)str_replace(',', '.', $this->budget) / ($this->min_chars / 100);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->user();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

}
