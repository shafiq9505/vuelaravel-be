<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controller
    {
    public function index()
        {
        $books = Books::select('id', 'name', 'author', 'publish_date')->get();
        return response()->json($books);
        }


    public function store(Request $request)
        {
        $book = new Books;
        $book->name = $request->name;
        $book->author = $request->author;
        $book->publish_date = $request->publish_date;
        $book->save();

        return response()->json([
            "message" => "Book Added",
        ], 201);
        }

    public function show(string $id)
        {
        $books = Books::find(id: $id);

        if (!empty($books)) {
            return response()->json($books);
            } else {
            return response()->json(['message' => 'Book not found'], 404);
            }
        }

    public function update(Request $request, $id)
        {
        if (Books::where('id', $id)->exists()) {
            $book = Books::find(($id));
            $book->name = is_null($request->name) ? $book->name : $request->name;
            $book->author = is_null($request->name) ? $book->author : $request->author;
            $book->publish_date = is_null($request->publish_date) ? $book->publish_date : $request->publish_date;
            $book->save();

            return response()->json([
                "message" => "Book Updated",
            ], 404);

            } else {
            return response()->json([
                "message" => "Book not found",
            ], 404);
            }
        }


    public function destroy(string $id)
        {
        if (Books::where('id', $id)->exists()) {
            $book = Books::find(($id));
            $book->delete();

            return response()->json([
                "message" => "Record deleted",
            ], 404);

            } else {
            return response()->json([
                "message" => "Book not found",
            ], 404);
            }

        }

    }


