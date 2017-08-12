<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\NewsTrends as News;

class NewsTrendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index ($skip = 1, $take = 99999) {
    	$lists = News::select('id', 'title', 'content', 'views', 'type_id', 'img_url', 'created_at', 'updated_at')->orderBy('id', 'desc')->skip($skip-1)->take($take)->get();
    	return response()->json($lists);
    }

    /**
     * Update a news of the resource.
     *
     * @return Response
     */
    public function update (Request $request) {
    	if (empty($request->id)) {
	    	$news = new News();
            $news->title = $request->title;
            $news->content = $request->content;
            $news->type_id = $request->type_id;
            $news->img_url = $request->img_url;
	    	if ($news->save()) {
	    		return response()->json(['status' => '0', 'info' => '添加新闻成功']);
	    	} else {
	    		return response()->json(['status' => '1', 'info' => '添加新闻失败']);
	    	}
    	} else {
            $news = News::firstOrCreate(['id' => $request->id]);
            $news->title = $request->title;
            $news->content = $request->content;
            $news->type_id = $request->type_id;
            $news->img_url = $request->img_url;
            if ($news->save()) {
                return response()->json(['status' => '0', 'info' => '更新新闻成功']);
            } else {
                return response()->json(['status' => '4', 'info' => '更新新闻失败']);
            }
        }
    }

    /**
     * Destroy a news of the resource.
     *
     * @return Response
     */
    public function destroy (Request $request) {
    	if (empty($request->id)) {
    		return response()->json(['status' => '2', 'info' => 'ID不能为空']);
    	}
    	$result = News::whereIn('id', $request->id)->delete();
    	if ($result) {
    		return response()->json(['status' => '0', 'info' => '删除新闻成功']);
    	} else {
    		return response()->json(['status' => '3', 'info' => '删除新闻失败']);
    	}
    }
}
