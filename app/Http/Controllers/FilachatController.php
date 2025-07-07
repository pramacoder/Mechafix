<?php

namespace App\Http\Controllers;

use App\Models\FilachatAgent;
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilachatController extends Controller
{
    // Show chat between konsumen and mekanik (from konsumen side)
    public function showChat($mekanikId)
    {
        $user = Auth::user();
        $konsumenAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $user->id,
            'agentable_type' => get_class($user),
            'role' => 'konsumen',
        ]);
        $mekanik = Mekanik::findOrFail($mekanikId);
        $mekanikUser = $mekanik->user;
        $mekanikAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $mekanikUser->id,
            'agentable_type' => 'App\\Models\\User', // Standardize type
            'role' => 'mekanik',
        ]);
        $conversation = FilachatConversation::firstOrCreate([
            'senderable_id' => $konsumenAgent->id,
            'senderable_type' => get_class($konsumenAgent),
            'receiverable_id' => $mekanikAgent->id,
            'receiverable_type' => get_class($mekanikAgent),
        ]);
        $messages = $conversation->messages()->with('sender.agentable')->orderBy('created_at')->get();
        // Pastikan $stats dan $performance ada agar tidak undefined
        $stats = $stats ?? [];
        $performance = $performance ?? [];
        // Ambil ulang data statistik dan bookings agar view tidak error
        $stats = [
            'total_jobs' => $mekanik->bookingServices()->count(),
            'completed_jobs' => $mekanik->bookingServices()->where('status_booking', 'selesai')->count(),
            'active_jobs' => $mekanik->bookingServices()->where('status_booking', 'dikonfirmasi')->count(),
            'pending_jobs' => $mekanik->bookingServices()->where('status_booking', 'menunggu')->count(),
            'working_days' => $mekanik->created_at ? now()->diffInDays($mekanik->created_at) : 0,
            'working_months' => $mekanik->created_at ? now()->diffInMonths($mekanik->created_at) : 0,
        ];
        // Pastikan working_days dan working_months selalu ada
        if (!isset($stats['working_days'])) $stats['working_days'] = 0;
        if (!isset($stats['working_months'])) $stats['working_months'] = 0;
        $myBookings = $mekanik->bookingServices()
            ->where('id_konsumen', $user->konsumen->id_konsumen ?? null)
            ->with(['platKendaraan', 'transaksiServices.service', 'pembayarans'])
            ->latest()
            ->take(5)
            ->get();
        $total_revenue = $mekanik->bookingServices()
            ->whereHas('pembayarans', function($q) {
                $q->where('status_pembayaran', 'Sudah Dibayar');
            })
            ->with('pembayarans')
            ->get()
            ->sum(function($booking) {
                return $booking->pembayarans->first()->total_pembayaran ?? 0;
            });
        $performance = [
            'completion_rate' => $stats['total_jobs'] > 0 ? round(($stats['completed_jobs'] / $stats['total_jobs']) * 100) : 0,
            'avg_jobs_per_month' => $stats['working_months'] > 0 ? round($stats['total_jobs'] / $stats['working_months'], 1) : 0,
            'total_revenue' => $total_revenue,
        ];
        return view('konsumen.mekanik-profile', compact('mekanik', 'mekanikUser', 'conversation', 'messages', 'stats', 'performance', 'myBookings'));
    }

    // Konsumen sends message to mekanik
    public function sendMessage(Request $request, $mekanikId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $user = Auth::user();
        $konsumenAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $user->id,
            'agentable_type' => get_class($user),
            'role' => 'konsumen',
        ]);
        $mekanikUser = Mekanik::findOrFail($mekanikId)->user;
        $mekanikAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $mekanikUser->id,
            'agentable_type' => 'App\\Models\\User', // Standardize type
            'role' => 'mekanik',
        ]);
        $conversation = FilachatConversation::firstOrCreate([
            'senderable_id' => $konsumenAgent->id,
            'senderable_type' => get_class($konsumenAgent),
            'receiverable_id' => $mekanikAgent->id,
            'receiverable_type' => get_class($mekanikAgent),
        ]);
        FilachatMessage::create([
            'filachat_conversation_id' => $conversation->id,
            'message' => $request->message,
            'senderable_id' => $konsumenAgent->id,
            'senderable_type' => get_class($konsumenAgent),
            'receiverable_id' => $mekanikAgent->id,
            'receiverable_type' => get_class($mekanikAgent),
        ]);
        return redirect()->route('filachat.show', ['mekanik' => $mekanikId]);
    }

    // Mekanik inbox: list all conversations for this mekanik
    public function mekanikInbox()
    {
        $user = Auth::user();
        $mekanikAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $user->id,
            'agentable_type' => get_class($user),
            'role' => 'mekanik',
        ]);
        $conversations = FilachatConversation::where('receiverable_id', $mekanikAgent->id)
            ->where('receiverable_type', get_class($mekanikAgent))
            ->with(['sender.agentable', 'messages' => function ($q) {
                $q->orderBy('created_at', 'asc');
            }])
            ->get()
            ->sortByDesc(function($conv) {
                return optional($conv->messages->last())->created_at;
            });
        return view('dashboard.mekanik', compact('conversations'));
    }

    // Mekanik replies to a conversation
    public function mekanikReply(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $user = Auth::user();
        $mekanikAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $user->id,
            'agentable_type' => get_class($user),
            'role' => 'mekanik',
        ]);
        $conversation = FilachatConversation::findOrFail($conversationId);
        if ($conversation->receiverable_id != $mekanikAgent->id || $conversation->receiverable_type != get_class($mekanikAgent)) {
            abort(403);
        }
        FilachatMessage::create([
            'filachat_conversation_id' => $conversation->id,
            'message' => $request->message,
            'senderable_id' => $mekanikAgent->id,
            'senderable_type' => get_class($mekanikAgent),
            'receiverable_id' => $conversation->senderable_id,
            'receiverable_type' => $conversation->senderable_type,
        ]);
        return redirect()->route('dashboard');
    }

    // Mekanik views a specific chat thread
    public function mekanikChat($conversationId)
    {
        $user = Auth::user();
        $mekanikAgent = FilachatAgent::firstOrCreate([
            'agentable_id' => $user->id,
            'agentable_type' => get_class($user),
            'role' => 'mekanik',
        ]);
        $conversation = FilachatConversation::with([
            'sender.agentable',
            'messages.sender.agentable'
        ])->findOrFail($conversationId);

        // Authorization: only allow if this mekanik is the receiver
        if ($conversation->receiverable_id != $mekanikAgent->id || $conversation->receiverable_type != get_class($mekanikAgent)) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender.agentable')->orderBy('created_at')->get();

        return view('dashboard.mekanik-chat', compact('conversation', 'messages'));
    }
}
