<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        InertiaTable::updateQueryBuilderParameters('users');

        $users = QueryBuilder::for(User::class)
            ->defaultSort('-created_at')
            ->allowedSorts([
                'id',
                'user_name',
            ])
            ->paginate(
                perPage: request()->get('perPage', 10),
                page: request()->get('page', 1)
            )
            ->withQueryString();

        return Inertia::render('UserManage/Index',
            [
                'users' => $users,
            ])->table(function (InertiaTable $table) {
            $table
                ->name('users')
                ->perPageOptions([2, 10, 20])
                ->defaultSort('-created_at')
                ->column(key: 'id', label: 'ID', canBeHidden: false, sortable: true)
                ->column(key: 'user_name', label: 'Név', canBeHidden: false, sortable: true)
                ->column(key: 'email', label: 'Email', canBeHidden: false, sortable: true)
                ->column(key: 'actions', canBeHidden: false, sortable: false)
                ->column(key: 'arrow', canBeHidden: false, sortable: false);
        });
    }

        /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'is_admin' => ['required'],
        ]);

        $user->update([
            'is_admin' => $validated['is_admin'],
        ]);

        return redirect(route('users.index'))->with('success', 'User updated successfully');
    }


    /**
     * @param User $User
     * @return RedirectResponse
     */
    public function delete(User $user): RedirectResponse
    {
        $user->delete();

        return redirect(route('users.index'))->with('success', 'User deleted successfully');
    }
}
