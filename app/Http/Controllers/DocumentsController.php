<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use ParsedownExtra;

class DocumentsController extends Controller
{
    /**
     * @var \App\Document
     */
    protected $document;
    /**
     * Constructor.
     *
     * @param \App\Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }
    /**
     * Show document page in response to the given $file
     *
     * @param string|null $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($file = '01-welcome.md')
    {
        $index = \Cache::remember('documents.index', 120, function () {
            return markdown($this->document->get());
        });

        $content = \Cache::remember("documents.{$file}", 120, function () use ($file) {
            return markdown($this->document->get($file));
        });

        return view('documents.index', compact('index', 'content'));

        // return view('documents.index', [
        //     'index'   => markdown($this->document->get()),
        //     'content' => markdown($this->document->get($file ?: '01-welcome.md'))
        // ]);
    }
}
