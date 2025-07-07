<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mekanik;
use App\Models\Konsumen;
use App\Models\FilachatAgent;
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilachatController extends Controller
{
    // Index - halaman utama chat konsumen
    public function index()
    {
        return view('konsumen.chat_contact');
    }

    // Show admin chat untuk konsumen
    public function showAdminChat(Admin $admin)
    {
        $konsumen = auth()->user()->konsumen;
        
        if (!$konsumen) {
            return redirect()->route('konsumen.chat')->with('error', 'Data konsumen tidak ditemukan');
        }

        // Cari atau buat conversation antara konsumen dan admin
        $conversation = FilachatConversation::firstOrCreate([
            'senderable_type' => 'App\Models\Konsumen',
            'senderable_id' => $konsumen->id_konsumen,
            'receiverable_type' => 'App\Models\Admin',
            'receiverable_id' => $admin->id_admin,
        ]);

        // Ambil messages untuk conversation ini
        $messages = FilachatMessage::where('filachat_conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('konsumen.chat_contact', [
            'admin' => $admin,
            'adminUser' => $admin->user,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    // Send message ke admin
    public function sendAdminMessage(Request $request, Admin $admin)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $konsumen = auth()->user()->konsumen;
        
        if (!$konsumen) {
            return redirect()->route('konsumen.chat')->with('error', 'Data konsumen tidak ditemukan');
        }

        // Cari atau buat conversation
        $conversation = FilachatConversation::firstOrCreate([
            'senderable_type' => 'App\Models\Konsumen',
            'senderable_id' => $konsumen->id_konsumen,
            'receiverable_type' => 'App\Models\Admin',
            'receiverable_id' => $admin->id_admin,
        ]);

        // Buat message baru
        FilachatMessage::create([
            'filachat_conversation_id' => $conversation->id,
            'message' => $request->message,
            'senderable_type' => 'App\Models\Konsumen',
            'senderable_id' => $konsumen->id_konsumen,
            'receiverable_type' => 'App\Models\Admin',
            'receiverable_id' => $admin->id_admin,
        ]);

        return redirect()->route('filachat.admin.show', $admin->id_admin);
    }

    // Show mekanik chat untuk konsumen
    public function showMekanikChat(Mekanik $mekanik)
    {
        $konsumen = auth()->user()->konsumen;
        
        if (!$konsumen) {
            return redirect()->route('konsumen.chat')->with('error', 'Data konsumen tidak ditemukan');
        }

        // Cari atau buat conversation antara konsumen dan mekanik
        $conversation = FilachatConversation::firstOrCreate([
            'senderable_type' => 'App\Models\Konsumen',
            'senderable_id' => $konsumen->id_konsumen,
            'receiverable_type' => 'App\Models\Mekanik',
            'receiverable_id' => $mekanik->id_mekanik,
        ]);

        // Ambil messages untuk conversation ini
        $messages = FilachatMessage::where('filachat_conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('konsumen.chat_contact', [
            'mekanik' => $mekanik,
            'mekanikUser' => $mekanik->user,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    // Send message ke mekanik
    public function sendMekanikMessage(Request $request, Mekanik $mekanik)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $konsumen = auth()->user()->konsumen;
        
        if (!$konsumen) {
            return redirect()->route('konsumen.chat')->with('error', 'Data konsumen tidak ditemukan');
        }

        // Cari atau buat conversation
        $conversation = FilachatConversation::firstOrCreate([
            'senderable_type' => 'App\Models\Konsumen',
            'senderable_id' => $konsumen->id_konsumen,
            'receiverable_type' => 'App\Models\Mekanik',
            'receiverable_id' => $mekanik->id_mekanik,
        ]);

        // Buat message baru
        FilachatMessage::create([
            'filachat_conversation_id' => $conversation->id,
            'message' => $request->message,
            'senderable_type' => 'App\Models\Konsumen',
            'senderable_id' => $konsumen->id_konsumen,
            'receiverable_type' => 'App\Models\Mekanik',
            'receiverable_id' => $mekanik->id_mekanik,
        ]);

        return redirect()->route('filachat.show', $mekanik->id_mekanik);
    }

    // Legacy methods for backward compatibility (menggunakan FilachatAgent system)
    
    // Show chat between konsumen and mekanik (legacy - redirect to new method)
    public function showChat($mekanikId)
    {
        $mekanik = Mekanik::findOrFail($mekanikId);
        return $this->showMekanikChat($mekanik);
    }

    // Send message (legacy - redirect to new method)
    public function sendMessage(Request $request, $mekanikId)
    {
        $mekanik = Mekanik::findOrFail($mekanikId);
        return $this->sendMekanikMessage($request, $mekanik);
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
            ->sortByDesc(function ($conv) {
                return optional($conv->messages->last())->created_at;
            });
            
        return view('dashboard.mekanik', compact('conversations'));
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
}