<?php

namespace App\Http\Controllers\Api;

use App\{Country, Genre, Movie};
use App\Http\Controllers\Controller;
use App\Http\Resources\Movie as MovieResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MovieController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return MovieResource::collection(Movie::with('country', 'genres')->get());
    }

    /**
     * Store a newly created resource in storage.
     * request should contain fields such as:
     * String title, String description, String country (whole name in polish or just 2 chars of country code
     * String genres - comma separated genre names
     */
    public function store(Request $request)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if ($request->hasFile('cover')) {
            $cover = (new UploadController)->uploadImageCover($request);
        }


        $movie = Movie::create($validator->validated() + [
                'country_id' => (Country::where('name', $request->country)->orWhere('code', $request->country)->firstOrFail())->id,
                'cover' => $cover ?? null
            ]);

        if ($g = request('genres')) {
            $genres = Genre::whereIn('name', explode(",", $g))->get();
            $movie->genres()->attach($genres);
        }

        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updated = $movie->update($validator->validated());
        return response()->json($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $deleted = $movie->delete();
        return response("deleted: " . $deleted);
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->only([
            'title',
            'description',
            'country',
            'genres'
        ]), [
            'title' => 'required|max:255',
            'description' => 'required|min:10',
            'country' => 'required|min:2',
            'genres' => 'sometimes'
        ]);

        return $validator;
    }
}
