<div class="min-h-screen bg-neutral">
    {{-- Hero Section --}}
    <section class="relative w-full h-[60vh] flex items-center justify-center text-center text-white overflow-hidden"
        data-aos="fade-zoom-in" data-aos-duration="1200" data-aos-easing="ease-in-out" data-aos-once="true">

        <!-- Background Image with Parallax Effect -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="/images/gambarheader.jpg" alt="Article Background"
                class="absolute inset-0 w-full h-full object-cover scale-110" data-aos="zoom-out"
                data-aos-duration="1500">
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-dark-primary/70 via-primary/50 to-dark-primary/80"></div>

        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 border-2 border-white rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-48 h-48 border-2 border-white rounded-full"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 px-6 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="300">
            <!-- Sub Heading with Icon -->
            <div class="flex items-center justify-center gap-2 mb-4" data-aos="fade-down" data-aos-delay="400">
                <div class="w-12 h-[2px] bg-secondary"></div>
                <p class="uppercase text-secondary font-semibold tracking-[0.3em] text-sm">
                    {{ $texts['articles_stories'] ?? 'Articles & Stories' }}
                </p>
                <div class="w-12 h-[2px] bg-secondary"></div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight" data-aos="fade-up" data-aos-delay="600">
                {{ $texts['explore_inspiration'] ?? 'Explore the Inspiration of' }}
                <span class="text-secondary">Pupuan</span>
            </h1>

            <!-- Decorative Line -->
            <div class="flex justify-center gap-2 mb-6" data-aos="zoom-in" data-aos-delay="800">
                <div class="w-2 h-2 bg-secondary rounded-full"></div>
                <div class="w-16 h-[2px] bg-secondary self-center"></div>
                <div class="w-2 h-2 bg-secondary rounded-full"></div>
            </div>

            <!-- Description -->
            <p class="text-lg md:text-xl max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up"
                data-aos-delay="1000">
                {{ $texts['explore_description'] ?? 'Discover stories about coffee, culture, and local tourism that enrich your experience with Kampung Kopi Camp' }}
            </p>
        </div>
    </section>


    {{-- Articles Section --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-14 py-16">
        <!-- Header -->
        <div class="mb-12" data-aos="fade-up">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-1 h-8 bg-primary rounded-full"></div>
                <p class="text-sm font-bold text-accent tracking-widest uppercase">
                    {{ $texts['latest_news_events'] ?? 'Latest News & Events' }}
                </p>
            </div>
            <h2 class="text-3xl md:text-5xl font-extrabold text-dark-primary mb-4">
                {{ $texts['latest_stories_heading'] ?? 'Latest Stories from' }}
                <span class="text-primary">Pupuan</span>
            </h2>
            <div class="w-24 h-1 bg-accent rounded-full"></div>
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
                            <img src="{{ $blog->main_image ? asset('storage/' . $blog->main_image) : 'https://picsum.photos/400/400?random=' . $blog->id }}"
                                alt="{{ $blog->title[$lang] ?? '' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-dark-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-secondary/95 text-dark-primary px-4 py-1.5 rounded-full text-xs font-bold tracking-wide shadow-lg">
                                    <i class="fas fa-bookmark mr-1"></i>
                                    {{ $texts['article_type'] ?? 'Article' }}
                                </span>
                            </div>

                            <!-- Read More Icon (appears on hover) -->
                            <div
                                class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                                <div
                                    class="bg-primary text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
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
                                class="text-xl font-bold text-dark-primary mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-300">
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
