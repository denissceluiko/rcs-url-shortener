<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Rules\MyURL;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::orderBy('clicks', 'desc')->get();

        return view('links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'link' => [
                'required',
                new MyURL,
            ],
            'short' => [
                'nullable',
                Rule::notIn(['/', 'create', 'destory']),
                'unique:App\Models\Link,shortened_url',
            ],
        ]);

            $existing = Link::where('full_url', $request->link)->first();

        if (!$request->get('short')) {
            // Check if link is natively shortened
            if ($existing && $existing->shortened_url == Link::shorten($request->link)) {
                $request->session()->flash('status', $existing->formatShortened());
                return redirect()->route('link.index');
            }
        }

        $shortened = $request->get('short') ?? Link::shorten($request->link);

        $link = Link::create([
            'full_url' => $request->link,
            'shortened_url' => $shortened,
        ]);


        $request->session()->flash('status', $link->formatShortened());
        return redirect()->route('link.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function route(string $slug)
    {
        $link = Link::where('shortened_url', $slug)->first();

        if (empty($link)) {
            return redirect('/');
        }

        $link->update([
            'clicks' => $link->clicks+1,
        ]);

        return redirect($link->formatFull());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $link = Link::findOrFail($request->id);
        $link->delete();

        return redirect('/');
    }
}
