<?php

namespace App\Http\Controllers;

use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $data = request()->validator([
            'searchTerm' => 'required',
        ]);

        $contacts = Contact::search($data['searchTerm'])->get();

        return ContactResource::collection($contacts);

    }
}
