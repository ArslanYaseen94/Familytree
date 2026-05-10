<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Fetch family members for context
        // Note: Check if the user has a familyId attribute or if it's stored differently
        $familyId = $user->family_id ?? $user->familyId; 
        
        $familyMembers = Member::where('family_id', $familyId)->get([
            'firstname', 'lastname', 'type', 'gender', 'birthdate', 'birthplace', 'profession', 'bio'
        ]);

        $count = $familyMembers->count();
        Log::info("Chatbot context: Found $count family members for family_id: $familyId");

        $context = "You are a Family History Assistant. The current user has a total of $count family members in their database.\n";
        $context .= "Here is the list of family members:\n";
        foreach ($familyMembers as $member) {
            $context .= "- {$member->firstname} {$member->lastname} ({$member->gender}), Born: {$member->birthdate}, Profession: {$member->profession}, Bio: {$member->bio}\n";
        }
        $context .= "\nAnswer the user's question based on this data. If you don't know the answer, say so politely.";

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Gemini API key not configured'], 500);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => "Context: $context\n\nUser Question: " . $request->message]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? "I'm sorry, I couldn't process that.";
                return response()->json(['response' => $aiResponse]);
            }

            Log::error('Gemini API Error: ' . $response->body());
            Log::info('Sent Context: ' . $context);
            return response()->json(['error' => 'AI API error: ' . $response->status()], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
