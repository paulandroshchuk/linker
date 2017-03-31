<?php

namespace App\Http\Controllers\Client;

use App\Models\Link;
use App\Jobs\CreateLinkJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateLinkRequest;
use App\Http\Requests\VerifyPasswordLinkRequest;

class LinksController extends Controller
{
    /**
     * @param CreateLinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLinkRequest $request)
    {
        logger('links!!!!');
        $link = $this->dispatchNow(new CreateLinkJob($request->intersect(['url', 'password'])));

        return response()->json([
            'url'   =>  route('links.show', ['link' => $link->getAttribute('hash')])
        ], 201);
    }

    /**
     * @param Link $link
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Link $link)
    {
        if ($link->isEncrypted()) {
            return view('links.show', [
                'hash'   =>  $link->getAttribute('hash')
            ]);
        }
        
        return $this->redirectToUrl($link->getAttribute('url'));
    }

    /**
     * @param Link $link
     * @param VerifyPasswordLinkRequest $request
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function verify(Link $link, VerifyPasswordLinkRequest $request)
    {
        if (! Hash::check($request->get('password'), $link->getAttribute('password'))) {
            return back()
                ->withErrors([
                    'password'  =>  'Wrong password.'
                ]);
        }

        return $this->redirectToUrl(decrypt($link->getAttribute('url')));
    }

    /**
     * @param $url
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function redirectToUrl($url)
    {
        return response('', 301, [
            'Location'  =>  $url
        ]);
    }
}
