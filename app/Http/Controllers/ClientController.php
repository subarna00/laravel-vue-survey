<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $client = Client::where('user_id', $user->id)->latest()->get();
        return  ClientResource::collection($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();
        if (isset($validated['image'])) {
            $relativePath = $this->saveImage($validated['image']);
            $validated['image'] = $relativePath;
        }
        $client = Client::create($validated);
        if ($client) {
            return response($client);
        }
        return response('something went wrong', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Client $client)
    {
        $user = $request->user();
        if ($user->id !== $client->user_id) {
            return abort(403, 'Unauthorized action');
        }
        return new clientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();
        if (isset($validated['image'])) {
            $relativePath = $this->saveImage($validated['image']);
            $validated['image'] = $relativePath;
            if ($client->image) {
                $absolutePath = public_path('images/', $client->image);
                File::delete($absolutePath);
            }
        }
        $client->update($validated);
        if ($client) {
            return response($client);
        }
        return response('something went wrong', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $client)
    {
        $user = $request->user();
        if ($user->id !== $client->user_id) {
            return abort(403, 'Unauthorized action');
        }
        $client->delete();
        if ($client->image) {
            $absolutePath = public_path('images/', $client->image);
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
