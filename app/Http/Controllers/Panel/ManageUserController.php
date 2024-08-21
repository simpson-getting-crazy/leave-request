<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BaseUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    /**
     * Constructs a new instance of the ManageUserController class.
     *
     * @param User $user The user model instance.
     */
    public function __construct(
        protected User $userModel,
    ) {}

    /**
     * Renders the view for the manage users index page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('admin.pages.manage-users.index');
    }

    /**
     * Renders the view for the manage users create form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('admin.pages.manage-users.form');
    }

    /**
     * Stores a new user in the database.
     *
     * @param \App\Http\Requests\User\BaseUserRequest $request The validated user request data.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the user index page.
     */
    public function store(BaseUserRequest $request): RedirectResponse
    {
        $this->userModel::query()->create(
            attributes: $request->validated()
        );

        return redirect()
            ->route('admin.user.index')
            ->with('toastSuccess', 'User created successfully.');
    }

    /**
     * Renders the view for the manage users edit form.
     *
     * @param int $id The ID of the user to edit.
     * @return \Illuminate\Contracts\View\View The view for the manage users edit form.
     */
    public function edit(int $id): View
    {
        $user = $this->userModel::query()->findOrFail(
            id: $id
        );

        return view('admin.pages.manage-users.form', compact('user'));
    }

    /**
     * Updates an existing user in the database.
     *
     * @param \Illuminate\Http\Request $request The validated user update request data.
     * @param int $id The ID of the user to update.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the user index page.
     */
    public function update(BaseUserRequest $request, int $id): RedirectResponse
    {
        $user = $this->userModel::query()->where('id', $id)->update(
            values: $request->validated()
        );

        return redirect()
            ->route('admin.user.index')
            ->with('toastSuccess', 'User updated successfully.');
    }

    /**
     * Deletes an existing user from the database.
     *
     * @param int $id The ID of the user to delete.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the previous page with a success message.
     */
    public function delete(int $id): RedirectResponse
    {
        $this->userModel::query()->where('id', $id)->delete();

        return redirect()
            ->back()
            ->with('toastSuccess', 'User deleted successfully.');
    }
}
