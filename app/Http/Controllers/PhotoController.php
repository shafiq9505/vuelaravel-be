<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
    {
    /**
     * Upload photo and store in user-specific directory.
     */
    public function uploadPhoto(Request $request)
        {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Get the authenticated user's ID
            $userId = $request->user()->id;

            // Store the photo in a directory named after the user's ID
            $path = $file->storeAs("photos/{$userId}", $filename, 'public');

            return response()->json([
                'message' => 'Photo uploaded successfully',
                'path' => $path,
            ], 201);
            }

        return response()->json(['message' => 'No photo uploaded'], 400);
        }

    /**
     * Retrieve photo for a specific user by filename.
     */
    public function getPhoto($userId, $filename)
        {
        $filePath = storage_path("app/public/photos/{$userId}/{$filename}");

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'Photo not found'], 404);
            }

        return response()->file($filePath);
        }
    }



