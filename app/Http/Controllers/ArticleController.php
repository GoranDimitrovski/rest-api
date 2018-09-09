<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Auth;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 0);
        $articles = Auth::user()->article()->limit(100)->skip($page * 100)->get();

        return response()->json(['page' => $page, 'result' => $articles]);
    }

    /**
     * Store an article
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();
        $article = $user->article()->Create($request->all());

        if ($article != null) {
            return response()->json($article);
        }

        return response()->json(['status' => 'fail'], 401);
    }

    /**
     * Return the specified article
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $article = Article::where('id', $id)->first();

        if ($article != null) {
            return response()->json($article);
        }

        return response()->json(['message' => 'Article not found'], 401);
    }

    /**
     * Update the specified article
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $article = Article::find($id);
        if ($article != null && $article->fill($request->all())->save()) {
            return response()->json($article);
        }

        return response()->json(['status' => 'fail'], 401);
    }

    /**
     * Soft delete the specified article
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        if (Article::destroy($id)) {
            return response()->json(['status' => 'success'], 410);
        }

        return response()->json(['status' => 'fail'], 401);
    }

}
