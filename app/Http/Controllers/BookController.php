<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = Book::filter(request(['search', 'code', 'title', 'author', 'stock']))->get();

        if ($index->isEmpty()) {
            return $this->sendError('Book not found.', 404);
        }

        foreach ($index as $book) {
            $borrow = $book->borrows->where('status', 'Borrowed')->count();

            if ($borrow > 0) {
                $index->forget($book->id - 1);
            }
        }

        return $this->sendResponse($index, 'Book retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $store = Book::create($validated);

        return $this->sendResponse($store, 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return $this->sendResponse($book, 'Book retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        $book->update($validated);

        return $this->sendResponse($book, 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return $this->sendResponse($book, 'Book deleted successfully.');
    }
}
