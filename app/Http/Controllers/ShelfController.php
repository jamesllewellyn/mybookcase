<?php

namespace App\Http\Controllers;

use App\Shelf;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ShelfController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shelves = request()->user()->getShelves();
        $reading = request()->user()->getReading()->pluck('isbn');
        $read = request()->user()->getRead()->pluck('isbn');
        return $this->apiSuccess(['shelves' => $shelves, 'reading' => $reading, 'read' => $read ]);
    }

    /**
     * Store new shelf
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shelf = new Shelf();

        $this->validate(Request(), $shelf->validation, $shelf->messages);

        $shelf = Shelf::create(['name' => $request->get('name'), 'user_id' => $request->user()->id]);

        return $this->apiSuccess(['message' => "Shelf {$shelf->name} has been created", 'shelf' => $shelf]);
    }

    /**
     * get shelf
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $shelf = Shelf::where('id', $shelf->id)->first();

        return $this->apiSuccess(['message' => 'shelf has been found', 'shelf' => $shelf]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @param \App\Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $this->validate(Request(), $shelf->validation, $shelf->messages);

        $shelf->update([
            'name'   => $request->get('name'),
            'public' => $request->get('public')
        ]);

        return $this->apiSuccess(['message' => "shelf {$shelf->name} has been updated", 'shelf' => $shelf]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @param \App\Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $shelf->delete();

        return $this->apiSuccess(['message' => "shelf {$shelf->name} has been deleted"]);
    }
}
