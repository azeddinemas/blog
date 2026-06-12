<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    // ✅ Lister tous les articles
    public function index()
    {
        return ArticleResource::collection(Article::all());
    }

    // ✅ Afficher un seul article
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article non trouvé'
            ], 404);
        }

        return new ArticleResource($article);
    }

    // ✅ Créer un article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $article = Article::create($validated);

        return new ArticleResource($article);
    }

    // ✅ Modifier un article
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article non trouvé'
            ], 404);
        }

        $article->update($request->all());

        return new ArticleResource($article);
    }

    // ✅ Supprimer un article
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article non trouvé'
            ], 404);
        }

        $article->delete();

        return response()->json([
            'message' => 'Article supprimé avec succès'
        ]);
    }
}