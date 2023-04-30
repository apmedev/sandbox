<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookmarkRequest;
use App\Http\Requests\UpdateBookmarkRequest;
use App\Models\Movie;
use App\Models\Bookmark;
use App\Models\User;

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
    public function store(StoreBookmarkRequest $request)
    {
        $user = User::findOrFail($request['user_id']);
        $movie = Movie::findOrFail($request['movie_id']);

        if (!$user->movies()->where('movie_id', $movie->id)->exists()) {
            $user->movies()->attach($movie);
            return response()->json(['message' => 'Bookmark created successfully.']);
        }

        return response()->json(['message' => 'Bookmark already exists.']);
    
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
