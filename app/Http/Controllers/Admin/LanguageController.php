<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use PhpParser\Node\Stmt\TryCatch;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::selection()->paginate(PAGINATION_COUNT);
        return view('admin.language.index')->with('languages', $languages);
    }
    public function create()
    {
        return view('admin.language.create');
    }
    public function store(LanguageRequest $languageRequest)
    {
        try {
            Language::create($languageRequest->except(['_token']));
            return redirect()->route('admin.language')->with(['success' => 'تم حفظ اللغة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.language')->with(['error' => 'هناك خطأ في البيانات يرجي المحاولة فيما بعد']);
            //throw $th;
        }
    }
    public function edit($id)
    {
        $language = Language::selection()->find($id);
        if (!$language)
            return redirect()->route('admin.language')->with(['error' => 'هذه اللغة غير موجودة']);
        return view('admin.language.edit', compact('language'));
    }
    public function update($id, LanguageRequest $languageRequest)
    {
        try {
            $language = Language::find($id);
            if (!$language)
                return redirect()->route('admin.language.edit')->with(['error' => 'هذه اللغة غير موجودة']);
            if (!$languageRequest->has('active'))
                $languageRequest->request->add(['active' => '0']);
            // dd($languageRequest);
            $language->update($languageRequest->except('_token'));
            return redirect()->route('admin.language')->with('success', 'تم تحديث اللغة بنجاح');
        } catch (\Exception $ex) {
            return redirect()->route('admin.language')->with(['error' => 'هناك خطأ في البيانات يرجي المحاولة فيما بعد']);
        }
    }
    public function destroy($id)
    {
        try {
            $language = Language::find($id);
            if (!$language)
                return redirect()->route('admin.language')->with(['error', 'هذه اللغة غير موجودة']);
            $language->delete();
            return redirect()->route('admin.language')->with(['success' => 'تم حذف اللغة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.language')->with(['error' => 'هناك خطأ في البيانات يرجي المحاولة فيما بعد']);
            //throw $th;
        }
    }
}
