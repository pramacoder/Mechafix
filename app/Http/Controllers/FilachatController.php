<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use App\Models\Admin;
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;
use App\Models\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class FilachatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Halaman index chat untuk konsumen (list contact)
    public function chatIndex()
    {
        try {
            $konsumen = Auth::user()->konsumen;

            if (!$konsumen) {
                return redirect()->route('konsumen.dashboard')->with('error', 'Konsumen profile not found');
            }

            // Ambil daftar admin dan mekanik
            $daftarAdmin = Admin::with('user')->get();
            $daftarMekanik = Mekanik::with('user')->get();

            return view('konsumen.chat_contact', compact('daftarAdmin', 'daftarMekanik'));
        } catch (\Exception $e) {
            \Log::error('Error in FilachatController@chatIndex:', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('konsumen.dashboard')->with('error', 'Terjadi kesalahan saat membuka chat');
        }
    }

    public function showMekanikChat($mekanik)
    {
        try {
            $mekanikData = Mekanik::with('user')->findOrFail($mekanik);
            $mekanikUser = $mekanikData->user;
            $konsumen = Auth::user()->konsumen;

            if (!$konsumen) {
                return redirect()->route('konsumen.dashboard')->with('error', 'Konsumen profile not found');
            }

            // Ambil daftar admin dan mekanik untuk sidebar
            $daftarAdmin = Admin::with('user')->get();
            $daftarMekanik = Mekanik::with('user')->get();

            // Cari atau buat conversation
            $conversation = FilachatConversation::where(function ($query) use ($konsumen, $mekanikData) {
                $query->where('senderable_type', 'App\Models\Konsumen')
                    ->where('senderable_id', $konsumen->id_konsumen)
                    ->where('receiverable_type', 'App\Models\Mekanik')
                    ->where('receiverable_id', $mekanikData->id_mekanik);
            })->orWhere(function ($query) use ($konsumen, $mekanikData) {
                $query->where('senderable_type', 'App\Models\Mekanik')
                    ->where('senderable_id', $mekanikData->id_mekanik)
                    ->where('receiverable_type', 'App\Models\Konsumen')
                    ->where('receiverable_id', $konsumen->id_konsumen);
            })->first();

            // Jika belum ada conversation, buat baru
            if (!$conversation) {
                $conversation = FilachatConversation::create([
                    'senderable_type' => 'App\Models\Konsumen',
                    'senderable_id' => $konsumen->id_konsumen,
                    'receiverable_type' => 'App\Models\Mekanik',
                    'receiverable_id' => $mekanikData->id_mekanik,
                ]);
            }

            // Ambil messages
            $messages = $conversation->messages()
                ->with(['senderable', 'receiverable'])
                ->orderBy('created_at', 'asc')
                ->get();

            return view('konsumen.chat_contact', compact(
                'mekanikData',  // Ubah dari 'mekanik' jadi 'mekanikData'
                'mekanikUser',
                'conversation',
                'messages',
                'daftarAdmin',
                'daftarMekanik'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in FilachatController@showMekanikChat:', [
                'error' => $e->getMessage(),
                'mekanik_id' => $mekanik,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('konsumen.dashboard')->with('error', 'Terjadi kesalahan saat membuka chat');
        }
    }

    // Chat dengan admin - method name sesuai route
    public function showAdminChat($admin)
    {
        try {
            $adminData = Admin::with('user')->findOrFail($admin);
            $adminUser = $adminData->user;
            $konsumen = Auth::user()->konsumen;

            if (!$konsumen) {
                return redirect()->route('konsumen.dashboard')->with('error', 'Konsumen profile not found');
            }

            // Ambil daftar admin dan mekanik untuk sidebar
            $daftarAdmin = Admin::with('user')->get();
            $daftarMekanik = Mekanik::with('user')->get();

            // Cari atau buat conversation
            $conversation = FilachatConversation::where(function ($query) use ($konsumen, $adminData) {
                $query->where('senderable_type', 'App\Models\Konsumen')
                    ->where('senderable_id', $konsumen->id_konsumen)
                    ->where('receiverable_type', 'App\Models\Admin')
                    ->where('receiverable_id', $adminData->id_admin);
            })->orWhere(function ($query) use ($konsumen, $adminData) {
                $query->where('senderable_type', 'App\Models\Admin')
                    ->where('senderable_id', $adminData->id_admin)
                    ->where('receiverable_type', 'App\Models\Konsumen')
                    ->where('receiverable_id', $konsumen->id_konsumen);
            })->first();

            // Jika belum ada conversation, buat baru
            if (!$conversation) {
                $conversation = FilachatConversation::create([
                    'senderable_type' => 'App\Models\Konsumen',
                    'senderable_id' => $konsumen->id_konsumen,
                    'receiverable_type' => 'App\Models\Admin',
                    'receiverable_id' => $adminData->id_admin,
                ]);
            }

            // Ambil messages
            $messages = $conversation->messages()
                ->with(['senderable', 'receiverable'])
                ->orderBy('created_at', 'asc')
                ->get();

            return view('konsumen.chat_contact', compact(
                'adminData',  // Ubah dari 'admin' jadi 'adminData'
                'adminUser',
                'conversation',
                'messages',
                'daftarAdmin',
                'daftarMekanik'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in FilachatController@showAdminChat:', [
                'error' => $e->getMessage(),
                'admin_id' => $admin,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('konsumen.dashboard')->with('error', 'Terjadi kesalahan saat membuka chat');
        }
    }

    // Send message ke admin - method name sesuai route
    public function sendAdminMessage(Request $request, $admin)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $adminData = Admin::findOrFail($admin);
            $konsumen = Auth::user()->konsumen;

            if (!$konsumen) {
                return back()->with('error', 'Konsumen profile not found');
            }

            // Cari conversation
            $conversation = FilachatConversation::where(function ($query) use ($konsumen, $adminData) {
                $query->where('senderable_type', 'App\Models\Konsumen')
                    ->where('senderable_id', $konsumen->id_konsumen)
                    ->where('receiverable_type', 'App\Models\Admin')
                    ->where('receiverable_id', $adminData->id_admin);
            })->orWhere(function ($query) use ($konsumen, $adminData) {
                $query->where('senderable_type', 'App\Models\Admin')
                    ->where('senderable_id', $adminData->id_admin)
                    ->where('receiverable_type', 'App\Models\Konsumen')
                    ->where('receiverable_id', $konsumen->id_konsumen);
            })->firstOrFail();

            // Create message
            FilachatMessage::create([
                'filachat_conversation_id' => $conversation->id,
                'message' => $request->message,
                'senderable_type' => 'App\Models\Konsumen',
                'senderable_id' => $konsumen->id_konsumen,
                'receiverable_type' => 'App\Models\Admin',
                'receiverable_id' => $adminData->id_admin,
            ]);

            return back()->with('success', 'Pesan terkirim');
        } catch (\Exception $e) {
            \Log::error('Error sending message to admin:', [
                'error' => $e->getMessage(),
                'admin_id' => $admin,
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Gagal mengirim pesan');
        }
    }

    // Send message ke mekanik - method name sesuai route
    public function sendMekanikMessage(Request $request, $mekanik)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $mekanikData = Mekanik::findOrFail($mekanik);
            $konsumen = Auth::user()->konsumen;

            if (!$konsumen) {
                return back()->with('error', 'Konsumen profile not found');
            }

            // Cari conversation
            $conversation = FilachatConversation::where(function ($query) use ($konsumen, $mekanikData) {
                $query->where('senderable_type', 'App\Models\Konsumen')
                    ->where('senderable_id', $konsumen->id_konsumen)
                    ->where('receiverable_type', 'App\Models\Mekanik')
                    ->where('receiverable_id', $mekanikData->id_mekanik);
            })->orWhere(function ($query) use ($konsumen, $mekanikData) {
                $query->where('senderable_type', 'App\Models\Mekanik')
                    ->where('senderable_id', $mekanikData->id_mekanik)
                    ->where('receiverable_type', 'App\Models\Konsumen')
                    ->where('receiverable_id', $konsumen->id_konsumen);
            })->firstOrFail();

            // Create message
            FilachatMessage::create([
                'filachat_conversation_id' => $conversation->id,
                'message' => $request->message,
                'senderable_type' => 'App\Models\Konsumen',
                'senderable_id' => $konsumen->id_konsumen,
                'receiverable_type' => 'App\Models\Mekanik',
                'receiverable_id' => $mekanikData->id_mekanik,
            ]);

            return back()->with('success', 'Pesan terkirim');
        } catch (\Exception $e) {
            \Log::error('Error sending message to mekanik:', [
                'error' => $e->getMessage(),
                'mekanik_id' => $mekanik,
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Gagal mengirim pesan');
        }
    }

    // Existing methods (keep these as well for backward compatibility)
    public function show($mekanik)
    {
        return $this->showMekanikChat($mekanik);
    }

    public function showAdmin($admin)
    {
        return $this->showAdminChat($admin);
    }

    public function sendMessage(Request $request, $mekanik)
    {
        return $this->sendMekanikMessage($request, $mekanik);
    }

    public function sendMessageToAdmin(Request $request, $admin)
    {
        return $this->sendAdminMessage($request, $admin);
    }

    // Methods untuk mekanik (jika dibutuhkan nanti)
    public function mekanikInbox()
    {
        // TODO: Implement untuk mekanik dashboard
        return view('mekanik.chat.inbox');
    }

    public function mekanikChat($conversation)
    {
        // TODO: Implement untuk mekanik chat
        return view('mekanik.chat.conversation');
    }

    public function mekanikReply(Request $request, $conversation)
    {
        // TODO: Implement untuk mekanik reply
        return back();
    }
}
