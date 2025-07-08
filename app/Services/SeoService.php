<?php
namespace App\Services;

class SeoService
{
    public static function getDefaultMeta(): array
    {
        return [
            'title' => config('app.name') . " | " . "Design and Construction Company in Rwanda",
            'description' => 'UDC Africa is a trusted design and construction company in Rwanda, delivering innovative, sustainable solutions for residential, commercial, and institutional projects.',
            'keywords' => 'UDC Africa, construction company Rwanda, design and build Rwanda, residential construction, commercial building Rwanda, architecture Rwanda, building contractor Rwanda, construction services Rwanda, building design Rwanda, construction management Rwanda, construction company Rwanda, construction company Rwanda, construction company Rwanda',
            'author' => 'UDC Africa',
            'robots' => 'index, follow',
            'canonical' => url()->current(),
            'og:title' => config('app.name') . " | " . "Design and Construction Company in Rwanda",
            'og:description' => 'UDC Africa is a trusted design and construction company in Rwanda, delivering innovative, sustainable solutions for residential, commercial, and institutional projects.',
            'og:image' => asset('/udc-africa-opengraph.jpg'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'og:site_name' => config('app.name'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => config('app.name') . " | " . "Design and Construction Company in Rwanda",
            'twitter:description' => 'UDC Africa is a trusted design and construction company in Rwanda, delivering innovative, sustainable solutions for residential, commercial, and institutional projects.',
            'twitter:image' => asset('/udc-africa-opengraph.jpg'),
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