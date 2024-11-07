<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionCreateRequest;
use App\Http\Requests\ConnectionUpdateRequest;
use App\Http\Resources\ConnectionResource;
use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionsController extends Controller
{

    public function index()
    {
        $result = Connection::get();
        return new ConnectionResource($result);
    }

    public function store(ConnectionCreateRequest $request)
    {
        $newItem = Connection::create($request->validated());
        return new ConnectionResource($newItem);
    }

    public function update(ConnectionUpdateRequest $request)
    {
        $item = Connection::find($request->id);
        $item->update($request->validated());
        return new ConnectionResource($item);
    }

    public function delete($id){
        $item = Connection::findOrFail($id);
        $item->delete();
        return new ConnectionResource($item);
    }
}
