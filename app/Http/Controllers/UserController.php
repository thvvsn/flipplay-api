<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showCollection(User $user): UserResource
    {
        $user->load('media');

        return new UserResource($user);
    }

    public function addToCollection(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'media_id' => ['required', 'exists:media,id'],
        ]);

        if ($user->media()->where('media_id', $validated['media_id'])->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi',
            ], 409);
        }

        $user->media()->attach($validated['media_id']);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi',
        ], 200);
    }

    public function removeFromCollection(User $user, Media $media): JsonResponse
    {
        if (! $user->media()->where('media_id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ditemukan di koleksi',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi',
        ], 200);
    }
}
