<?php

namespace Sl0wik\Webset\Http\Controllers;

use Illuminate\Http\Request;
use LaravelLocalization;
use Sl0wik\Webset\Models\Content;

class ContentController extends Controller
{
    public function index()
    {
        $content = Content::indexPage();

        return view("pages.{$content->contentTemplate->name}", ['content' => $content]);
    }

    public function show(Content $content)
    {
        return view("pages.{$content->contentTemplate->name}", ['content' => $content]);
    }

    public function showBySlug(Request $request)
    {
        $uri = str_replace(LaravelLocalization::getCurrentLocale().'/', '', $request->route()->uri);

        $content = Content::where([
            ['url_path', $uri],
            ['language_code', LaravelLocalization::getCurrentLocale()],
        ])->firstOrFail();

        return view("pages.{$content->contentTemplate->name}", ['content' => $content]);
    }
}
