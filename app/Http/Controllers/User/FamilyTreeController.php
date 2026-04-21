<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest\FamilyTreeStoreRequest;
use App\Http\Requests\UserRequest\FamilyTreeUpdateRequest;
use App\Http\Requests\UserRequest\MemberStoreRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyTree;
use App\Models\Member;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
class FamilyTreeController extends Controller
{
    public function index()
    {
        $FamilyTreeInfo = Member::with("family")->where("parent_id", 0)->get();
        // dd($FamilyTreeInfo);
        return view("user-view.familytree.index", compact("FamilyTreeInfo"));
    }
    public function create()
    {

        return view("user-view.familytree.create");
    }
    public function store(FamilyTreeStoreRequest $request)
    {
        $familyid = $request->familyid;

        $now = date('Y-m-d H:i:s');
        $update_date = date('Y-m-d H:i:s');


        try {
            $values = array('ownerId' => Auth::guard("web")->user()->id, 'familyid' => $familyid, 'created_at' => $now, 'updated_at' => $update_date);
            FamilyTree::insert($values);
            return redirect()->back()->with(__('messages.success'), __('messages.FamilyTree Created Successfully'));
        } catch (\Illuminate\Database\QueryException $ex) {
            return Response()->json([]);
        }
    }

    public function deleteFamilyTree(Request $request)
    {
        try {
            // Find the family tree by ID
            $familyTree = FamilyTree::findOrFail($request->id);

            // Update the status of the family tree to 2 (soft delete)
            $familyTree->status = 2;
            $familyTree->save();

            // Return a JSON response
            return response()->json(['message' => __('messages.Family tree status updated successfully.')], 200);
        } catch (Exception $e) {
            // If something goes wrong, return an error message
            return response()->json(['message' => __('messages.An error occurred while updating the family tree status.')], 500);
        }
    }

    public function update(FamilyTreeUpdateRequest $request)
    {
        $editfamilyid = $request->editfamilyid;
        $editid = $request->editid;

        try {
            FamilyTree::where('id', $editid)
                ->update([
                    'familyid' => $editfamilyid
                ]);
            return response()->json(['message' => __('messages.Update information successfully')], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
        }
    }

public function addmember($id)
{
    $Id = Crypt::decryptString($id);
    $hasMembers = Member::where('family_id', $Id)->exists();

    $auth = Auth::user();
    $locale = Session::get('locale', App::getLocale()); // fallback to app locale if not in session

    // Check if current language is Korean
    if ($locale === 'ko') {
        return view('user-view.familytree.korean', [
            'id' => $Id,
            'hasMembers' => $hasMembers,
        ]);
    }

    // Return view based on user template
    if ($auth->template === 'First Template') {
        return view('user-view.familytree.horizontaladdmember', [
            'id' => $Id,
            'hasMembers' => $hasMembers,
        ]);
    } else {
        return view('user-view.familytree.addmember', [
            'id' => $Id,
            'hasMembers' => $hasMembers,
        ]);
    }
}
    public function memberstore(MemberStoreRequest $request)
    {
        // Extract basic data
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $email = $request->email;
        $gender = $request->gender;
        $family_id = $request->family_id;
        $mobile = $request->mobile;

        // Random password generation
        $originalPassword = Str::random(8); // You can change the length
        $hashedPassword = Hash::make($originalPassword);

        // Upload primary photo
        $photo = null;
        if ($request->hasFile('poll_file')) {
            $imageName = $request->file('poll_file');
            $photo = rand() . '' . time() . '.' . $imageName->extension();
            $imageName->move(public_path('assets/front-end/Memberimgs'), $photo);
        }

        // Upload multiple documents
        $multiplePhotos = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image) {
                    $imageName = rand() . time() . '.' . $image->extension();
                    $image->move(public_path('assets/front-end/MemberDocuments'), $imageName);
                    $multiplePhotos[] = $imageName;
                }
            }
        }
        $multiplePhotosString = implode('**', $multiplePhotos);

        // Determine parent ID
        $parent_id = ($request->self_id == '0' || $request->type == '4') ? 0 : $request->self_id;

        try {
            // Save Member
            $member = new Member();
            $member->family_id = $family_id;
            $member->parent_id = $parent_id;
            $member->firstname = $firstname;
            $member->lastname = $lastname;
            $member->type = $request->type;
            $member->gender = $gender;
            $member->death = $request->has('death') ? 1 : 0;
            $member->village = $request->village;
            $member->birthdate = $request->birthdate;
            $member->marriagedate = $request->marriagedate;
            $member->deathdate = $request->deathdate;
            $member->user = $request->user;
            $member->photo = $photo;
            $member->avatar = $request->avatar;
            $member->facebook = $request->facebook;
            $member->twitter = $request->twitter;
            $member->instagram = $request->instagram;
            $member->email = $email;
            $member->tel = $request->tel;
            $member->mobile = $mobile;
            $member->site = $request->site;
            $member->birthplace = $request->birthplace;
            $member->deathplace = $request->deathplace;
            $member->profession = $request->profession;
            $member->company = $request->company;
            $member->interests = $request->interests;
            $member->bio = $request->bio;
            $member->images = $multiplePhotosString;
            $member->save();
            $lastInsertedId = $member->id;

            // Update parent for type 4
            if ($request->self_id != '0' && $request->type == '4') {
                $existing = Member::find($request->self_id);
                if ($existing) {
                    $existing->parent_id = $lastInsertedId;
                    $existing->save();
                }
            }

            // Create corresponding User
            $user = new User(); // Adjust namespace if needed
            $user->name = $firstname . ' ' . $lastname;
            $user->email = $email;
            $user->password = $hashedPassword;
            $user->original_password = $originalPassword; // Ensure this is safe to store
            $user->familyId = $family_id;
            $user->gender = $gender;
            $user->phone = $mobile;
            $user->save();
            return redirect()->back()->with('success','messages.Member and user created successfully');
            
        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'error' => __('messages.Failed to create member or user'),
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function firstmemberstore(Request $request)
    {
        // Check if family tree already exists
        $familyTreeExists = FamilyTree::where('familyid', $request->family_id)->first();

        if (!$familyTreeExists) {
            $familyTree = new FamilyTree();
            $familyTree->familyid = $request->family_id;
            $familyTree->ownerId = auth()->id(); // Gets currently logged-in user ID
            $familyTree->Status = 1;
            $familyTree->save();
        }

        $familyTreeExists = FamilyTree::where('familyid', $request->family_id)->first();

        // Extract data
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $email = $request->email;
        $gender = $request->gender;
        $mobile = $request->mobile;

        // Generate random password
        $originalPassword = Str::random(8);
        $hashedPassword = Hash::make($originalPassword);

        // File upload - photo
        $photo = null;
        if ($request->hasFile('poll_file')) {
            $imageName = $request->file('poll_file');
            $photo = rand() . '' . time() . '.' . $imageName->extension();
            $imageName->move(public_path('assets/front-end/Memberimgs'), $photo);
        }

        // File upload - multiple documents
        $multiplePhotos = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image) {
                    $imageName = rand() . time() . '.' . $image->extension();
                    $image->move(public_path('assets/front-end/MemberDocuments'), $imageName);
                    $multiplePhotos[] = $imageName;
                }
            }
        }
        $multiplePhotosString = implode('**', $multiplePhotos);

        // Determine parent ID
        $parent_id = ($request->self_id == '0' || $request->type == '4') ? 0 : $request->self_id;

        try {
            // Save Member
            $member = new Member();
            $member->family_id = $familyTreeExists->id;
            $member->parent_id = $parent_id;
            $member->firstname = $firstname;
            $member->lastname = $lastname;
            $member->type = 4;
            $member->gender = $gender;
            $member->death = $request->has('death') ? 1 : 0;
            $member->village = $request->village;
            $member->birthdate = $request->birthdate;
            $member->marriagedate = $request->marriagedate;
            $member->deathdate = $request->deathdate;
            $member->user = $request->user;
            $member->photo = $photo;
            $member->avatar = $request->avatar;
            $member->facebook = $request->facebook;
            $member->twitter = $request->twitter;
            $member->instagram = $request->instagram;
            $member->email = $email;
            $member->tel = $request->tel;
            $member->mobile = $mobile;
            $member->site = $request->site;
            $member->birthplace = $request->birthplace;
            $member->deathplace = $request->deathplace;
            $member->profession = $request->profession;
            $member->company = $request->company;
            $member->interests = $request->interests;
            $member->bio = $request->bio;
            $member->home_town = $request->home_town;
            $member->school = $request->school;
            $member->background = $request->background_details;
            $member->business_info = $request->business_info;
            $member->images = $multiplePhotosString;
            $member->save();

            // Create User
            $user = new User(); // Adjust namespace if different
            $user->name = $firstname . ' ' . $lastname;
            $user->email = $email;
            $user->password = $hashedPassword;
            $user->original_password = $originalPassword; // Optional: store securely or send via email
            $user->familyId = $familyTreeExists->id;
            $user->gender = $gender;
            $user->phone = $mobile;
            $user->save();

            return redirect()->back()
                ->with(__('messages.success'), __('messages.Member and user added successfully'));
        } catch (Exception $e) {
            return response()->json([
                'error' => __('messages.Failed to create member or user'),
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function editModal($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['error' => __('messages.Member not found')], 404);
        }
        // Return the modal view with member data
        return view('user-view.familytree.editmember', compact('member'));
    }

public function updateMember(Request $request, $id)
{
    // Find the member by ID
    $member = Member::findOrFail($id);

    // Update member with all input values (only fields that exist in the $request)
    $member->update($request->only([
        'firstname',
        'lastname',
        'type',
        'gender',
        'death',
        'birthdate',
        'marriagedate',
        'deathdate',
        'user',
        'facebook',
        'twitter',
        'instagram',
        'email',
        'tel',
        'mobile',
        'site',
        'birthplace',
        'deathplace',
        'profession',
        'company',
        'interests',
        'bio',
        'avatar',
    ]));

    // Encrypt and redirect
    $encryptedId = Crypt::encryptString($member->family_id);
    return redirect()->route('user.addmember', ['id' => $encryptedId]);
}


    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.Member not found')
            ], 404);
        }
        try {
            $member->delete();
            return response()->json([
                'status' => "success",
                'message' => __('messages.Member deleted successfully.')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.An error occurred while deleting the member.')
            ], 500);
        }
    }

    public function getFamilyTree($id)
    {
        // Fetch members by family_id and order by type
        $members = Member::where('family_id', $id)->get();

        if ($members->isEmpty()) {
            return response()->json(['error' => __('messages.No members found for the given family_id')], 404);
        }

        // Build the hierarchical structure
        $tree = $this->buildHierarchy($members);
        
        // Return the hierarchy as a JSON response
        return response()->json($tree);
    }

private function buildHierarchy($members)
{
    $hierarchy = [];
    $map = [];
    $attachedIds = [];

    // Initialize map and relationship arrays
    foreach ($members as $member) {
        if (!isset($member->id) || !isset($member->type)) continue;

        $member->children = collect();
        $member->partners = collect();
        $member->exPartners = collect();
        $member->spouses = collect();
        $member->siblings = collect();
        $member->uncles = collect();
        $member->cousins = collect();

        $map[$member->id] = $member;
    }

    // First pass: attach relationships by type
    foreach ($members as $member) {
        if ($member->parent_id && isset($map[$member->parent_id])) {
            $parent = $map[$member->parent_id];

            // Skip if already attached
            if (isset($attachedIds[$member->id])) continue;

            switch ($member->type) {
                case 1: // Child
                    $parent->children->push($member);
                    $attachedIds[$member->id] = 'children';
                    break;
                case 2: // Partner
                    $parent->partners->push($member);
                    $attachedIds[$member->id] = 'partners';
                    break;
                case 3: // Ex-partner
                    $parent->exPartners->push($member);
                    $attachedIds[$member->id] = 'exPartners';
                    break;
                case 5: // Spouse
                    $parent->spouses->push($member);
                    $attachedIds[$member->id] = 'spouses';
                    break;
                case 6: // Sibling
                    $parent->siblings->push($member);
                    $attachedIds[$member->id] = 'siblings';
                    break;
                case 7: // Uncle (parent's sibling)
                    if ($parent->parent_id && isset($map[$parent->parent_id])) {
                        $grandparent = $map[$parent->parent_id];
                        $grandparent->children->push($member); // sibling of parent
                        $parent->uncles->push($member);
                        $attachedIds[$member->id] = 'uncles';
                    }
                    break;
                case 8: // Cousin (child of parent's sibling)
                    if ($parent->parent_id) {
                        foreach ($map as $potentialUncle) {
                            if (
                                $potentialUncle->parent_id == $parent->parent_id &&
                                $potentialUncle->id != $parent->id
                            ) {
                                $potentialUncle->children->push($member); // cousin under uncle
                                $parent->cousins->push($member);
                                $attachedIds[$member->id] = 'cousins';
                                break;
                            }
                        }
                    }
                    break;
            }
        } else {
            // No parent: root
            if ($member->type == 4 && !isset($attachedIds[$member->id])) {
                $hierarchy[] = $member;
                $attachedIds[$member->id] = 'root';
            }
        }
    }

    // Fallback for disconnected members
    foreach ($members as $member) {
        if (!isset($attachedIds[$member->id])) {
            $hierarchy[] = $member;
            $attachedIds[$member->id] = 'fallback';
        }
    }

    return $hierarchy;
}   
    public function listing()
    {

        return view("user-view.familytree.familylisting");
    }
}
