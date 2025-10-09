<div>
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
  data-aos="fade-zoom-in"
  data-aos-duration="1200"
  data-aos-easing="ease-in-out"
  data-aos-once="true">

  <!-- Background Image -->
  <img src="/images/gambarheader.jpg" 
       alt="Article Background" 
       class="absolute inset-0 w-full h-full object-cover"
       data-aos="zoom-out"
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <!-- Sub Heading -->
    <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
      Artikel & Cerita
    </p>

    <!-- Title -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      Jelajahi Inspirasi <span class="text-primary">Pupuan</span>
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      Temukan cerita seputar kopi, budaya, dan wisata lokal yang memperkaya pengalaman Anda bersama Kampung Kopi Camp.
    </p>
  </div>
</section>


<section class="max-w-7xl mx-auto px-6 lg:px-20 py-20">
  <!-- Header -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12" data-aos="fade-up">
    <div>
      <p class="text-sm font-semibold text-secondary tracking-widest mb-2">
        LATEST NEWS & EVENTS
      </p>
      <h2 class="text-3xl md:text-4xl text-secondary font-extrabold text-gray-900">
        Cerita Terbaru <span class="text-primary">dari Pupuan</span>
      </h2>
    </div>
    <div>
      <p class="text-gray-600 pt-5 leading-relaxed">
        Stay updated with the latest happenings around Pupuan. Explore inspiring stories, 
        cultural insights, and don’t miss out on our upcoming events.
      </p>
    </div>
  </div>

  <!-- Blog Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
    @foreach($blogs as $index => $blog)
    <article class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden"
             data-aos="fade-up"
             data-aos-delay="{{ $index * 150 }}">
        <img src="{{ $blog->main_image ? asset('storage/' . $blog->main_image) : 'https://picsum.photos/400/400?random=1' }}" 
             alt="{{ $blog->title }}" 
             class="w-full h-56 object-cover">

        <div class="py-6 px-4">
            <p class="text-sm font-semibold text-secondary mb-2">ARTICLES</p>
            <h3 class="text-lg font-bold text-gray-900 mb-3">
                {{ $blog->title }}
            </h3>
            <p class="text-gray-600 text-sm mb-4">
                {{ Str::limit($blog->description, 100) }}
            </p>
           <a href="{{ route('article.detail', ['slug' => Str::slug($blog->title)]) }}" 
              class="inline-flex items-center gap-2 text-secondary font-semibold hover:underline">
              Read More <span>→</span>
            </a>
        </div>
    </article>
    @endforeach
  </div>
</section>

</div>
