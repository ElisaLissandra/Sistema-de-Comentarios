<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\CommentRequest;
use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use App\Utils\DefaultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    protected $commentRepository;
    protected $defaultResponse;

    public function __construct(DefaultResponse $defaultResponse, CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->defaultResponse = $defaultResponse;
    }  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function storePost(CommentRequest $request, Post $post)
    {
        try{
            DB::beginTransaction();
    
            $payload = $request->validated();

            $payload['user_id'] = auth()->user()->id;
            $payload['commentable_id'] = $post->id;
            $payload['commentable_type'] = 'Post';

            $post = $this->commentRepository->store($payload);

            DB::commit();

            return $this->defaultResponse->successWithContent('Comentário criado com sucesso no post', 201, $post);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function storeProduct(CommentRequest $request, Product $product)
    {
        try{
            DB::beginTransaction();
          
            $payload = $request->validated();

            $payload['user_id'] = auth()->user()->id;
            $payload['commentable_id'] = $product->id;
            $payload['commentable_type'] = 'Product';

            $product = $this->commentRepository->store($payload);

            DB::commit();

            return $this->defaultResponse->successWithContent('Comentário criado com sucesso no produto', 201, $product);
        }catch (\Exception $e) {
            DB::rollBack();
           throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function showPostComments(Post $post)
    {
        $comments = $post->comments;

        return $this->defaultResponse->successWithContent('Comentários do post', 200, $comments);
    }


    public function showProductComments(Product $product)
    {
        $comments = $product->comments;

        return $this->defaultResponse->successWithContent('Comentários do produto', 200, $comments);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            DB::beginTransaction();
    
            $comment->delete(); 
    
            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário deletado com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function restorePost($id)
    {
        try {
            DB::beginTransaction();

            $this->commentRepository->restore($id);
    
            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário restaurado com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }
    public function restoreProduct($id)
    {
        try {
            DB::beginTransaction();
    
            $this->commentRepository->restore($id);
    
            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário restaurado com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function forceDeletePost($id)
    {
        try {
            DB::beginTransaction();
    
            $this->commentRepository->forceDelete($id);
    
            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário deletado permanentemente com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function forceDeleteProduct($id)
    {
        try {
            DB::beginTransaction();
    
            $this->commentRepository->forceDelete($id);

            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário deletado permanentemente com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function destroyPost(Comment $comment)
    {
        try {
            DB::beginTransaction();
    
           $this->commentRepository->delete($comment->id);
    
            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário deletado com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function destroyProduct(Comment $comment)
    {
        try {
            DB::beginTransaction();
    
            $this->commentRepository->delete($comment->id); 
    
            DB::commit();
    
            return $this->defaultResponse->isSuccess('Comentário deletado com sucesso', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }
}
