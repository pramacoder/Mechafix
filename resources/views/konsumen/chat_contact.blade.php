@php
    $admin = $admin ?? null;
    $adminUser = $adminUser ?? null;
    $mekanikUser = $mekanikUser ?? null;
    $messages = $messages ?? collect();
    $formAction = '#';
    if ($admin && optional($admin)->id_admin) {
        $formAction = route('filachat.admin.send', ['admin' => $admin->id_admin]);
    } elseif (isset($mekanik) && isset($mekanik->id_mekanik)) {
        $formAction = route('filachat.send', ['mekanik' => $mekanik->id_mekanik]);
    }
    $daftarAdmin = \App\Models\Admin::with('user')->get();
    $daftarMekanik = \App\Models\Mekanik::with('user')->get();
@endphp

<x-layoutkonsumen>
    <div class="flex flex-col md:flex-row gap-4 max-w-6xl mx-auto min-h-[70vh] relative">
        <!-- Mobile Toggle Button -->
        <button id="sidebarToggle"
            class="md:hidden fixed top-20 left-4 z-50 bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-full shadow-lg transition-all duration-300">
            <svg id="toggleIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Mobile Overlay -->
        <div id="sidebarOverlay"
            class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-30 opacity-0 pointer-events-none transition-opacity duration-300">
        </div>

        <!-- Sidebar Contact -->
        <aside id="sidebar"
            class="w-full md:w-1/4 bg-white rounded-2xl shadow-md flex flex-col max-h-[70vh] transition-all duration-300 transform 
                              md:translate-x-0 md:relative md:opacity-100 md:pointer-events-auto md:z-auto
                              fixed top-0 left-0 z-40 -translate-x-full opacity-0 pointer-events-none h-screen md:h-auto">
            <!-- Header - Fixed -->
            <div class="p-4 border-b border-gray-100 flex-shrink-0 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-orange-600">Contact</h2>
                <button id="closeSidebar" class="md:hidden text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <!-- Admin Section -->
                <div class="pb-4">
                    <div class="sticky top-0 bg-white z-10 px-4 pt-4 pb-2 border-b border-gray-50">
                        <button id="adminToggle"
                            class="w-full text-left hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                Admin
                                <span
                                    class="ml-auto text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">{{ $daftarAdmin->count() }}</span>
                                <svg id="adminChevron"
                                    class="w-4 h-4 ml-2 text-gray-400 transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                        </button>
                    </div>
                    <div id="adminList" class="px-4 pt-2 transition-all duration-300">
                        <ul class="space-y-2">
                            @foreach ($daftarAdmin as $adm)
                                <li>
                                    <a href="{{ route('filachat.admin.show', ['admin' => $adm->id_admin]) }}"
                                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-all duration-200 group {{ isset($admin) && $admin->id_admin == $adm->id_admin ? 'bg-blue-50 border border-blue-200 shadow-sm' : 'hover:shadow-sm' }} contact-link">
                                        <div class="relative">
                                            <span
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                                {{ strtoupper(substr($adm->user->name ?? 'A', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="font-medium text-gray-900 block truncate group-hover:text-blue-700 transition-colors">{{ $adm->user->name ?? 'Admin' }}</span>
                                            <div class="text-xs text-gray-500 flex items-center mt-1">
                                            </div>
                                        </div>
                                        @if (isset($admin) && $admin->id_admin == $adm->id_admin)
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Separator -->
                <div class="mx-4 border-t border-gray-200"></div>

                <!-- Mekanik Section -->
                <div class="pb-4">
                    <div class="sticky top-16 bg-white z-10 px-4 pt-4 pb-2 border-b border-gray-50">
                        <button id="mekanikToggle"
                            class="w-full text-left hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                Mekanik
                                <span
                                    class="ml-auto text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full font-medium">{{ $daftarMekanik->count() }}</span>
                                <svg id="mekanikChevron"
                                    class="w-4 h-4 ml-2 text-gray-400 transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                        </button>
                    </div>
                    <div id="mekanikList" class="px-4 pt-2 transition-all duration-300">
                        <ul class="space-y-2">
                            @foreach ($daftarMekanik as $mek)
                                <li>
                                    <a href="{{ route('filachat.show', ['mekanik' => $mek->id_mekanik]) }}"
                                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-orange-50 transition-all duration-200 group {{ isset($mekanik) && $mekanik->id_mekanik == $mek->id_mekanik ? 'bg-orange-50 border border-orange-200 shadow-sm' : 'hover:shadow-sm' }} contact-link">
                                        <div class="relative">
                                            <span
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-500 to-orange-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                                {{ strtoupper(substr($mek->user->name ?? 'M', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="font-medium text-gray-900 block truncate group-hover:text-orange-700 transition-colors">{{ $mek->user->name ?? 'Mekanik' }}</span>
                                            <div class="text-xs text-gray-500 flex items-center mt-1">
                                            </div>
                                        </div>
                                        @if (isset($mekanik) && $mekanik->id_mekanik == $mek->id_mekanik)
                                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Chat Area -->
        <div class="flex-1 bg-white rounded-2xl shadow-lg flex flex-col">
            <!-- Header -->
            <div
                class="px-6 py-4 border-b flex items-center gap-4 bg-gradient-to-r from-gray-50 to-orange-50 flex-shrink-0 rounded-t-2xl">
                <div class="relative">
                    <div
                        class="w-12 h-12 rounded-full {{ isset($admin) ? 'bg-gradient-to-r from-blue-500 to-blue-600' : 'bg-gradient-to-r from-orange-500 to-orange-600' }} flex items-center justify-center text-white font-bold text-lg shadow-md">
                        {{ strtoupper(substr(optional($adminUser)->name ?? (optional($mekanikUser)->name ?? 'U'), 0, 1)) }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-lg text-gray-900">
                        {{ optional($adminUser)->name ?? (optional($mekanikUser)->name ?? 'Pilih kontak') }}
                    </div>
                    <div class="text-sm flex items-center gap-2 mt-1">
                        @if ($admin)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 font-medium">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Admin
                            </span>
                        @elseif($mekanikUser)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800 font-medium">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                        clip-rule="evenodd"></path>
                                    <path
                                        d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z">
                                    </path>
                                </svg>
                                Mekanik
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chat Body -->
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4 custom-scrollbar bg-white" style="background-size: cover;">
                @if (isset($conversation))
                    @if ($messages->count())
                        @foreach ($messages as $msg)
                            @php
                                $isKonsumen = $msg->senderable_type === get_class($conversation->sender) && $msg->senderable_id === $conversation->senderable_id;
                            @endphp
                            <div class="flex items-end {{ $isKonsumen ? 'justify-end' : 'justify-start' }} mb-2">
                                @if (!$isKonsumen)
                                    <div class="w-9 h-9 rounded-full bg-orange-500 flex items-center justify-center mr-2 text-white font-bold shadow">
                                        {{ strtoupper(substr($msg->sender->agentable->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="relative max-w-xs md:max-w-md px-4 py-3 rounded-2xl shadow
                                    {{ $isKonsumen ? 'bg-purple-600 text-white' : 'bg-orange-500 text-white' }}">
                                    <div class="text-sm break-words pb-2">{{ $msg->message }}</div>
                                    <div class="text-xs absolute bottom-1 right-3 opacity-70">{{ $msg->created_at->format('H:i') }}</div>
                                </div>
                                @if ($isKonsumen)
                                    <div class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center ml-2 text-white font-bold shadow">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'K', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-400 mt-20">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-600">Belum ada pesan</p>
                            <p class="text-sm text-gray-500">Kirim pesan untuk memulai chat</p>
                        </div>
                    @endif
                @else
                    <div class="text-center text-gray-400 mt-20">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-gray-600">Pilih kontak untuk mulai chat</p>
                    </div>
                @endif
            </div>

            <!-- Chat Input -->
            @if (isset($conversation) && $formAction !== '#')
                <form action="{{ $formAction }}" method="POST"
                    class="flex items-center gap-3 border-t px-6 py-4 bg-white flex-shrink-0 rounded-b-2xl">
                    @csrf
                    <input type="text" name="message" placeholder="Ketik pesan..." required
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent shadow-sm text-gray-800"
                        autocomplete="off">
                    <button type="submit"
                        class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-orang-700 px-6 py-3 rounded-full font-semibold transition-all duration-200 transform hover:scale-105 border-2 border-orang-500 shadow-md">Send
                    </button>
                </form>
            @else
                <div class="text-center text-gray-400 py-8 border-t flex-shrink-0 rounded-b-2xl">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <p class="font-medium">Pilih kontak untuk mulai chat</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const closeSidebar = document.getElementById('closeSidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const adminToggle = document.getElementById('adminToggle');
            const adminList = document.getElementById('adminList');
            const adminChevron = document.getElementById('adminChevron');
            const mekanikToggle = document.getElementById('mekanikToggle');
            const mekanikList = document.getElementById('mekanikList');
            const mekanikChevron = document.getElementById('mekanikChevron');

            // State management
            let isAdminOpen = true;
            let isMekanikOpen = true;
            let isSidebarOpen = false;

            // Initialize state
            function initializeState() {
                // Show sections by default
                adminList.classList.remove('hidden');
                mekanikList.classList.remove('hidden');
                adminChevron.style.transform = 'rotate(180deg)';
                mekanikChevron.style.transform = 'rotate(180deg)';
            }

            // Mobile sidebar functions
            function openSidebar() {
                isSidebarOpen = true;
                sidebar.classList.remove('-translate-x-full', 'opacity-0', 'pointer-events-none');
                sidebar.classList.add('translate-x-0', 'opacity-100', 'pointer-events-auto');
                sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
                sidebarOverlay.classList.add('opacity-100', 'pointer-events-auto');
                toggleIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                document.body.style.overflow = 'hidden'; // Prevent body scroll
            }

            function closeSidebarFunc() {
                isSidebarOpen = false;
                sidebar.classList.add('-translate-x-full', 'opacity-0', 'pointer-events-none');
                sidebar.classList.remove('translate-x-0', 'opacity-100', 'pointer-events-auto');
                sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
                sidebarOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                toggleIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                document.body.style.overflow = ''; // Restore body scroll
            }

            // Section toggle functions
            function toggleAdminSection() {
                isAdminOpen = !isAdminOpen;
                if (isAdminOpen) {
                    adminList.classList.remove('hidden');
                    adminChevron.style.transform = 'rotate(180deg)';
                } else {
                    adminList.classList.add('hidden');
                    adminChevron.style.transform = 'rotate(0deg)';
                }
            }

            function toggleMekanikSection() {
                isMekanikOpen = !isMekanikOpen;
                if (isMekanikOpen) {
                    mekanikList.classList.remove('hidden');
                    mekanikChevron.style.transform = 'rotate(180deg)';
                } else {
                    mekanikList.classList.add('hidden');
                    mekanikChevron.style.transform = 'rotate(0deg)';
                }
            }

            // Event listeners
            sidebarToggle?.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (isSidebarOpen) {
                    closeSidebarFunc();
                } else {
                    openSidebar();
                }
            });

            closeSidebar?.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebarFunc();
            });

            sidebarOverlay?.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebarFunc();
            });

            adminToggle?.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleAdminSection();
            });

            mekanikToggle?.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMekanikSection();
            });

            // Close sidebar when clicking contact link on mobile
            const contactLinks = document.querySelectorAll('.contact-link');
            contactLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768 && isSidebarOpen) {
                        setTimeout(() => {
                            closeSidebarFunc();
                        }, 100);
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    // Desktop mode
                    sidebar.classList.remove('-translate-x-full', 'opacity-0', 'pointer-events-none');
                    sidebar.classList.add('translate-x-0', 'opacity-100', 'pointer-events-auto');
                    sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
                    sidebarOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                    document.body.style.overflow = '';
                    isSidebarOpen = false;
                } else if (isSidebarOpen) {
                    // Mobile mode - keep sidebar state
                    return;
                } else {
                    // Mobile mode - close sidebar
                    closeSidebarFunc();
                }
            });

            // Prevent scroll propagation on sidebar
            sidebar?.addEventListener('touchmove', function(e) {
                e.stopPropagation();
            });

            // Initialize
            initializeState();
        });
    </script>

    <style>
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #f97316 #f3f4f6;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f9fafb;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #f97316, #ea580c);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #ea580c, #dc2626);
        }

        /* Mobile sidebar styles */
        @media (max-width: 768px) {
            #sidebar {
                width: 280px;
                max-width: 80vw;
                height: 100vh;
                max-height: 100vh;
                top: 0;
                left: 0;
                right: auto;
                bottom: 0;
            }

            /* Prevent body scroll when sidebar is open */
            body.sidebar-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }
        }

        /* Smooth transitions */
        * {
            scroll-behavior: smooth;
        }

        /* Fix for touch scrolling on iOS */
        #sidebar {
            -webkit-overflow-scrolling: touch;
        }

        /* Ensure proper stacking */
        .z-40 {
            z-index: 40;
        }

        .z-50 {
            z-index: 50;
        }

        /* Better click targets for mobile */
        @media (max-width: 768px) {
            .contact-link {
                min-height: 60px;
                display: flex;
                align-items: center;
            }

            button {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>

</x-layoutkonsumen>