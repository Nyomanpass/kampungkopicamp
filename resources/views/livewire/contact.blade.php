<div>
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
  data-aos="fade-zoom-in"
  data-aos-duration="1200"
  data-aos-easing="ease-in-out"
  data-aos-once="true">

  <!-- Background Image -->
  <img src="/images/contactpupuan.webp" 
       alt="Contact Background" 
       class="absolute inset-0 w-full h-full object-cover"
       data-aos="zoom-out"
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/50"></div>

  <!-- Content -->
<div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <!-- Sub Heading -->
    <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
      {{ $texts['contact_subheading'] }}
    </p>

    <!-- Title -->
    <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-6" data-aos="fade-up" data-aos-delay="600">
      {{ $texts['contact_title_1'] }} <span class="text-primary">{{ $texts['contact_title_2'] }}</span>
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-sm md:text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {{ $texts['contact_desc'] }}
    </p>
</div>

</section>


<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] flex flex-col justify-between"
                 data-aos="fade-up" data-aos-delay="100">
                <div>
                    <div class="flex justify-center mb-5">
                        <span class="w-14 h-14 flex items-center justify-center rounded-full bg-primary text-white text-2xl shadow-md">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-2 text-gray-800">{{ $texts['contact_phone_title'] }}</h3>
                    <p class="text-gray-600 text-center font-medium mb-1 text-base sm:text-sm md:text-base">+62 813-3737-1234</p>
                    <p class="text-gray-600 text-center font-medium mb-4 text-base sm:text-sm md:text-base">+62 878-6543-2109</p>
                </div>
                <div class="text-center mt-4">
                    <a href="https://wa.me/6281337371234" target="_blank" class="w-full inline-flex items-center justify-center px-5 py-2.5 border border-secondary text-secondary font-semibold rounded-xl hover:bg-secondary hover:text-white transition">
                        <i class="fa-brands fa-whatsapp mr-2"></i> {{ $texts['contact_phone_btn'] }}
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] flex flex-col justify-between"
                 data-aos="fade-up" data-aos-delay="200">
                <div>
                    <div class="flex justify-center mb-5">
                        <span class="w-14 h-14 flex items-center justify-center rounded-full bg-primary text-white text-2xl shadow-md">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-2 text-gray-800">{{ $texts['contact_email_title'] }}</h3>
                    <p class="text-gray-600 text-center font-medium mb-1 truncate text-base sm:text-sm md:text-base">info@kampungkopi.camp</p>
                    <p class="text-gray-600 text-center font-medium mb-4 truncate text-base sm:text-sm md:text-base">booking@kampungkopi.camp</p>
                </div>
                <div class="text-center mt-4">
                    <a href="mailto:info@kampungkopi.camp" class="w-full inline-flex items-center justify-center px-5 py-2.5 border border-secondary text-secondary font-semibold rounded-xl hover:bg-secondary hover:text-white transition">
                        <i class="fa-solid fa-paper-plane mr-2"></i> {{ $texts['contact_email_btn'] }}
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] flex flex-col justify-between"
                 data-aos="fade-up" data-aos-delay="300">
                <div>
                    <div class="flex justify-center mb-5">
                        <span class="w-14 h-14 flex items-center justify-center rounded-full bg-primary text-white text-2xl shadow-md">
                            <i class="fa-solid fa-map-marker-alt"></i>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-2 text-gray-800">{{ $texts['contact_address_title'] }}</h3>
                    <p class="text-gray-600 text-center mb-4 text-base sm:text-sm md:text-base">
                        Jl. Raya Pupuan - Antosari<br>
                        Desa Pupuan, Tabanan<br>
                        Bali 82163, Indonesia
                    </p>
                </div>
                <div class="text-center mt-4">
                    <a href="https://maps.google.com" target="_blank" class="w-full inline-flex items-center justify-center px-5 py-2.5 border border-secondary text-secondary font-semibold rounded-xl hover:bg-secondary hover:text-white transition">
                        <i class="fa-solid fa-location-dot mr-2"></i> {{ $texts['contact_address_btn'] }}
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] flex flex-col justify-between"
                 data-aos="fade-up" data-aos-delay="400">
                <div>
                    <div class="flex justify-center mb-5">
                        <span class="w-14 h-14 flex items-center justify-center rounded-full bg-primary text-white text-2xl shadow-md">
                            <i class="fa-solid fa-clock"></i>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-2 text-gray-800">{{ $texts['contact_hours_title'] }}</h3>
                    <div class="space-y-1.5 text-center mb-4">
                        <p class="text-gray-600 font-medium text-base sm:text-sm md:text-base">Senin - Minggu: 06:00 - 22:00</p>
                        
                        <p class="text-sm text-gray-700 sm:text-xs md:text-sm">Check-in: 14:00</p>
                        <p class="text-sm text-gray-700 sm:text-xs md:text-sm">Check-out: 12:00</p>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="w-full inline-flex items-center justify-center px-5 py-2.5 border border-secondary text-secondary font-semibold rounded-xl hover:bg-secondary hover:text-white transition">
                        <i class="fa-solid fa-info-circle mr-2"></i> {{ $texts['contact_hours_btn'] }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="max-w-7xl mx-auto bg-light py-12 px-6 lg:px-14 lg:py-16">
    <!-- Bagian Utama Kontak -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Kirim Pesan -->
        <div class="lg:col-span-2 bg-white rounded-xl p-6 md:p-10 shadow-lg"
             data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ $texts['contact_form_title'] }}</h3>
            <form class="space-y-6">
                <!-- Baris 1: Nama Lengkap & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">{{ $texts['contact_fullname'] }} *</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 transition" />
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ $texts['contact_email'] }} *</label>
                        <input type="email" id="email" name="email" placeholder="nama@email.com" required
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 transition" />
                    </div>
                </div>

                <!-- Baris 2: No. Telepon & Subjek -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">{{ $texts['contact_phone'] }} *</label>
                        <input type="tel" id="telepon" name="telepon" required
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 transition" />
                    </div>
                    <div>
                        <label for="subjek" class="block text-sm font-semibold text-gray-700 mb-2">{{ $texts['contact_subject'] }} *</label>
                        <input type="text" id="subjek" name="subjek" placeholder="Booking / Informasi / Lainnya" required
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 transition" />
                    </div>
                </div>

                <!-- Baris 3: Pesan -->
                <div>
                    <label for="pesan" class="block text-sm font-semibold text-gray-700 mb-2">{{ $texts['contact_message'] }} *</label>
                    <textarea id="pesan" name="pesan" rows="4" placeholder="Tulis pesan Anda di sini..." required
                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 transition"></textarea>
                </div>

                <!-- Tombol Kirim -->
                <button type="submit" 
                        class="w-full bg-secondary md:w-auto inline-flex items-center justify-center px-8 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition">
                    <i class="fa-solid fa-paper-plane mr-3"></i> {{ $texts['contact_send_btn'] }}
                </button>
            </form>
        </div>

        <!-- Kolom Kanan: Lokasi & Media Sosial -->
        <div class="space-y-8" data-aos="fade-left" data-aos-delay="200">
            
            <!-- Lokasi Kami -->
            <div class="bg-white rounded-xl p-6 shadow-lg" data-aos="zoom-in" data-aos-delay="100">
                <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $texts['contact_location_title'] }}</h3>
                
                <div class="h-48 bg-gray-50 rounded-lg mb-4 overflow-hidden border border-gray-200">
                    <!-- Google Maps Embed -->
                    <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7895.1750634993!2d115.03386611055907!3d-8.343715401760706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd229a2ecb99547%3A0x8a1a833f13b4a85b!2sKampung%20Kopi%20Camp!5e0!3m2!1sid!2sid!4v1759163429473!5m2!1sid!2sid" 
                    class="w-full h-full rounded-lg"
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <a href="https://www.google.com/maps?ll=-8.342049,115.036913&z=14&t=m&hl=id&gl=ID&mapclient=embed&cid=9951410633565317211" target="_blank"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition">
                    {{ $texts['contact_open_maps'] }}
                </a>
            </div>

            <!-- Ikuti Kami -->
            <div class="bg-white rounded-xl p-6 shadow-lg" data-aos="zoom-in" data-aos-delay="200">
                <h3 class="text-xl font-bold text-gray-800 mb-4"> {{ $texts['contact_follow_title'] }}</h3>
                
                <ul class="space-y-4">
                    <li class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white text-base">
                                <i class="fa-brands fa-instagram"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Instagram</p>
                                <p class="text-xs text-gray-500">@kampungkopi.camp</p>
                            </div>
                        </div>
                        <a href="#" class="text-sm text-secondary font-medium hover:underline">Follow</a>
                    </li>
                    
                    <li class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white text-base">
                                <i class="fa-brands fa-facebook-f"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Facebook</p>
                                <p class="text-xs text-gray-500">Kampung Kopi Camp</p>
                            </div>
                        </div>
                        <a href="#" class="text-sm text-secondary font-medium hover:underline">Follow</a>
                    </li>
                    
                    <li class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white text-base">
                                <i class="fa-brands fa-tiktok"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">TikTok</p>
                                <p class="text-xs text-gray-500">@kampungkopi_official</p>
                            </div>
                        </div>
                        <a href="#" class="text-sm text-secondary font-medium hover:underline">Follow</a>
                    </li>

                    <li class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white text-base">
                                <i class="fa-brands fa-whatsapp"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">WhatsApp</p>
                                <p class="text-xs text-gray-500">+62 813-3737-1234</p>
                            </div>
                        </div>
                        <a href="https://wa.me/6281337371234" target="_blank" class="text-sm text-secondary font-medium hover:underline">Chat</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>



</div>
