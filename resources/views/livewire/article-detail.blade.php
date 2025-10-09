<div>
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
  data-aos="fade-zoom-in"
  data-aos-duration="1200"
  data-aos-easing="ease-in-out"
  data-aos-once="true">

  <!-- Background Image -->
  <img src="/images/gambarheader.jpg" 
       alt="Article Detail Background" 
       class="absolute inset-0 w-full h-full object-cover"
       data-aos="zoom-out"
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <!-- Sub Heading -->
    <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
      Detail Artikel
    </p>

    <!-- Title -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      Cerita dan Inspirasi <span class="text-primary">Kampung Kopi Camp</span>
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      Baca lebih dalam tentang perjalanan, kisah, dan pengalaman menarik yang menginspirasi dari Kampung Kopi Camp di Pupuan, Bali.
    </p>
  </div>
</section>



<div class="container max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">
        
        {{-- Konten Utama --}}
        <div class="md:col-span-2">
            <h1 class="text-2xl md:text-3xl font-bold mb-3">{{ $blog->title }}</h1>
            <div class="flex items-center text-sm text-gray-500 mb-5">
                <span>{{ $blog->publishedDate }}</span>
            </div>

            @if($blog->main_image)
                <img src="{{ asset('storage/' . $blog->main_image) }}" alt="{{ $blog->title }}" class="rounded-xl mb-6">
            @endif

            <div class="prose max-w-none">
                {{-- Deskripsi Utama --}}
                <p>{{ $blog->description }}</p>

                {{-- Konten tambahan --}}
                @foreach($blog->contents as $content)
                    @if($content->image)
                        <img 
                            src="{{ asset('storage/' . $content->image) }}" 
                            alt="Konten Gambar" 
                            class="rounded-xl my-4 w-full max-h-92 object-cover"
                        />
                    @endif
                    <p>{{ $content->content }}</p>
                @endforeach
            </div>

            {{-- Tombol Share Sosial Media --}}
            <div class="flex gap-3 mt-6">
                <a href="#" class="text-blue-600">Facebook</a>
                <a href="#" class="text-sky-500">Twitter</a>
                <a href="#" class="text-green-500">WhatsApp</a>
                <a href="#" class="text-gray-600">Email</a>
            </div>

            
        </div>

        {{-- Sidebar Latest Blogs --}}
        <aside>
            <h2 class="text-xl font-bold mb-4">Latest Blogs</h2>
            <div class="space-y-5">
                @foreach($relatedBlogs as $related)
                    <div class="flex gap-4">
                        <img src="{{ $related->main_image ? asset('storage/' . $related->main_image) : 'https://picsum.photos/100/80?random=' . $related->id }}" 
                             class="w-24 h-20 rounded object-cover" 
                             alt="{{ $related->title }}">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $related->title }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($related->description, 50) }}</p>
                            <a href="{{ route('article.detail', ['slug' => Str::slug($related->title)]) }}" class="text-primary text-sm hover:underline">Read More →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>
    </div>

</div>
