<?php

namespace Sl0wik\Webset\Http\Controllers;

use Sl0wik\Webset\Models\Content;
use Sl0wik\Webset\Models\Menu;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;

class ContentController extends Controller
{
    public function index()
    {
        return view('pages.index', ['content' => Content::indexPage()]);
    }

    public function show(Content $content)
    {
        return view('pages.content', ['content' => $content]);
    }

    public function showBySlug(Request $request)
    {
        $uri = str_replace(LaravelLocalization::getCurrentLocale().'/', '', $request->route()->uri);

    	$content = Content::where([
    		['url_path', $uri],
    		['language_code', LaravelLocalization::getCurrentLocale()]
    	]);

        return view('pages.content', ['content' => $content->firstOrFail()]);
    }
}
