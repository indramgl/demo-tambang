<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    private const PAGE_MAP = [
        'home'          => ['Beranda', 'home'],
        'history'       => ['Sejarah', 'history'],
        'vision-mission'=> ['Visi & Misi', 'vision-mission'],
        'services'      => ['Layanan', 'services'],
        'contact'       => ['Kontak', 'contact'],
        'portfolio'     => ['Portofolio', 'portfolio'],
        'investor'      => ['Investor', 'investor'],
        'about'          => ['Tentang Kami', 'about'],
    ];

    public function index(): string
    {
        return $this->page('home');
    }

    public function page(string $slug = 'home'): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';

        if (! isset(self::PAGE_MAP[$slug])) {
            throw PageNotFoundException::forPageNotFound();
        }

        [$title, $view] = self::PAGE_MAP[$slug];

        $localeUrls = [];
        foreach (['id', 'en', 'zh', 'fr', 'es', 'ja'] as $loc) {
            $localeUrls[$loc] = $this->localeUrl($loc);
        }

        $this->cachePage(3600);

        return view("pages/{$view}", [
            'title' => $title,
            'locale' => $locale,
            'localeUrls' => $localeUrls,
        ]);
    }

    protected function localeUrl(string $locale): string
    {
        $uri = service('uri');
        $uri->setSegment(1, $locale);

        return base_url($uri->getPath());
    }
}
