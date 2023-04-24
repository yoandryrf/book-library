<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
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
            $books = Book::whereNotNull('reserved_by');
        } else {
            $books = Book::where('reserved_by', '=', $user->id);
        }

        // Show the list view
        return view('reservations.index', ['books' => $books->paginate(20), 'crud' => $crud]);
    }

    /**
     * Reserve the specified resource in storage.
     */
    public function reserve($id)
    {
        // Get the book
        $book = Book::find($id);
        $book->update([
            'reserved_by' => Auth::user()->id,
            'reserved_at' => \Carbon\Carbon::now()
        ]);

        // Redirect
        return redirect(route('books.index'))->with('status', 'book-reserved');;
    }

    /**
     * Reserve the specified resource in storage.
     */
    public function return($id)
    {
        // Get the book
        $book = Book::find($id);
        $book->update([
            'reserved_by' => null,
            'reserved_at' => null
        ]);

        // Redirect
        return redirect(route('reservations.index'))->with('status', 'book-returned');;
    }
}
