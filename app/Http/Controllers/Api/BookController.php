<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;

class BookController extends Controller
{
    function post(Request $request)
    {
        $book = new Book;
        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->total_page = $request->total_page;
        $book->rack_id = $request->rack_id;
        $book->categories = $request->categories;

        $validatedData = $request->validate([
            'isbn' => 'required|unique:books',
            'title' => 'required',
            'author' => 'required',
            'total_page' => 'required',
        ]);

        $book->save($validatedData);

        $response ['message'] = 'data berhasil ditambahkan';
        return response($response);
    
    }

    function get(Request $request) 
    {
        $keyword = $request->keyword;
        $book = Book::with('rack')->where('title', 'like', '%'.$keyword.'%')->get();
        if($book != null && count($book) > 0){
            foreach($book as $item){
                $param = $item->categories;
                $categories = \App\Categories::select('name')->whereIn('id', json_decode($param))->get();
                $item->categories = $categories;
            }
            $response ['data'] = $book;
            return response($response);        
        }
        $response ['data'] = 'tidak ada';
        return response($response, 400);
    }

    function put($id, Request $request)
    {
        $book = Book::where('id', $id)->first();
        
        if($book)
        {
            $book->isbn = $request->isbn ? $request->isbn : $book->isbn;
            $book->title = $request->title ? $request->title : $book->title;
            $book->author = $request->author ? $request->author : $book->author;
            $book->total_page = $request->total_page ? $request->total_page : $book->total_page; 
            $book->rack_id = $request->rack_id ? $request->rack_id : $book->rack_id;
            $book->categories = $request->categories ? $request->categories : $book->categories;
            
            $book->save();

            $response ['message'] = 'update berhasil ';
            $response ['data'] = $book;
            return response($response);
        }
        $response ['message'] = 'data dengan id ' . $id . ' tidak ada';
        return response($response, 400);
    
    }

    function delete($id)
    {
        $book = Book::where('id', $id)->first();
        if($book)
        {
            $book->delete();
            $response ['message'] = 'data berhasil dihapus ';
            return response($response);
    
        }        

        $response ['message'] = 'data dengan id ' . $id . ' tidak ada';
        return response($response, 400);
    }
}
