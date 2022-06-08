<?php

namespace App\Http\Controllers;

use App\Service\LikesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikesController extends Controller
{
    public function getLikesById(Request $request)
    {
        //        return $request;
        $service = new LikesService();
        $data = $service->getLikes($request);
        return $data;
    }

    public function getSavedsById(Request $request) {
        $service = new LikesService();
        $data = $service->getSaveds($request);
        return $data;
    }

    public function setLike(Request $request) {
        $service = new LikesService();
        $data = $service->setLike($request);
        return $data;
    }

    public function setDislike(Request $request) {
        $service = new LikesService();
        $data = $service->setDislike($request);
        return $data;
    }

}
