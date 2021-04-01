<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApiController;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\V2\PostResource;
use App\Http\Resources\V2\PostCollection;

class PostController extends ResponseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PostCollection(Post::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $message = null;

        try {
            $post = new Post;
            $post->user_id = $request->user()->id;
            $post->title = $request->get('title');
            $post->slug = $request->get('slug');
            $post->content = $request->get('content');
            $post->save();

            $message = $this->sendResponse($post, 'Registro almacenado correctamente');

        } catch (\Throwable $th) {
            $message = $this->sendError($th->getMessage(), ['Error al registrar el post'], 500);
        }

        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $message = null;

        $post = Post::find($id);

        if(is_null($post)) {
            $message = $this->sendError('Error en la consulta', ['El registro no existe'], 422);
        } else {

            try {
                $post->title = $request->get('title');
                $post->slug  = $request->get('slug');
                $post->content = $request->get('content');
                $post->save();

                $message = $this->sendResponse($post, 'Registro actualizado correctamente');

            } catch (\Throwable $th) {
                $message = $this->sendError($th->getMessage(), ['Error al actualizar el registro'], 500);
            }

        }

        return $message;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = null;

        $post = Post::find($id);

        if($post === null){
            $message = $this->sendError('Error en la consulta', ['No se encontro el registro'], 422);
        }else{

            try {
               $post->delete();
               $message = $this->sendResponse($post, 'Post eliminado correctamente');
            } catch (\Throwable $th) {
               $message = $this->sendError($th->getMessage(), ['Error al eliminar el registro'], 500);
            }

        }

        return $message;
    }

}
