<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Product\Facades\ProductsFacade;
use App\Modules\Product\Requests\StoreProductRequest;
use App\Services\ReportService;
use App\Services\Service;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    private $facade;

    public function __construct(ProductsFacade $productsFacade)
    {
        $this->facade = $productsFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $parameters = $request->all(['idx', 'productStatusId', 'categoryId', 'problemTypeId', 'clientId', 'sortBy']);
        return view('products.index', $parameters);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleted(Request $request)
    {
        $parameters = $request->all(['idx', 'productStatusId', 'categoryId', 'problemTypeId', 'clientId', 'sortBy']);
        $parameters['deleted'] = 'true';
        return view('products.index',
            $parameters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.add');
    }

    /**
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->facade->create($request->validated());
        return redirect()->route('products');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $product = $this->facade->findOrFail($id);
        try {
            $this->authorize('view', $product);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to view the job with id: ' . $product->id);
        }
        return view('products.view',
            compact('product'));
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        try {
            $this->authorize('update', $product);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the job with id: ' . $product->id);
        }
        return view('products.add',
            compact('product'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['image', 'max:4096'],
        ]);
        $image = $request->file('file');
        $name = $image->getClientOriginalName();
        $folder = '/products/images/';
        $image->move(storage_path('/app/public'.$folder), $name);
        return response()->json(['success' => $folder.$name]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function claimed(Request $request)
    {
        $parameters = $request->all(['sortBy']);
        return view('products.claimed', $parameters);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProductInformation(Request $request)
    {
        $key = $request->key;
        $id = Service::decrypt($key);
        $product = $this->facade->findOrFail($id);
        return view('products.info', compact('product'));
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function reportsDownload(Product $product)
    {
        return $this->facade->makeReport($product);
    }
}
