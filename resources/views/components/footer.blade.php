<!-- Artistic Wave Divider -->
<div class="w-full overflow-hidden leading-none relative" style="height: 60px;">
    <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute top-0 left-0 w-full h-full">
        <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="url(#footer-gradient)"/>
        <defs>
            <linearGradient id="footer-gradient" x1="0" y1="0" x2="1440" y2="0" gradientUnits="userSpaceOnUse">
                <stop stop-color="#fb923c" />
                <stop offset="1" stop-color="#fdba74" />
            </linearGradient>
        </defs>
    </svg>
</div>
<footer class="pt-10 pb-0" style="background: linear-gradient(90deg, #fb923c 0%, #fdba74 100%);">
    <div class="container mx-auto px-4 flex flex-wrap justify-between items-start gap-8">
        <!-- Logo & Brand -->
        <div class="w-full md:w-1/4 mb-8 md:mb-0 flex flex-col items-center md:items-start">
            <div class="bg-white rounded-full shadow-lg p-3 mb-3 transition-transform duration-300 hover:scale-105 border-4 border-orange-400">
                <img src="{{ asset('LogoMechafix.svg') }}" alt="Mechafix Logo" class="h-16 w-16 object-contain">
            </div>
            <h2 class="text-2xl font-extrabold text-white tracking-wide mb-2 drop-shadow">Mechafix</h2>
            <p class="text-sm text-white/80 font-light mb-2 text-center md:text-left">Your trusted partner for modern motorcycle service & parts.</p>
        </div>

        <!-- Quick Links -->
        <div class="w-full md:w-1/5 mb-8 md:mb-0">
            <h3 class="font-bold text-white mb-3 tracking-wide uppercase">Quick Links</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('konsumen.history') }}" class="text-white/90 hover:text-black hover:underline transition">About Us</a></li>
                <li><a href="{{ route('konsumen.services') }}" class="text-white/90 hover:text-black hover:underline transition">Services</a></li>
                <li><a href="{{ route('konsumen.chat_contact') }}" class="text-white/90 hover:text-black hover:underline transition">Contact Us</a></li>
                <li><a href="{{ route('dashboard.konsumen') }}" class="text-white/90 hover:text-black hover:underline transition">Blog</a></li>
                <li><a href="{{ route('dashboard.konsumen') }}#faq" class="text-white/90 hover:text-black hover:underline transition">FAQs</a></li>
            </ul>
        </div>

        <!-- Support -->
        <div class="w-full md:w-1/5 mb-8 md:mb-0">
            <h3 class="font-bold text-white mb-3 tracking-wide uppercase">Support</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('dashboard.konsumen') }}#help" class="text-white/90 hover:text-black hover:underline transition">Help Center</a></li>
                <li><a href="{{ route('konsumen.history') }}" class="text-white/90 hover:text-black hover:underline transition">Repair Status</a></li>
                <li><a href="{{ route('dashboard.konsumen') }}#membership" class="text-white/90 hover:text-black hover:underline transition">Membership</a></li>
                <li><a href="{{ route('konsumen.services') }}" class="text-white/90 hover:text-black hover:underline transition">Shop Parts</a></li>
                <li><a href="{{ route('dashboard.konsumen') }}#feedback" class="text-white/90 hover:text-black hover:underline transition">Feedback</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div class="w-full md:w-1/4 mb-8 md:mb-0 flex flex-col items-center md:items-start">
            <h3 class="font-bold text-white mb-3 tracking-wide uppercase">Newsletter</h3>
            <form class="flex w-full max-w-xs mb-3">
                <input type="email" placeholder="Your email..." class="flex-1 px-3 py-2 rounded-l-lg border-2 border-white focus:ring-2 focus:ring-orange-400 text-gray-800" required>
                <button type="submit" class="bg-black text-white px-4 py-2 rounded-r-lg font-bold hover:bg-white hover:text-orange-500 transition">Subscribe</button>
            </form>
            <p class="text-xs text-white/80">Get the latest offers, news, and events from Mechafix.</p>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="mt-10 border-t border-white/30 py-5 px-4" style="background: rgba(0,0,0,0.07);">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/80 text-xs">© 2025 Mechafix. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="" class="text-white/90 hover:text-black hover:underline text-xs transition">Privacy Policy</a>
                <a href="" class="text-white/90 hover:text-black hover:underline text-xs transition">Terms of Use</a>
                <a href="{{ route('dashboard.konsumen') }}#cookie" class="text-white/90 hover:text-black hover:underline text-xs transition">Cookie Settings</a>
            </div>
            <div class="flex space-x-3">
                <a href="#" class="bg-white rounded-full p-2 shadow hover:scale-110 transition"><img src="{{ asset('Facebook.svg') }}" alt="Facebook" class="h-6 w-6"></a>
                <a href="#" class="bg-white rounded-full p-2 shadow hover:scale-110 transition"><img src="{{ asset('Instagram.svg') }}" alt="Instagram" class="h-6 w-6"></a>
                <a href="#" class="bg-white rounded-full p-2 shadow hover:scale-110 transition"><img src="{{ asset('X.svg') }}" alt="X" class="h-6 w-6"></a>
                <a href="#" class="bg-white rounded-full p-2 shadow hover:scale-110 transition"><img src="{{ asset('LinkedIn.svg') }}" alt="LinkedIn" class="h-6 w-6"></a>
                <a href="#" class="bg-white rounded-full p-2 shadow hover:scale-110 transition"><img src="{{ asset('Youtube.svg') }}" alt="Youtube" class="h-6 w-6"></a>
            </div>
        </div>
    </div>
</footer>
