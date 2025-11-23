<div class="min-h-screen">
    {{-- Hero Section --}}
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


    {{-- Articles Section --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-14 py-16">
        <!-- Header -->
         <div class="grid grid-cols-1 md:grid-cols-2 md:gap-8 mb-12" data-aos="fade-up">
    <div>
      <p class="text-sm font-semibold text-amber-800 tracking-widest mb-2">
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
        @if (count($blogs) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($blogs as $index => $blog)
                    <article
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <!-- Image Container with Overlay -->
                        <div class="relative overflow-hidden h-56">
                            <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://picsum.photos/400/400?random=' . $blog->id }}"
                                alt="{{ $blog->title[$lang] ?? '' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-secondary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-secondary/95 text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-wide shadow-lg">
                                    <i class="fas fa-bookmark mr-1"></i>
                                    {{ $texts['article_type'] ?? 'Article' }}
                                </span>
                            </div>

                            <!-- Read More Icon (appears on hover) -->
                           
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta Information -->
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <i class="far fa-calendar text-accent"></i>
                                    {{ $blog->published_at->format('d M Y') ?? '3 min' }}
                                </span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center gap-1">
                                    <i class="far fa-user text-accent"></i>
                                    Admin
                                </span>

                            </div>

                            <!-- Title -->
                            <h3
                                class="text-xl font-bold text-slate-800 mb-3 line-clamp-2 transition-colors duration-300">
                                {{ $blog->title ?? '' }}
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit($blog->excerpt ?? '', 120) }}
                            </p>

                            <!-- Read More Link -->
                            <a href="{{ route('article.detail', $blog->slug) }}"
                                class="inline-flex items-center gap-2 text-primary font-semibold hover:text-dark-primary transition-colors group/link">
                                {{ $lang === 'id' ? 'Baca Selengkapnya' : 'Read More' }}
                                <i
                                    class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20" data-aos="fade-up">
                <div class="inline-block p-8 bg-white rounded-2xl shadow-lg mb-6">
                    <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark-primary mb-2">
                    {{ $lang === 'id' ? 'Belum Ada Artikel' : 'No Articles Yet' }}
                </h3>
                <p class="text-gray-600">
                    {{ $lang === 'id' ? 'Artikel menarik akan segera hadir!' : 'Interesting articles coming soon!' }}
                </p>
            </div>
        @endif
    </section>

</div>


