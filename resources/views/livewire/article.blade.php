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
      {{ $texts['articles_stories'] }}
    </p>

    <!-- Title -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      {!! str_replace(':place', '<span class="text-primary">Pupuan</span>', $texts['explore_inspiration']) !!}
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {{ $texts['explore_description'] }}
    </p>
  </div>
</section>


<section class="max-w-7xl mx-auto px-6 lg:px-20 py-20">
  <!-- Header -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12" data-aos="fade-up">
    <div>
      <p class="text-sm font-semibold text-secondary tracking-widest mb-2">
        {{ $texts['latest_news_events'] }}
      </p>
      <h2 class="text-3xl md:text-4xl text-secondary font-extrabold text-gray-900">
        {!! str_replace(':place', '<span class="text-primary">Pupuan</span>', $texts['latest_stories_heading']) !!}
      </h2>
    </div>
    <div>
      <p class="text-gray-600 pt-5 leading-relaxed">
        {{ $texts['latest_stories_description'] }}
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
             alt="{{ $blog->title[$lang] ?? '' }}" 
             class="w-full h-56 object-cover">

        <div class="py-6 px-4">
             <div class="flex items-center text-xs text-gray-500 mb-2 space-x-2">
              <span class="bg-secondary/10 text-secondary px-2 py-0.5 rounded">
                {{ $texts['article_type'] }}
              </span>
              <span>{{ $blog->created_at->format('d M Y') }}</span>
              <span>•</span>
              <span>By {{ $blog->author[$lang] ?? 'Admin' }}</span>
              <span>•</span>
              <span>{{ $blog->read_time ?? '3 min' }} read</span>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-3">
                {{ $blog->title[$lang] ?? '' }}
            </h3>
            <p class="text-gray-600 text-sm mb-4">
                {{ Str::limit($blog->description[$lang] ?? '', 100) }}
            </p>

            <a href="{{ route('article.detail', [
                    'slug' => Str::slug($blog->title[$lang] ?? '')
                ]) }}" 
                class="text-secondary font-semibold hover:underline">
               {{ $lang === 'id' ? 'Baca Selengkapnya →' : 'Read More →' }}
            </a>
        </div>
    </article>
@endforeach

  </div>
</section>

</div>
