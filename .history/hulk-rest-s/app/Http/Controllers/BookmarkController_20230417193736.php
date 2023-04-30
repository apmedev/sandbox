<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBookmarkRequest;
use App\Models\Movie;
use App\Models\Bookmark;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookmarkedMovies = auth()->user()->movies;
        return response()->json($bookmarkedMovies);
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
        $movie = Movie::findOrFail($request->movie_id);
        auth()->user()->movies()->syncWithoutDetaching($movie);
        return response()->json(['message' => 'Bookmark saved']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookmarkRequest $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }
}
