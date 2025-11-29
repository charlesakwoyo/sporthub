<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // FAQ data - in a real app, this would come from a database
        $faqs = [
            [
                'question' => 'How can I register for an event?',
                'answer' => 'You can register for events by visiting the event page and clicking on the "Register Now" button. You\'ll need to be logged in to complete the registration.'
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards, PayPal, and bank transfers for event registrations and ticket purchases.'
            ],
            [
                'question' => 'Can I get a refund if I can\'t attend an event?',
                'answer' => 'Our refund policy varies by event. Please check the specific event details for the refund policy. Generally, refunds are available up to 7 days before the event.'
            ],
            [
                'question' => 'How can I become an event organizer?',
                'answer' => 'We welcome new event organizers! Please contact us through the contact form with details about your event and organization, and our team will get back to you.'
            ],
        ];

        return view('contact', [
            'faqs' => $faqs
        ]);
    }

    /**
     * Handle contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
            'g-recaptcha-response' => 'required|recaptchav3:contact,0.5',
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
            'g-recaptcha-response.recaptchav3' => 'Failed reCAPTCHA verification. Please try again.'
        ]);

        try {
            // Save the message to the database
            $message = ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send email notification to admin
            Mail::to(config('mail.admin_email'))
                ->send(new ContactFormSubmitted($message));

            return redirect()->back()
                ->with('success', 'Thank you for contacting us! We will get back to you soon.');

        } catch (\Exception $e) {
            Log::error('Contact form submission error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error submitting your message. Please try again later.');
        }
    }
}
