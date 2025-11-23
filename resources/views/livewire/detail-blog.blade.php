<div class="min-h-screen">
    {{-- Hero Section --}}
    <section class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
        data-aos="fade-zoom-in" data-aos-duration="1200" data-aos-easing="ease-in-out" data-aos-once="true">

        <!-- Background Image with Parallax -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : '/images/gambarheader.jpg' }}"
                alt="Article Background" class="absolute inset-0 w-full h-full object-cover scale-110" data-aos="zoom-out"
                data-aos-duration="1500">
        </div>

        <!-- Gradient Overlay -->
         <div class="absolute inset-0 bg-black/50"></div>

        <!-- Content -->
        <div class="relative z-10 px-6 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="300">
            <!-- Breadcrumb -->
            <div class="flex items-center justify-center gap-2 mb-4 text-sm text-gray-200" data-aos="fade-down"
                data-aos-delay="400">
                <a href="{{ route('home') }}" class="hover:text-secondary transition">
                    <i class="fas fa-home"></i> {{ $lang === 'id' ? 'Beranda' : 'Home' }}
                </a>
                <span>/</span>
                <a href="{{ route('article') }}" class="hover:text-secondary transition">
                    {{ $lang === 'id' ? 'Artikel' : 'Articles' }}
                </a>
                <span>/</span>
                <span class="text-primary font-semibold">{{ $texts['article_detail'] ?? 'Detail' }}</span>
            </div>

            <!-- Category Badge -->
            @if ($blog->category)
                <div
                    class="inline-block bg-primary/95 text-white px-4 py-2 rounded-full text-sm font-bold mb-4">
                    <i class="fas fa-bookmark mr-2"></i>
                    {{ ucfirst($blog->category) }}
                </div>
            @endif

            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight" data-aos="fade-up" data-aos-delay="600">
                {{ $blog->title }}
            </h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap items-center justify-center gap-4 text-sm text-gray-200" data-aos="fade-up"
                data-aos-delay="800">
                <span class="flex items-center gap-2">
                    <i class="far fa-calendar text-primary"></i>
                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-2">
                    <i class="far fa-user text-primary"></i>
                    {{ $blog->author ? $blog->author->name : 'Admin' }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-2">
                    <i class="far fa-eye text-primary"></i>
                    {{ $blog->views ?? 0 }} {{ $lang === 'id' ? 'views' : 'views' }}
                </span>
            </div>
        </div>
    </section>


    {{-- Main Content --}}
    <div class="container max-w-7xl mx-auto px-6 py-12 grid px-6 lg:px-14 py-16 lg:grid-cols-3 gap-10">

        {{-- Article Content --}}
        <article class="lg:col-span-2">
            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8" data-aos="fade-up">
                @if ($blog->featured_image)
                    <div class="relative h-96 overflow-hidden">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-primary/30 to-transparent"></div>
                    </div>
                @endif

                <div class="p-5 lg:p-8">
                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-6 leading-tight">
                        {{ $blog->title }}
                    </h1>

                    <!-- Excerpt -->
                    @if ($blog->excerpt)
                        <div class="prose prose-lg max-w-none mb-8">
                            <p class="text-gray-700 leading-relaxed text-lg font-medium">
                                {{ $blog->excerpt }}
                            </p>
                        </div>
                        <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-accent to-transparent my-8">
                        </div>
                    @endif

                    <!-- Main Content -->
                    <div class="prose prose-lg max-w-none">
                        <div class="text-gray-700 leading-relaxed">
                            {!! $blog->content !!}

                        </div>
                    </div>
                </div>
            </div>

            {{-- Share Section --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" data-aos="fade-up">
                <h3 class="text-lg font-bold text-secondary mb-4 flex items-center gap-2">
                    <i class="fas fa-share-alt text-primary"></i>
                    {{ $lang === 'id' ? 'Bagikan Artikel' : 'Share Article' }}
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}"
                        target="_blank"
                        class="flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}"
                        target="_blank"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode(url()->current()) }}"
                        class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                        <i class="far fa-envelope"></i>
                        <span>Email</span>
                    </a>
                </div>
            </div>

        </article>

        {{-- Sidebar --}}
        <aside class="space-y-8">
            <!-- Latest Articles -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-2xl font-bold text-secondary mb-6 flex items-center gap-2">
                    <div class="w-1 h-8 bg-primary rounded-full"></div>
                    {{ $lang === 'id' ? 'Artikel Terbaru' : 'Latest Articles' }}
                </h2>

                <div class="space-y-5">
                    @foreach ($relatedBlogs as $related)
                        <a href="{{ route('article.detail', ['slug' => $related->slug]) }}"
                            class="group flex gap-4 pb-5 border-b border-gray-100 last:border-0 hover:bg-neutral/50 p-2 rounded-lg transition">
                            <div class="relative flex-shrink-0 w-24 h-20 rounded-lg overflow-hidden">
                                <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : 'https://picsum.photos/100/80?random=' . $related->id }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $related->title }}">
                                <div
                                    class="absolute inset-0 bg-dark-primary/0 group-hover:bg-dark-primary/20 transition-colors">
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3
                                    class="font-bold text-secondary group-hover:text-primary transition-colors mb-1 line-clamp-2">
                                    {{ $related->title }}
                                </h3>
                                <p class="text-xs text-gray-500 mb-2 line-clamp-2">
                                    {{ Str::limit($related->excerpt, 60) }}
                                </p>
                                <span
                                    class="inline-flex items-center gap-1 text-xs text-primary font-semibold group-hover:gap-2 transition-all">
                                    {{ $lang === 'id' ? 'Baca' : 'Read' }}
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>


        </aside>

    </div>
</div>
