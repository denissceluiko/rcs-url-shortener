<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Notifications\LinkClicked;
use App\Rules\MyURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::orderBy('clicks', 'desc')->get();

        return view('welcome', compact('links'));
    }

    public function dashboard()
    {
        $links = Auth::user()->links()->get();

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
                return redirect()->route('link.index')->with('status', $existing);
            }
        }

        $shortened = $request->get('short') ?? Link::shorten($request->link);

        $link = Link::create([
            'full_url' => $request->link,
            'shortened_url' => $shortened,
            'user_id' => Auth::user()?->id,
        ]);

        return redirect()->route('link.index')->with('status', $link);
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

        if ($link->author && $link->clicks % 10 == 0) {
            Notification::send($link->author, new LinkClicked($link));
        }

        return redirect($link->formatFull());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $link = Link::slugOrFail($slug);

        if ($link->user_id != Auth::user()->id) {
            return back();
        }

        return view('links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'full_url' => [
                'required',
                new MyURL,
            ],
        ]);

        $link = Link::findOrFail($request->id);

        if ($link->user_id != Auth::user()->id) {
            return back();
        }

        $link->update([
            'full_url' => $request->full_url,
            'clicks' => 0,
        ]);

        return redirect('/');
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

        if ($link->user_id != Auth::user()->id) {
            return back();
        }

        $link->delete();

        return redirect('/');
    }

    public function qr(string $slug)
    {
        $link = Link::slugOrFail($slug);

        if (empty($link)) {
            abort(404);
        }

        return view('links.qr', compact('link'));
    }

    public function qrDownload(string $slug)
    {
        $link = Link::slugOrFail($slug);

        if (empty($link)) {
            abort(404);
        }

        return response()->streamDownload(function() use ($link) {
            echo $link->QRCode()->getString();
        }, "qr-code.$link->shortened_url.png", [
            'Content-Type' => 'image/png',
        ]);
    }
}
