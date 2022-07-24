<?php
/**
 * Created by
 * Andrey D. Gluschenko
 * AccessDenied80@gmail.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortUrl extends Model
{
    use SoftDeletes;

    protected $table = 'short_urls';

    protected $fillable = ['original_url', 'short_url', 'is_unlimited_redirects', 'max_redirects', 'current_redirects_count', 'expired_at'];
}