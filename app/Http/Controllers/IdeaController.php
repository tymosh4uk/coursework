<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Validator;
use Storage;
use File;
use Illuminate\Support\Facades\DB;

class IdeaController extends Controller
{
    public function createIdea(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required"],
                "image" => ["required"],
                "description" => ["required"]
            ]
        );

        if($validator->fails()) {
            return [
                "status" => false,
                "errors" => $validator->messages()
            ];
        }

        if($request['image']) {
            $image = $request['image'];
            $name = time() .'_'. $image->getClientOriginalName();
            $request['image']->storeAs('ideas', $name, 'public');
        }

        $idea = Idea::create([
            "name" => $request['name'],
            "image" => $name,
            "description" => $request['description'],
        ]);

        return [
            "status" => true,
            "idea" => $idea
        ];
    }

    public function getIdea($id, Request $request) {

        $idea = Idea::find($id);

        if(!$idea) {
            return [
                'status' => false
            ];
        }

        return [
            "status" => true,
            "idea" => $idea
        ];
    }
}
