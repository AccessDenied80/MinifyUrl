<?php
/**
 * Created by
 * Andrey D. Gluschenko
 * AccessDenied80@gmail.com
 */

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlForm;
use App\UseCases\ShortUrlService;
use Illuminate\Support\Facades\Redirect;

class ShortUrlController extends Controller
{
    /**
     * @param ShortUrlForm $request
     * @param ShortUrlService $shortUrlService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShortUrlForm $request, ShortUrlService $shortUrlService)
    {
        $validated = collect($request->validated());
        $shortUrl = $shortUrlService->create($validated);

        return redirect()
            ->route('index')
            ->with(['success' => 'Success created', 'shortUrl' => $shortUrl->short_url]);
    }

    /**
     * @param string $shortUrl
     * @param ShortUrlService $shortUrlService
     * @return \Illuminate\Http\RedirectResponse|\never
     */
    public function redirect(string $shortUrl, ShortUrlService $shortUrlService)
    {
        try {
            return Redirect::to($shortUrlService->originalUrlFromShort($shortUrl));
        } catch (\Throwable $e) {
            //dd($e->getMessage());
            return abort(404);
        }
    }

}