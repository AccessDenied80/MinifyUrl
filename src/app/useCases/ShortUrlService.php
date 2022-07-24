<?php
namespace App\UseCases;

use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Created by
 * Andrey D. Gluschenko
 * AccessDenied80@gmail.com
 */
class ShortUrlService
{
    /**
     * @var
     */
    protected $shortUrl;

    /**
     * @param Collection $data
     * @return ShortUrl
     */
    public function create(Collection $data): ShortUrl
    {
        return ShortUrl::create([
            'original_url' => $data['original_url'],
            'short_url' => Str::random(8),
            'is_unlimited_redirects' => (int)$data['max_redirects'] === 0,
            'max_redirects' => (int)$data['max_redirects'],
            'expired_at' => Carbon::now()->addMinutes((int)$data['expired_limit'])
        ]);
    }

    /**
     * @param string $shortUrl
     * @return string
     */
    public function originalUrlFromShort(string $shortUrl): string
    {
        $this->shortUrl = ShortUrl::withoutTrashed()->where(['short_url' => $shortUrl])->firstOrFail();

        $this->checkTimeExpired();
        $this->checkRedirectsExpired();
        $this->incrementRedirectsCount();

        return $this->shortUrl->original_url;
    }

    protected function checkTimeExpired()
    {
        if ($this->shortUrl->expired_at < Carbon::now()) {
            $this->shortUrl->delete();
            throw new \DomainException('Short url time expired');
        }
    }

    protected function checkRedirectsExpired()
    {
        if (!$this->shortUrl->is_unlimited_redirects && $this->shortUrl->current_redirects_count >= $this->shortUrl->max_redirects) {
            $this->shortUrl->delete();
            throw new \DomainException('Short url redirects expired');
        }
    }

    protected function incrementRedirectsCount()
    {
        $this->shortUrl->increment('current_redirects_count');
    }
}