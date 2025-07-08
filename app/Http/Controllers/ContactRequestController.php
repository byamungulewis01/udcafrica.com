<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\User;
use App\Notifications\NewContactRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Notification;

class ContactRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactRequest::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Apply date filter
        if ($request->has('date_filter') && $request->date_filter !== 'all') {
            $now = now();
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'last_week':
                    $query->where('created_at', '>=', $now->subWeek());
                    break;
            }
        }

        // Get paginated results
        $contactRequests = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/ContactRequests/Index', [
            'contactRequests' => $contactRequests,
            'filters' => $request->only(['search', 'status', 'date_filter'])
        ]);
    }

    public function store(Request $request)
    {
        // Rate limiting: 6 requests per hour per IP
        $key = 'contact_form:' . $request->ip();
        $maxAttempts = 6;
        $decayMinutes = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['rate_limit' => "Too many attempts. Please try again in {$seconds} seconds."])->withInput();
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create contact request
        $contactRequest = ContactRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'subject' => $request->subject,
            'status' => 'new'
        ]);

        // Send notification to info@resilience.rw
        // $infoEmail = env('INFO_EMAIL', 'info@resilience.rw');

        // Use Laravel's on-demand notifications instead
        // Notification::route('mail', $infoEmail)
        //     ->notify(new NewContactRequest($contactRequest));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    public function updateStatus(Request $request, ContactRequest $contactRequest)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,in_progress,completed,spam'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $contactRequest->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status updated successfully');
    }

    public function destroy(ContactRequest $contactRequest)
    {
        $contactRequest->delete();
        return back()->with('success', 'Contact request deleted successfully');
    }

    private function verifyRecaptcha($token)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}
