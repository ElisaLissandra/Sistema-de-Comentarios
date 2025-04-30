<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Service\SlugService;
use App\Utils\DefaultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productRepository;
    protected $slugService;
    protected $defaultResponse;

    public function __construct(DefaultResponse $defaultResponse, SlugService $slugService, ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->slugService = $slugService;
        $this->defaultResponse = $defaultResponse;
    }    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $products = $this->productRepository->index();

            return $this->defaultResponse->successWithContent('Products listados com sucesso', 200, $products);
        }catch (\Exception $e) {
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try{
            DB::beginTransaction();

            $payload = $request->validated();

            $payload['slug'] = $this->slugService->uniqueSlug($payload['name'], Product::class);
            $payload['user_id'] = auth()->user()->id;

            $product = $this->productRepository->store($payload);
      
            $product->stocks()->create($payload['stock']);
        

            DB::commit();

            return $this->defaultResponse->successWithContent('Product criado com sucesso', 201, $product);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        try{
            DB::beginTransaction();
    
            $payload = $request->validated();

            $payload['user_id'] = auth()->user()->id;

            $product = $this->productRepository->update($payload, $product->id);
            
            if($product->stocks()->exists()){
                $product->stocks()->delete();
            }

            $product->stocks()->create($payload['stock']);
        

            DB::commit();

            return $this->defaultResponse->successWithContent('Product criado com sucesso', 201, $product);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            DB::beginTransaction();
         
            $product->stocks()->delete();
            $product->delete();

            DB::commit();

            return $this->defaultResponse->successWithContent('Product deletado com sucesso', 201, $product);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
         
            $product = $this->productRepository->restore($id);

            DB::commit();

            return $this->defaultResponse->successWithContent('Product restaurado com sucesso', 201, $product);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function forceDelete($id)
    {
        try{
            DB::beginTransaction();
         
            $product = $this->productRepository->forceDelete($id);

            DB::commit();

            return $this->defaultResponse->successWithContent('Product deletado com sucesso', 201, $product);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }
    
}
