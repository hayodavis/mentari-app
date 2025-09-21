<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center px-4"
         style="background: linear-gradient(135deg, #f0f4ff, #e6f7ff, #ffffff);">
        
        <!-- Logo -->
        <div class="mb-0 text-center animate-fade-in-down">
            <img src="{{ asset('images/logo-mentari.png') }}" alt="Logo Mentari" class="h-60 sm:h-72 md:h-80 mx-auto">
        </div>

        <!-- Form Card -->
        <div class="w-full max-w-md bg-white shadow-xl rounded-xl p-6 -mt-4 animate-fade-in-up">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mt-4">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-200">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Animations -->
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</x-guest-layout>
