<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;

class CategoriesController extends Controller
{
    function post(Request $request)
    {
        $categories = new Categories;
        $categories->name = $request->name;

        $validatedData = $request->validate([
            'name' => 'required|unique:Categories',
        ]);

        $categories->save($validatedData);

        $response ['message'] = 'data berhasil disimpan';
        return response($response);
    
    }

    function get() 
    {
        $categories = Categories::all();

        $response ['data'] = $categories;
        return response($response);
    
    }

    function put($id, Request $request)
    {
        $categories = Categories::where('id', $id)->first();
        
        if($categories)
        {
            $categories->name = $request->name ? $request->name : $categories->name;
            
            $categories->save();

            $response ['message'] = 'update berhasil ';
            $response ['data'] = $categories;
            return response($response);
        }
        $response ['message'] = 'data dengan id ' . $id . ' tidak ada';
        return response($response, 400);
    
    }

    function delete($id)
    {
        $categories = Categories::where('id', $id)->first();
        if($categories)
        {
            $categories->delete();
            $response ['message'] = 'data berhasil dihapus ';
            return response($response);
    
        }        

        $response ['message'] = 'data dengan id ' . $id . ' tidak ada';
        return response($response, 400);
    }
}
