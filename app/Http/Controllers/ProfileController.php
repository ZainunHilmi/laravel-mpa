<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile.index');
    }

    public function activities()
    {
        $recentUsers = \App\Models\User::latest()->take(5)->get()->map(function ($user) {
            return (object) [
                'type' => 'User Registration',
                'message' => "New user registered: {$user->name} ({$user->roles})",
                'created_at' => $user->created_at,
                'icon' => 'fas fa-user-plus',
                'color' => 'primary'
            ];
        });

        $recentProducts = \App\Models\Product::latest()->take(5)->get()->map(function ($product) {
            return (object) [
                'type' => 'Product Added',
                'message' => "New product added: {$product->name}",
                'created_at' => $product->created_at,
                'icon' => 'fas fa-box',
                'color' => 'success'
            ];
        });

        $activities = $recentUsers->merge($recentProducts)->sortByDesc('created_at')->values();

        return view('pages.profile.activities', compact('activities'));
    }

    public function settings()
    {
        return view('pages.profile.settings');
    }
}
