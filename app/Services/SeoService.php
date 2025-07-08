<?php
namespace App\Services;

class SeoService
{
    public static function getDefaultMeta(): array
    {
        return [
            'title' => config('app.name') . " | " . " Innovative Architecture Design Firm",
            'description' => 'Innovative Architecture Design Firm',
            'keywords' => 'Innovative Architecture Design Firm',
            'author' => 'UCC Africa',
            'robots' => 'index, follow',
            'canonical' => url()->current(),
            'og:title' => config('app.name') . " | " . " Innovative Architecture Design Firm",
            'og:description' => 'Innovative Architecture Design Firm',
            'og:image' => asset('resilience-opengraph.jpeg'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'og:site_name' => config('app.name'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => config('app.name') . " | " . " Innovative Architecture Design Firm",
            'twitter:description' => 'Innovative Architecture Design Firm',
            'twitter:image' => asset('resilience-opengraph.jpeg'),
        ];
    }

    public static function getMeta(array $meta = []): array
    {
        $defaultMeta = self::getDefaultMeta();

        // Merge with provided meta, giving priority to provided values
        $mergedMeta = array_merge($defaultMeta, $meta);

        // Update Open Graph and Twitter meta based on main meta
        if (isset($meta['title'])) {
            $mergedMeta['og:title'] = $meta['title'];
            $mergedMeta['twitter:title'] = $meta['title'];
        }

        if (isset($meta['description'])) {
            $mergedMeta['og:description'] = $meta['description'];
            $mergedMeta['twitter:description'] = $meta['description'];
        }

        if (isset($meta['image'])) {
            $mergedMeta['og:image'] = $meta['image'];
            $mergedMeta['twitter:image'] = $meta['image'];
        }

        return $mergedMeta;
    }
}