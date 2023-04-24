<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all the books
        $user = Auth::user();
        $crud = false;

        if ($user->hasRole(UserRoleEnum::WORKER)) {
            $crud = true;
            $books = Book::withTrashed();
        } else {
            $books = Book::where('reserved_by', '!=', $user->id)->orWhereNull('reserved_by');
        }

        // Show the list view
        return view('books.index', ['books' => $books->paginate(20), 'crud' => $crud]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show the create view
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:' . Book::class],
            'description' => ['required', 'string']
        ]);

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        // Redirect
        return redirect(route('books.index'))->with('status', 'book-created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Get the book
        $book = Book::find($id);

        // Show the view and pass the book to it
        return view('books.show')->with('book', $book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Get the book
        $book = Book::find($id);

        // Show the edit view and pass the book to it
        return view('books.edit')->with('book', $book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Get the book
        $book = Book::find($id);
        $book->fill($request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique(Book::class)->ignore($book->id)],
            'description' => ['required', 'string']
        ]));

        $book->save();

        // Redirect
        return redirect(route('books.index'))->with('status', 'book-updated');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Get the book
        $book = Book::find($id);
        $book->delete();

        // Redirect
        return redirect(route('books.index'))->with('status', 'book-deleted');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        // Get the book
        Book::withTrashed()->where('id', $id)->restore();

        // Redirect
        return redirect(route('books.index'))->with('status', 'book-restored');
    }
}
