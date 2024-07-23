<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);
        $comment = $request->all();
        Comments::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'comment' => $comment['comment']
        ]);
        return response()->json(__('words.A comment has been added'));
    }

    public function deleteComment($id)
    {
        $comment = Comments::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $comment->delete();

        return response()->json(__('words.The comment has been deleted'));
    }

    public function allcomment($id)
    {
        $product = Product::find($id);
        try {
            $comments = $product->comments;
            foreach ($comments as $com) {
                $comment[] = $com['comment'];
            };
            return response()->json($comment, 200);
        } catch (\Throwable $th) {
            return response()->json(__('words.There are no comments on the product'));
        }
    }
}
