<?php

namespace App\Http\Controllers;

use App\Events\AppealReceived;
use App\Http\Requests\AppealRequest;
use App\Models\Appeal;

class AppealController extends Controller
{

    public function store(AppealRequest $request) {
        $payload = $request->validated();
        $appeal = Appeal::create($payload);
        event(new AppealReceived($appeal));
        return response()->json(['data' => $appeal->toArray()]);
    }

}
