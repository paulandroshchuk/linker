<?php

namespace App\Http\Controllers\Client;

use App\Models\Link;
use App\Jobs\CreateLinkJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLinkRequest;

class LinksController extends Controller
{
    /**
     * @param CreateLinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLinkRequest $request)
    {
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
        
        $url = $link->getAttribute('url');

        return response('', 301, [
            'Location'  =>  $url
        ]);
    }
    
    public function decrypt()
    {
        
    }
}
