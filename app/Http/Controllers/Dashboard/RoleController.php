<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Role;
use App\Models\RoleAbility;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use phpDocumentor\Reflection\Types\Object_;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate();

        return Inertia::render(
            'dashboard/roles/roles.index',
            ['roles' => $roles],
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = new Role();
        $abilities = config('abilities');


        $newArray = [];
        foreach ($abilities as $key => $value) {
            $newArray[] = (Object) ['ability' => $key, 'value' => $value];
        }

        return Inertia::render(
            'dashboard/roles/roles.create',
            [
                'role' => $role,
                'abilities' => $abilities,
            ],
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);

            $abilities = $request->post('abilities');

            foreach ($abilities as $ability_name => $value) {
                RoleAbility::create([
                    'role_id' => $role->id,
                    'ability' => $ability_name,
                    'type' => $value,
                ]);
            }


            // RoleUser::create([
            //   'authorizable_type' => get_class(Auth::user()),
            //   'authorizable_id' => Auth::id(),
            //   'role_id'=>$role->id ,
            // ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }


        return redirect()
            ->route('dashboard.roles.index')
            ->with('message', 'Role Added Successfully');


    }


    public function show(string $id)
    {
        //
    }

    public function edit(Role $role)
    {
        $abilities = config('abilities');
        return Inertia::render(
            'dashboard/roles/roles.edit',
            [
                'role' => $role,
                'abilities' => $abilities,
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);
        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->post('name'),
            ]);

            $abilities = $request->post('abilities');
            foreach ($abilities as $ability_name => $value) {
                RoleAbility::updateOrCreate([
                    'role_id' => $role->id,
                    'ability' => $ability_name,
                ], [
                    'type' => $value,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()
            ->route('dashboard.roles.index')
            ->with('message', 'Role Updated Successfully');

    }

    public function destroy(Role $role)
    {
        $role->delete();
    }
}
