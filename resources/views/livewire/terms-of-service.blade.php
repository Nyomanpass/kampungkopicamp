<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
            <h1 class="text-4xl font-bold text-gray-900 mb-2 text-center">
                {{ __('messages.terms_title') }}
            </h1>
            <p class="text-xl text-gray-600 text-center mb-4">
                {{ __('messages.terms_subtitle') }}
            </p>
            <p class="text-sm text-gray-500 text-center">
                {{ __('messages.terms_last_updated') }}
            </p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-gray-700 leading-relaxed">
                    {{ __('messages.terms_intro') }}
                </p>
            </div>

            <!-- Section 1: Acceptance of Terms -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section1_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section1_intro') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section1_point1') }}</li>
                    <li>{{ __('messages.terms_section1_point2') }}</li>
                    <li>{{ __('messages.terms_section1_point3') }}</li>
                    <li>{{ __('messages.terms_section1_point4') }}</li>
                </ul>
                <p class="text-gray-600 text-sm mt-3 italic">
                    {{ __('messages.terms_section1_note') }}
                </p>
            </div>

            <!-- Section 2: Scope of Services -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section2_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section2_intro') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section2_point1') }}</li>
                    <li>{{ __('messages.terms_section2_point2') }}</li>
                    <li>{{ __('messages.terms_section2_point3') }}</li>
                    <li>{{ __('messages.terms_section2_point4') }}</li>
                </ul>
            </div>

            <!-- Section 3: Account Registration -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section3_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section3_intro') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section3_point1') }}</li>
                    <li>{{ __('messages.terms_section3_point2') }}</li>
                    <li>{{ __('messages.terms_section3_point3') }}</li>
                </ul>
                <p class="text-gray-600 text-sm mt-3 italic">
                    {{ __('messages.terms_section3_note') }}
                </p>
            </div>

            <!-- Section 4: Booking & Payment -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section4_title') }}
                </h2>

                <!-- Subsection 4a: Booking -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        {{ __('messages.terms_section4a_title') }}
                    </h3>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        {{ __('messages.terms_section4a_intro') }}
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                        <li>{{ __('messages.terms_section4a_point1') }}</li>
                        <li>{{ __('messages.terms_section4a_point2') }}</li>
                        <li>{{ __('messages.terms_section4a_point3') }}</li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-3 italic">
                        {{ __('messages.terms_section4a_note') }}
                    </p>
                </div>

                <!-- Subsection 4b: Payment -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        {{ __('messages.terms_section4b_title') }}
                    </h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                        <li>{{ __('messages.terms_section4b_point1') }}</li>
                        <li>{{ __('messages.terms_section4b_point2') }}</li>
                    </ul>
                </div>

                <!-- Subsection 4c: Rates & Price Changes -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        {{ __('messages.terms_section4c_title') }}
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ __('messages.terms_section4c_text') }}
                    </p>
                </div>
            </div>

            <!-- Section 5: Cancellation & Refund -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section5_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section5_intro') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section5_point1') }}</li>
                    <li>{{ __('messages.terms_section5_point2') }}</li>
                    <li>{{ __('messages.terms_section5_point3') }}</li>
                </ul>
                <p class="text-gray-600 text-sm mt-3 italic">
                    {{ __('messages.terms_section5_note') }}
                </p>
            </div>

            <!-- Section 6: Check-in, No-Show, and Area Rules -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section6_title') }}
                </h2>

                <!-- Subsection 6a: Check-in -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        {{ __('messages.terms_section6a_title') }}
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ __('messages.terms_section6a_text') }}
                    </p>
                </div>

                <!-- Subsection 6b: No-show -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        {{ __('messages.terms_section6b_title') }}
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ __('messages.terms_section6b_text') }}
                    </p>
                </div>

                <!-- Subsection 6c: Area Rules -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        {{ __('messages.terms_section6c_title') }}
                    </h3>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        {{ __('messages.terms_section6c_intro') }}
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                        <li>{{ __('messages.terms_section6c_point1') }}</li>
                        <li>{{ __('messages.terms_section6c_point2') }}</li>
                        <li>{{ __('messages.terms_section6c_point3') }}</li>
                        <li>{{ __('messages.terms_section6c_point4') }}</li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-3 italic">
                        {{ __('messages.terms_section6c_note') }}
                    </p>
                </div>
            </div>

            <!-- Section 7: Website Content & Intellectual Property -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section7_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section7_intro') }}
                </p>
                <p class="text-gray-700 leading-relaxed mb-2">
                    {{ __('messages.terms_section7_prohibited') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section7_point1') }}</li>
                    <li>{{ __('messages.terms_section7_point2') }}</li>
                    <li>{{ __('messages.terms_section7_point3') }}</li>
                    <li>{{ __('messages.terms_section7_point4') }}</li>
                </ul>
                <p class="text-gray-700 mt-2">
                    {{ __('messages.terms_section7_note') }}
                </p>
            </div>

            <!-- Section 8: Service Availability -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section8_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section8_intro') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section8_point1') }}</li>
                    <li>{{ __('messages.terms_section8_point2') }}</li>
                    <li>{{ __('messages.terms_section8_point3') }}</li>
                </ul>
                <p class="text-gray-600 text-sm mt-3 italic">
                    {{ __('messages.terms_section8_note') }}
                </p>
            </div>

            <!-- Section 9: Limitation of Liability -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section9_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section9_intro') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.terms_section9_point1') }}</li>
                    <li>{{ __('messages.terms_section9_point2') }}</li>
                    <li>{{ __('messages.terms_section9_point3') }}</li>
                </ul>
                <p class="text-gray-600 text-sm mt-3 italic">
                    {{ __('messages.terms_section9_note') }}
                </p>
            </div>

            <!-- Section 10: Problem Reporting & Suggestions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section10_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('messages.terms_section10_text') }}
                </p>
            </div>

            <!-- Section 11: Changes to Terms of Service -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section11_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ __('messages.terms_section11_text1') }}
                </p>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('messages.terms_section11_text2') }}
                </p>
            </div>

            <!-- Section 12: Official Contact -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('messages.terms_section12_title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.terms_section12_intro') }}
                </p>
                <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                    <p class="text-gray-700">
                        <span class="font-semibold">Email: {{ __($texts['email']) }}</span>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Phone: {{ __($texts['phone']) }}</span>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Address: {{ __($texts['address']) }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Back to Home Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ app()->getLocale() == 'id' ? 'Kembali ke Beranda' : 'Back to Home' }}
            </a>
        </div>
    </div>
</div>
