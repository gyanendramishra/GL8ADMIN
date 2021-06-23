<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use League\Glide\Server;

class ImagesController extends Controller
{
    public function show(Server $glide)
    {
        return $glide->fromRequest()->response();
    }
}
