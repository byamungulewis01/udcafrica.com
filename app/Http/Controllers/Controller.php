<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

abstract class Controller  extends BaseController
{
    protected function renderWithSeo(string $component, array $props = [], array $seoMeta = []): \Inertia\Response
    {
        $meta = SeoService::getMeta($seoMeta);

        return Inertia::render($component, array_merge($props, [
            'seo' => $meta
        ]));
    }
}
