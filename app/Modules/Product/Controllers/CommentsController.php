<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Facades\CommentsFacade;
use App\Modules\Product\Facades\ProductsFacade;
use App\Modules\Product\Requests\StoreProductRequest;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    private $facade;

    public function __construct(CommentsFacade $commentsFacade)
    {
        $this->facade = $commentsFacade;
    }
}
