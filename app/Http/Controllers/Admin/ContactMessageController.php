<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the contact messages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display the specified contact message.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\View\View
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewing
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }
        
        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Mark a message as read.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Mark a message as unread.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => false]);
        return back()->with('success', 'Message marked as unread.');
    }

    /**
     * Remove the specified contact message from storage.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully');
    }

    /**
     * Mark all messages as read.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All messages marked as read.');
    }
}
