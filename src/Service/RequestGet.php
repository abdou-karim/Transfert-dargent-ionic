<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\Request;

class RequestGet
{
    public function getRequest(Request $request)
    {
        $requ = json_decode($request->getContent(), true);
        return $requ;
    }
}