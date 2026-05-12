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
            'id', 'parent_id', 'firstname', 'lastname', 'type', 'gender', 'birthdate', 'deathdate', 'birthplace', 'deathplace', 
            'profession', 'company', 'interests', 'bio', 'village', 'home_town', 'school', 'background', 'business_info'
        ]);

        $count = $familyMembers->count();
        Log::info("Chatbot context: Found $count family members for family_id: $familyId");

        // Create a dictionary for quick lookup by ID to resolve relationships
        $membersDict = [];
        foreach ($familyMembers as $member) {
            $membersDict[$member->id] = $member;
        }

        $context = "You are a highly capable Family History Assistant. The current user has a total of $count family members in their database.\n";
        $context .= "Here is detailed information and relationships for each family member:\n\n";

        foreach ($familyMembers as $member) {
            $genderStr = $member->gender == 1 ? 'Male' : ($member->gender == 2 ? 'Female' : 'Other');
            
            $context .= "- Name: {$member->firstname} {$member->lastname} (Gender: $genderStr)\n";
            if (!empty($member->birthdate)) {
                $context .= "  Born: {$member->birthdate}" . (!empty($member->birthplace) ? " in {$member->birthplace}" : "") . "\n";
            }
            if (!empty($member->deathdate)) {
                $context .= "  Died: {$member->deathdate}" . (!empty($member->deathplace) ? " in {$member->deathplace}" : "") . "\n";
            }
            if (!empty($member->profession) || !empty($member->company)) {
                $context .= "  Work: " . trim("{$member->profession} at {$member->company}", " at ") . "\n";
            }
            if (!empty($member->home_town) || !empty($member->village)) {
                $context .= "  From: " . trim("Hometown: {$member->home_town}, Village: {$member->village}", ", ") . "\n";
            }
            if (!empty($member->school)) $context .= "  Education: {$member->school}\n";
            if (!empty($member->interests)) $context .= "  Interests: {$member->interests}\n";
            
            $bioParts = array_filter([$member->bio, $member->background, $member->business_info]);
            if (!empty($bioParts)) {
                $context .= "  Details: " . implode(" ", $bioParts) . "\n";
            }
            
            // Resolve relationships using parent_id
            if (!empty($member->parent_id) && isset($membersDict[$member->parent_id])) {
                $relPerson = $membersDict[$member->parent_id];
                $relName = "{$relPerson->firstname} {$relPerson->lastname}";
                if ($member->type == 1) {
                    $context .= "  Relationship: Child of $relName\n";
                } elseif ($member->type == 2) {
                    $context .= "  Relationship: Partner/Spouse of $relName\n";
                } elseif ($member->type == 3) {
                    $context .= "  Relationship: Ex-Partner of $relName\n";
                } elseif ($member->type == 4) {
                    $context .= "  Relationship: Parent of $relName\n";
                } else {
                    $context .= "  Relationship: Connected to $relName\n";
                }
            }
            $context .= "\n";
        }
        $context .= "Based on the detailed family tree data above, please answer the user's query comprehensively. If the user asks for relationships, trace them through the provided connections to figure out how people are related (e.g. grandchild, sibling, grandparent, aunt/uncle, cousin). If the information is not in the context, state that you don't have that specific detail.";

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
