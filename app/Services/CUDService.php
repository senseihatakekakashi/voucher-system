<?php

namespace App\Services;

/**
 * Class CUDService
 *
 * This class provides Create, Update, and Delete (CUD) operations using Laravel service container.
 *
 * @package App\Services
 */
class CUDService
{
    /**
     * Create a new resource in the database.
     *
     * @param \Illuminate\Http\Request $request The validated request object.
     * @param \Illuminate\Database\Eloquent\Model $model The Eloquent model instance to be created.
     *
     * @return void
     */
    public function create($request, $model)
    {
        $request->validated();
        $model->create($request->all());

        // Flash a success message to the session
        $request->session()->flash('status', 'Resource created successfully!');
    }

    /**
     * Update an existing resource in the database.
     *
     * @param \Illuminate\Http\Request $request The validated request object.
     * @param \Illuminate\Database\Eloquent\Model $model The Eloquent model instance to be updated.
     *
     * @return void
     */
    public function update($request, $model)
    {
        $request->validated();
        $model->update($request->all());

        // Flash a success message to the session
        $request->session()->flash('status', 'Resource updated successfully!');
    }

    /**
     * Delete a resource from the database.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The Eloquent model instance to be deleted.
     *
     * @return void
     */
    public function delete($model)
    {
        $model->delete();

        // Optionally, you may want to add a flash message here as well.
    }
}