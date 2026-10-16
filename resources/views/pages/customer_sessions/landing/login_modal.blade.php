<div id="buyLoginModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 px-4">
    <div class="relative w-full max-w-md rounded-[2rem] bg-white p-7 text-center shadow-2xl">
        <button type="button"
                onclick="closeBuyLoginModal()"
                class="absolute right-5 top-4 text-2xl font-black text-gray-400 hover:text-black">
            ×
        </button>

        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-baddie-pink text-white">
            <i data-feather="shopping-cart" class="h-7 w-7"></i>
        </div>

        <p class="font-black uppercase tracking-[.25em] text-baddie-pink text-xs">
            Sign In Required
        </p>

        <h3 class="mt-3 font-archivo text-3xl text-black">
            For buy you need to sign in
        </h3>

        <p class="mt-3 text-sm font-semibold leading-6 text-gray-600">
            Please login first to buy packages, add them to your cart, and manage your session credits.
        </p>

        <div class="mt-7 flex gap-3">
            <button type="button"
                    onclick="closeBuyLoginModal()"
                    class="outline-btn flex-1 px-4">
                Cancel
            </button>

            <a href="{{ route('em.customer.login', ['redirect' => route('em.customer.landing.index')]) }}"
            class="pink-btn flex-1 px-4">
                Go to Login
            </a>
        </div>

        <div class="mt-4">
            <a href="{{ route('em.customer.register', ['redirect' => route('em.customer.landing.index')]) }}" class="text-sm font-black text-black hover:text-baddie-pink">
                New customer? Create account
            </a>
        </div>
    </div>
</div>
<script>
    function openBuyLoginModal() {
        const modal = document.getElementById('buyLoginModal');

        if (!modal) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    function closeBuyLoginModal() {
        const modal = document.getElementById('buyLoginModal');

        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeBuyLoginModal();
        }
    });

    document.addEventListener('click', function (event) {
        const modal = document.getElementById('buyLoginModal');

        if (!modal || modal.classList.contains('hidden')) return;

        if (event.target === modal) {
            closeBuyLoginModal();
        }
    });
</script>
