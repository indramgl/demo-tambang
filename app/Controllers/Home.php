<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Beranda';
        $content = $this->getRenderedContent('home', $locale);

        return view('pages/home', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    public function history(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Sejarah';
        $content = $this->getRenderedContent('history', $locale);

        return view('pages/history', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    public function visionMission(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Visi & Misi';
        $content = $this->getRenderedContent('vision-mission', $locale);

        return view('pages/vision-mission', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    public function services(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Layanan';
        $content = $this->getRenderedContent('services', $locale);

        return view('pages/services', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    public function contact(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Kontak';
        $content = $this->getRenderedContent('contact', $locale);

        return view('pages/contact', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    public function portfolio(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Portofolio';
        $content = $this->getRenderedContent('portfolio', $locale);

        return view('pages/portfolio', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    public function investor(): string
    {
        $locale = $this->request->getSegment(1) ?? 'id';
        $title = 'Investor Relation';
        $content = $this->getRenderedContent('investor', $locale);

        return view('pages/investor', [
            'title' => $title,
            'locale' => $locale,
            'content' => $content,
        ]);
    }

    private function getRenderedContent(string $page, string $locale): string
    {
        $filePath = FCPATH . 'content/' . $page . '/' . strtolower($locale) . '.html';

        if (is_file($filePath)) {
            return file_get_contents($filePath);
        }

        return '';
    }
}
