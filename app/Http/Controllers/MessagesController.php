<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function messagefrom()
    {
        return view("admin-view.messages.messagefrom");
    }

    public function messageto()
    {

        $messages = Messages::where("sender_id", 0)->get();
        return view("admin-view.messages.messageto", compact('messages'));
    }
    public function usermessages()
    {
        $auth = Auth::user();
        $messages = Messages::where('sender_id', $auth->id)->get();

        return view('user-view.messages.messagefrom', compact('messages'));
    }
    public function usermessagesto()
    {
        $auth = Auth::user();
        $messages = Messages::where('recipient_id', $auth->id)->get();
        return view("user-view.messages.messageto", compact('messages'));
    }
    public function create()
    {
        $members = User::all();
        return view('admin-view.messages.createmessage', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:tbl_user,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Messages::create([
            'sender_id' => 0,
            'recipient_id' => $request->recipient_id,
            'subject' => $request->subject,
            'body' => $request->message,
        ]);

        return redirect()->route('admin.messages.create')
         ->with(__('messages.success'), __('messages.Message sent successfully.'));
    }
    public function usersstore(Request $request)
    {
        // dd($request->all());
        $message = new Messages();
        $message->recipient_id = $request->category_id;
        $message->subject = $request->subject;
        $message->body = $request->message;
        $message->sender_id = auth()->id();
        $message->save();

        return redirect()->back()
            ->with(__('messages.success'), __('messages.Message sent successfully.'));
    }
    public function sendmessage()
    {
        $members = Member::get();
        return view("user-view.messages.createmessage", compact("members"));
    }
    public function show($id)
    {
        $message = Messages::with(['replies.sender'])->findOrFail($id);

        // Mark as read if not already
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view('admin-view.messages.show', compact('message'));
    }
    public function usershow($id)
    {
        $message = Messages::with(['replies.sender'])->findOrFail($id);

        // Mark as read if not already
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view('user-view.messages.show', compact('message'));
    }
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_body' => 'required|string|max:5000',
        ]);

        $original = Messages::findOrFail($id);

        Messages::create([
            'sender_id' => 0, // admin
            'recipient_id' => $original->sender_id ?: $original->recipient_id,
            'subject' => 'RE: ' . $original->subject,
            'body' => $request->reply_body,
            'parent_id' => $original->id,
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.messages.show', $id)
            ->with(__('messages.success'), __('messages.Reply sent successfully.'));
    }
}
