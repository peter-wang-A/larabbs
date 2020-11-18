<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category  $category)
    {
        // 读取分类 ID 关联话题，并分页
        $topics = Topic::where('category_id', $category->id)->paginate(10);

        return view('topics.index', compact('topics','category'));
    }
}
