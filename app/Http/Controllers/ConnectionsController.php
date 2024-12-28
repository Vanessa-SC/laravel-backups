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
        $results = [];
        $path = '/Users/usuario/Documents/backups';
        $folders = array_diff(scandir($path), ['..', '.', '.DS_Store']);
        foreach ($folders as $folder) {
            $folderPath = "$path/$folder";
            if (is_file($folderPath) && !str_contains($folderPath, '.log')) $results[] = $folderPath;
            if (!is_dir($folderPath)) continue;
            $anios = array_diff(scandir($folderPath), ['..', '.', '.DS_Store']);
            foreach ($anios as $anio) {
                $folderPath = "$path/$folder/$anio";
                if (is_file($folderPath) && !str_contains($folderPath, '.log')) $results[] = $folderPath;
                if (!is_dir($folderPath)) continue;
                $meses = array_diff(scandir($folderPath), ['..', '.', '.DS_Store']);
                foreach ($meses as $mes) {
                    $folderPath = "$path/$folder/$anio/$mes";
                    if (is_file($folderPath) && !str_contains($folderPath, '.log')) $results[] = $folderPath;
                    if (!is_dir($folderPath)) continue;
                    $backups = array_diff(scandir($folderPath), ['..', '.', '.DS_Store']);
                    foreach ($backups as $backup) {
                        $filePath = "$path/$folder/$anio/$mes/$backup";
                        if (str_contains($backup, '.gz') || str_contains($backup, '.zip') || str_contains($backup, '.rar') || str_contains($backup, '.log')) continue;
                        $results[] = $filePath;
                        // exec("gzip $filePath");
                    }
                }
            }
        }

        return response()->json($results);
        // $result = Connection::get();
        // return new ConnectionResource($result);
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

    public function delete($id)
    {
        $item = Connection::findOrFail($id);
        $item->delete();
        return new ConnectionResource($item);
    }
}
