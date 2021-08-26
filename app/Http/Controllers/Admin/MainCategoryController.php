<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MainCategoryController extends Controller
{
    public function index()
    {
        $default_lang = get_default_language();
        $categories = MainCategory::where('translation_lang', $default_lang)->selection()->get();
        return view('admin.maincategories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.maincategories.create');
    }
    public function store(MainCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            //select default category
            $main_categories = collect($request->category);
            $default_category = array_values($main_categories->filter(function ($val, $key) {
                return $val['abbr'] == get_default_language();
            })->all())[0];
            // insert default category and get its id
            //save image
            $image_path = "";
            if ($request->has('image')) {
                $image_path = upload_image('maincategory', $request->image);
            }
            $default_categoryId = MainCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'image' => $image_path
            ]);
            //select other category
            $other_categories = array_values($main_categories->filter(function ($val, $key) {
                return $val['abbr'] != get_default_language();
            })->all());
            // insert other category
            if (isset($other_categories)) {
                $categories_arr = [];
                foreach ($other_categories as $other_category) {
                    $categories_arr = [
                        'translation_lang' => $other_category['abbr'],
                        'translation_of' => $default_categoryId,
                        'name' => $other_category['name'],
                        'slug' => $other_category['name'],
                        'image' => $image_path
                    ];
                }
                MainCategory::insert($categories_arr);
            }
            DB::commit();
            return redirect()->route('admin.maincategory')->with(['categories' => $default_category, 'success' => 'تم حفظ القسم بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.maincategory')->with(['error' => "عفوَا! هناك خطأ يرجي المحاولة مرة أخرى فيما بعد!!"]);
        }
    }
    public function edit()
    {
    }
    public function update()
    {
    }
    public function destroy()
    {
    }
}
