<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rack;

class RackController extends Controller
{
    function post(Request $request)
    {
        $rack = new Rack;
        $rack->name = $request->name;

        $validatedData = $request->validate([
            'name' => 'required|unique:racks',
        ]);

        $rack->save($validatedData);

        $response ['message'] = 'data berhasil disimpan';
        return response($response);
    
    }

    function get() 
    {
        $rack = Rack::all();

        $response ['data'] = $rack;
        return response($response);
    
    }

    function put($id, Request $request)
    {
        $rack = Rack::where('id', $id)->first();
        
        if($rack)
        {
            $rack->name = $request->name ? $request->name : $rack->name;
            
            $rack->save();

            $response ['message'] = 'update berhasil ';
            $response ['data'] = $rack;
            return response($response);
        }
        $response ['message'] = 'data dengan id ' . $id . ' tidak ada';
        return response($response, 400);
    
    }

    function delete($id)
    {
        $rack = Rack::where('id', $id)->first();
        if($rack)
        {
            $rack->delete();
            $response ['message'] = 'data berhasil dihapus ';
            return response($response);
    
        }        

        $response ['message'] = 'data dengan id ' . $id . ' tidak ada';
        return response($response, 400);
    }
}
