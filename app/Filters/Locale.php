<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Locale implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $locale = $request->getUri()->getSegment(1);

        $supported = ['id', 'en', 'zh', 'fr', 'es', 'ja'];

        if (! in_array($locale, $supported, true)) {
            return redirect()->to('/id/');
        }

        $request->setLocale($locale);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
