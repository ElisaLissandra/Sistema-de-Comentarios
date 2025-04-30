<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\PostRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Service\SlugService;
use App\Utils\DefaultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $postRepository;
    protected $slugService;
    protected $defaultResponse;

    public function __construct(DefaultResponse $defaultResponse, SlugService $slugService, PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->slugService = $slugService;
        $this->defaultResponse = $defaultResponse;
    }  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $posts = $this->postRepository->index();

            return $this->defaultResponse->successWithContent('Posts encontrados com sucesso', 200, $posts);
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
    public function store(PostRequest $request)
    {
        try{
            DB::beginTransaction();
        
            $payload = $request->validated();

            $payload['slug'] = $this->slugService->uniqueSlug($payload['name'], Post::class);
            $payload['user_id'] = auth()->user()->id;

            $post = $this->postRepository->store($payload);

            DB::commit();

            return $this->defaultResponse->successWithContent('Post criado com sucesso', 201, $post);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        try{
            DB::beginTransaction();

            $payload = $request->validated();

            $payload['user_id'] = auth()->user()->id;

            $post = $this->postRepository->update($payload, $post->id);

            DB::commit();

            return $this->defaultResponse->successWithContent('Post atualizado com sucesso', 201, $post);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try{
            DB::beginTransaction();

            $this->postRepository->delete($post->id);

            DB::commit();

            return $this->defaultResponse->isSuccess('Post deletado com sucesso', 200);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();

            $this->postRepository->restore($id);

            DB::commit();

            return $this->defaultResponse->isSuccess('Post restaurado com sucesso', 200);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function forceDelete($id)
    {
        try{
            DB::beginTransaction();

            $this->postRepository->forceDelete($id);

            DB::commit();

            return $this->defaultResponse->isSuccess('Post deletado permanentemente com sucesso', 200);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }
}
