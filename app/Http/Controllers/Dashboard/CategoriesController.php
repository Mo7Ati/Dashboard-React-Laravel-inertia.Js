<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class CategoriesController extends Controller
{

    public function index()
    {
        // Gate::authorize('categories.index');
        $request = request();
        $filters = $request->query();
        $categories = Category::filter($filters)
            ->with('parent')->get();

        return Inertia::render(
            'dashboard/categories/categories.index',
            ['categories' => $categories],
        );
    }


    public function create()
    {
        // Gate::authorize('categories.create');

        $category = new Category();
        $parents = Category::all();
        return inertia::render(
            'dashboard/categories/categories.create',
            ['category' => $category, 'parents' => $parents]
        );
    }


    public function store(CategoryRequest $request)
    {
        $data = $request->except('image');

        $data['image'] = $this->storeImage($request);

        Category::create($data);
        return redirect()->route('dashboard.categories.index')
            ->with('message', 'New Category Added');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(Category $category)
    {
        // Gate::authorize('categories.update');

        $parents = Category::
            where('id', '<>', $category->id)
            ->where(function (Builder $builder) use ($category) {
                $builder->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $category->id);
            })
            ->get();


        return
            Inertia::render(
                'dashboard/categories/categories.edit',
                [
                    'parents' => $parents,
                    'category' => $category,
                ]
            );
    }


    public function update(CategoryRequest $request, Category $category)
    {

        $data = $request->except('image');

        $data['image'] = $this->storeImage($request, $category);

        $category->update($data);

        return redirect()->route('dashboard.categories.index')
            ->with('message', 'Category Updated');
    }


    public function destroy(Category $category)
    {
        // Gate::authorize('categories.delete');

        $this->deleteOldImage($category);
        $category->delete();
    }


    public function storeImage(CategoryRequest $request, Category $category = null)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($category) {
                $this->deleteOldImage($category);
            }
            return $request->file('image')->store('uploads/categories', 'public');

        } else if ($category && $category->image && filter_var($request->post('removeImage'), FILTER_VALIDATE_BOOLEAN)) {
            $this->deleteOldImage($category);
            return null;
        } else {
            return $category->image ?? null;
        }

    }


    public function deleteOldImage(Category $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
    }
}
