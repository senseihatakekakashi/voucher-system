<?php

namespace App\Services;

class CUDService
{
    public function create($request, $model) {
        $request->validated();
        $model->create($request->all());
        
        // Flash a success message to the session
        $request->session()->flash('status', 'Successful!');
    }

    public function update($request, $model) {
        $request->validated();
        $model->update($request->all());
        
        // Flash a success message to the session
        $request->session()->flash('status', 'Successful!');
    }

    public function delete($model) {
        $model->delete();
    }
}