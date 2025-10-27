<div>
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
  data-aos="fade-zoom-in"
  data-aos-duration="1200"
  data-aos-easing="ease-in-out"
  data-aos-once="true">

  <!-- Background Image -->
  <img src="/images/article.webp" 
       alt="Article Background" 
       class="absolute inset-0 w-full h-full object-cover"
       data-aos="zoom-out"
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/50"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <!-- Sub Heading -->
    <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
      {{ $texts['articles_stories'] }}
    </p>

    <!-- Title -->
    <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-6" data-aos="fade-up" data-aos-delay="600">
      {!! str_replace(':place', '<span class="text-primary">Pupuan</span>', $texts['explore_inspiration']) !!}
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-sm md:text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {{ $texts['explore_description'] }}
    </p>
  </div>
</section>


<section class="max-w-7xl mx-auto px-6 lg:px-20 py-20">
  <!-- Header -->
  <div class="grid grid-cols-1 md:grid-cols-2 md:gap-8 mb-12" data-aos="fade-up">
    <div>
      <p class="text-sm font-semibold text-secondary tracking-widest mb-2">
        {{ $texts['latest_news_events'] }}
      </p>
      <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6">
        {!! str_replace(':place', '<span class="text-primary">Pupuan</span>', $texts['latest_stories_heading']) !!}
      </h2>
    </div>
    <div>
      <p class="text-sm md:text-lg max-w-3xl text-gray-600 mb-6">
        {{ $texts['latest_stories_description'] }}
      </p>
    </div>
</div>


  <!-- Blog Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
 
 @foreach ($blogs as $index => $blog)
        <div class="bg-white rounded-xl shadow-lg transition duration-300 hover:shadow-2xl overflow-hidden"
             data-aos="fade-up"
             data-aos-delay="{{ $index * 150 }}"
             data-aos-duration="1000"
             data-aos-easing="ease-in-out">

            <img src="{{ $blog->main_image ? asset('storage/' . $blog->main_image) : 'https://picsum.photos/400/250?random=' . $index }}" 
                 alt="{{ $blog->title[$lang] ?? '' }}" 
                 class="w-full h-56 object-cover aspect-video">

            <div class="p-6">
                <div class="flex flex-wrap items-center text-xs font-medium text-gray-500 mb-3 space-x-3">
                    
                   
                    <span class="bg-secondary/10 text-secondary px-2 py-0.5 rounded-full uppercase tracking-wider">
                        {{ $texts['article_type'] }}
                    </span>
                    
                    
                    <span class="text-gray-400">•</span>
                    <span>{{ $blog->created_at->format('d M Y') }}</span>
                </div>

                <h3 class="text-md font-semibold text-gray-700 leading-snug"
                    data-aos="fade-right"
                    data-aos-delay="{{ 100 + $index * 150 }}"
                    data-aos-duration="900">
                  {{ $blog->title[$lang] ?? '' }}
                </h3>

                <p class="text-base md:text-md text-sm text-gray-600 mt-3 mb-4"
                   data-aos="fade-up"
                   data-aos-delay="{{ 200 + $index * 150 }}"
                   data-aos-duration="1000">
                  {{ Str::limit($blog->description[$lang] ?? '', 120) }}
                </p>

                <a href="{{ route('article.detail', ['slug' => Str::slug($blog->title[$lang] ?? '')]) }}"
                   class="inline-flex items-center text-sm font-semibold text-secondary hover:text-amber-900 transition"
                   data-aos="zoom-in"
                   data-aos-delay="{{ 300 + $index * 150 }}"
                   data-aos-duration="800">
                  {{ $lang === 'id' ? 'Baca Selengkapnya →' : 'Read More →' }}
                </a>
            </div>
        </div>
    @endforeach

  </div>
</section>

</div>
