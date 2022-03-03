<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\UpdateEmployeRequest;
use App\Http\Resources\EmployeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $employe = Employe::where('user_id', $user->id)->latest()->get();
        return  EmployeResource::collection($employe);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeRequest $request)
    {
        $validated = $request->validated();
        if (isset($validated['profile_picture'])) {
            $relativePath = $this->saveImage($validated['profile_picture']);
            $validated['profile_picture'] = $relativePath;
        }
        $employe = Employe::create($validated);
        if ($employe) {
            return response($employe);
        }
        return response('something went wrong', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function show(Employe $employe, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $employe->user_id) {
            return abort(403, 'Unauthorized action');
        }
        return new employeResource($employe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeRequest  $request
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {
        $user = $request->user();
        $request['user_id'] = $user->id;
        $id = $employe->id;
        $validated = $request->validate([
            'name' => 'required|max:100',
            'user_id' => 'exists:users,id',
            'email' => [
                'required',
                Rule::unique('employes', 'email')->ignore($request->id),
            ],
            'phone_number' => 'required',
            'password' => 'required',
            'address' => 'nullable|max:200',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'profile_picture' => 'nullable'
        ]);
        if (isset($validated['profile_picture'])) {
            $relativePath = $this->saveImage($validated['profile_picture']);
            $validated['profile_picture'] = $relativePath;
            if ($employe->profile_picture) {
                $absolutePath = public_path('images/', $employe->profile_picture);
                File::delete($absolutePath);
            }
        }
        $employe->update($validated);
        if ($employe) {
            return response($employe);
        }
        return response('something went wrong', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Employe $employe)
    {
        $user = $request->user();
        if ($user->id !== $employe->user_id) {
            return abort(403, 'Unauthorized action');
        }
        $employe->delete();
        if ($employe->profile_picture) {
            $absolutePath = public_path('images/', $employe->profile_picture);
            File::delete($absolutePath);
        }
        return response('', 204);
    }
    private function saveImage($image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['png', 'jpeg', 'gif', 'jpg'])) {
                throw new \Exception("invalid image type");
            }
            $image = str_replace('', '+', $image);
            $image = base64_decode($image);
            if ($image === false) {
                throw new \Exception("base64 decode failed");
            }
        } else {
            throw new \Exception("did not match data URI with image data");
        }
        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
