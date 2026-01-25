@extends('layouts.app')

@section('title', 'Company Profile - ZENIRO')

@section('content')

    <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden">

        <img src="{{ asset('img/asset/HeroSection.jpg') }}" alt="Hero Background Zeniro"
            class="absolute inset-0 w-full h-full object-cover z-0">

        <div class="absolute inset-0 bg-primary-primaryBlue/35 z-10"></div>

        <div class="relative z-20 bg-black/35 rounded-xl p-8 md:p-12 text-center text-white w-full max-w-137.5 mx-4">

            <h1 class="font-heading font-bold text-3xl md:text-4xl mb-4 drop-shadow-lg">
                Welcome Home
            </h1>

            <p class="text-sm md:text-base leading-relaxed drop-shadow-md mx-auto">
                ZENIRO mempersembahkan Personal Minimalism, menyelaraskan desain fungsional dan Zen yang hangat untuk menata
                ketenangan di ruang pribadi Anda.
            </p>

        </div>
    </section>


    <section id="layanan"
        class="py-18 bg-primary-primaryBlue overflow-hidden relative h-screen flex items-center justify-center" x-data="{ 
                                                                        open: false,
                                                                        active: 'pengiriman',
                                                                        services: {
                                                                            'pengiriman': {
                                                                                title: 'Pengiriman Cepat',
                                                                                desc: 'Kecepatan adalah bentuk penghormatan kami terhadap waktu Anda. Nikmati sistem pengiriman yang presisi dan terjadwal, memastikan setiap kurasi ZENIRO tiba di ruang hunian Anda tanpa cela, tepat saat Anda membutuhkannya.',
                                                                                icon: '{{ asset('img/icons/Pengiriman.png') }}'
                                                                            },
                                                                            'konsultasi': {
                                                                                title: 'Home Decor Consultation',
                                                                                desc: 'Ruang Anda adalah kanvas personal. Kami hadir untuk anda, dengean menyelaraskan visi Anda dan estetika ZENIRO, menciptakan harmoni antara fungsionalitas Zen dan kehangatan yang mewah melalui solusi tata ruang yang personal.',
                                                                                icon: '{{ asset('img/icons/home.png') }}'
                                                                            },
                                                                            'online': {
                                                                                title: 'Online Order 24/7',
                                                                                desc: 'Akses tanpa batas menuju ketenangan. Platform digital kami tersedia sepenuhnya untuk melayani kurasi dan pesanan Anda kapan saja, memberikan kenyamanan berbelanja yang eksklusif dari genggaman Anda, setiap saat.',
                                                                                icon: '{{ asset('img/icons/OnlineOrder.png') }}'
                                                                            }
                                                                        }
                                                                    }">
        <div class="container mx-auto px-12">
            <div class="flex flex-col md:flex-row items-center justify-center gap-12 md:gap-24">

                <div class="relative w-75 h-75 flex items-center justify-center shrink-0">

                    <button @click="active = 'pengiriman'; open = false"
                        class="absolute w-16 h-16 bg-accent-blue/70 rounded-full flex items-center justify-center shadow-lg transition-all duration-500 cubic-bezier(0.68, -0.55, 0.265, 1.55) z-30 border-2 border-primary-primaryBlue hover:bg-secondary"
                        :class="open ? 'translate-x-35 -translate-y-20 scale-100 opacity-100' : 'translate-x-0 translate-y-0 scale-0 opacity-0'">
                        <img src="{{ asset('img/icons/pengiriman.png') }}" alt="Gambar Truck"
                            class="w-8 h-8 object-contain">
                    </button>

                    <button @click="active = 'konsultasi'; open = false"
                        class="absolute w-16 h-16 bg-accent-blue/70 rounded-full flex items-center justify-center shadow-lg transition-all duration-500 cubic-bezier(0.68, -0.55, 0.265, 1.55) z-30 delay-75 border-2 border-primary-primaryBlue hover:bg-secondary"
                        :class="open ? 'translate-x-42.5 translate-y-0 scale-100 opacity-100' : 'translate-x-0 translate-y-0 scale-0 opacity-0'">
                        <img src="{{ asset('img/icons/home.png') }}" class="w-8 h-8 object-contain">
                    </button>

                    <button @click="active = 'online'; open = false"
                        class="absolute w-16 h-16 bg-accent-blue/70 rounded-full flex items-center justify-center shadow-lg transition-all duration-500 cubic-bezier(0.68, -0.55, 0.265, 1.55) z-30 delay-150 border-2 border-primary-primaryBlue hover:bg-secondary"
                        :class="open ? 'translate-x-35 translate-y-20 scale-100 opacity-100' : 'translate-x-0 translate-y-0 scale-0 opacity-0'">
                        <img src="{{ asset('img/icons/OnlineOrder.png') }}" class="w-8 h-8 object-contain">
                    </button>


                    <button @click="open = !open"
                        class="relative z-20 w-48 h-48 bg-white rounded-full shadow-2xl flex flex-col items-center justify-center transition-transform duration-300 hover:scale-105 active:scale-95 group">
                        <img :src="services[active].icon" alt="Icon Layanan"
                            class="w-24 h-24 object-contain transition-all duration-300 transform group-hover:-translate-y-1">
                    </button>

                    <div
                        class="absolute inset-0 border-2 border-dashed border-accent-pink/20 rounded-full animate-spin-slow pointer-events-none scale-90">
                    </div>
                </div>


                <div class="text-white max-w-lg transition-opacity duration-300"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" :key="active">
                    <h3 class="font-heading font-bold text-3xl md:text-5xl mb-6" x-text="services[active].title"></h3>
                    <p class="text-lg leading-relaxed opacity-90 text-justify" x-text="services[active].desc"></p>

                    <div class="flex gap-2 mt-8">

                        <button @click="active = 'pengiriman'"
                            class="w-3 h-3 rounded-full transition-colors duration-300 focus:outline-none"
                            :class="active === 'pengiriman' ? 'bg-accent-blue scale-125' : 'bg-white/20 hover:bg-white/50 cursor-pointer'"
                            aria-label="Pilih Pengiriman"></button>

                        <button @click="active = 'konsultasi'"
                            class="w-3 h-3 rounded-full transition-colors duration-300 focus:outline-none"
                            :class="active === 'konsultasi' ? 'bg-accent-blue scale-125' : 'bg-white/20 hover:bg-white/50 cursor-pointer'"
                            aria-label="Pilih Konsultasi"></button>

                        <button @click="active = 'online'"
                            class="w-3 h-3 rounded-full transition-colors duration-300 focus:outline-none"
                            :class="active === 'online' ? 'bg-accent-blue scale-125' : 'bg-white/20 hover:bg-white/50 cursor-pointer'"
                            aria-label="Pilih Online Order"></button>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="katalog" class="py-12 md:py-20 my-12 md:my-20 bg-white font-sans">
        <div class="max-w-full md:max-w-322.5 mx-auto px-10 md:px-24">
            <!-- Mobile Layout (1 column) -->
            <div class="md:hidden grid grid-cols-1 gap-4">
                <div class="col-span-1 h-16 md:h-20 bg-accent-bluesoft rounded-[30px] flex items-center px-6 border border-primary-primaryBlue/5">
                    <h2 class="font-heading text-xl md:text-2xl font-bold text-primary-primaryBlue tracking-tight">
                        ZENIRO Collection
                    </h2>
                </div>

                <a href="{{ route('products.index', ['category' => 'rumah-tangga']) }}"
                    class="relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.02] hover:shadow-2xl h-48">
                    <img src="{{ asset('img/asset/FurnitureRumahTangga.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="Interior 1">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-primaryBlue/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-6 left-6 text-white font-heading text-2xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Rumah Tangga
                    </div>
                </a>

                <a href="{{ route('products.index', ['category' => 'dekorasi']) }}"
                    class="relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.02] hover:shadow-2xl h-48">
                    <img src="{{ asset('img/asset/FurnitureDecoration.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="Interior 2">
                    <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-6 left-6 text-white font-heading text-2xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Decoration
                    </div>
                </a>

                <div class="bg-accent-pink p-5 rounded-[30px] flex flex-col justify-center border border-primary-primaryPink/20 transition-all hover:shadow-md">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Decoration</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Handpicked furniture for your soul.</p>
                </div>

                <a href="{{ route('products.index', ['category' => 'personal-room']) }}"
                    class="relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.02] h-48">
                    <img src="{{ asset('img/asset/FurnitureRoom.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="Interior 3">
                    <div class="absolute inset-0 bg-linear-to-t from-primary-primaryBlue/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-6 left-6 text-white font-heading text-2xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Personal Room
                    </div>
                </a>

                <div class="bg-secondary p-5 rounded-[30px] flex flex-col justify-center border border-accent-blue/10 ">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Minimalist</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Less is more, but excellence is mandatory.</p>
                </div>

                <a href="{{ route('products.index', ['category' => 'hobby']) }}"
                    class="relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.02] h-48">
                    <img src="{{ asset('img/asset/FurnitureHobby.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="Interior 4">
                    <div class="absolute inset-0 bg-linear-to-t from-primary-primaryBlue/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-6 left-6 text-white font-heading text-2xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Hobby
                    </div>
                </a>

                <div class="bg-primary-primaryPink/20 p-4 rounded-[30px] flex flex-col justify-center border border-primary-primaryPink/30">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Hobby</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Your comfort zone, redefined.</p>
                </div>

                <div class="bg-secondary p-5 rounded-[30px] flex flex-col justify-center border border-accent-blue/5">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Private Room</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Enjoy with yourself.</p>
                </div>

                <a href="{{ route('products.index') }}"
                    class="bg-primary-primaryBlue rounded-[20px] flex items-center justify-center text-white font-heading font-bold text-base uppercase tracking-[0.2em] transition-all duration-300 hover:bg-accent-blue py-3 active:scale-95 group">
                    <span class="flex items-center gap-3">
                        Discover
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </span>
                </a>
            </div>

            <!-- Desktop Layout (6 column grid) -->
            <div class="hidden md:grid grid-cols-6 grid-rows-[repeat(16,minmax(50px,auto))] gap-[30px]">

                <div class="col-span-6 row-span-1 h-[80px] bg-accent-bluesoft rounded-[30px] flex items-center px-8 border border-primary-primaryBlue/5">
                    <h2 class="font-heading text-2xl font-bold text-primary-primaryBlue tracking-tight">
                        ZENIRO Collection for Your References
                    </h2>
                </div>

                <a href="{{ route('products.index', ['category' => 'rumah-tangga']) }}"
                    class="col-span-2 row-span-9 relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.01] hover:shadow-2xl">
                    <img src="{{ asset('img/asset/FurnitureRumahTangga.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="Interior 1">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-primaryBlue/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-8 left-8 text-white font-heading text-3xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Rumah Tangga
                    </div>
                </a>

                <a href="{{ route('products.index', ['category' => 'dekorasi']) }}"
                    class="col-span-2 row-span-6 relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.02] hover:shadow-2xl">
                    <img src="{{ asset('img/asset/FurnitureDecoration.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="Interior 2">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-8 left-8 text-white font-heading text-3xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Decoration
                    </div>
                </a>

                <div class="col-span-2 row-span-2 bg-accent-pink p-6 rounded-[30px] flex flex-col justify-center border border-primary-primaryPink/20 transition-all hover:shadow-md">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Decoration</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Handpicked furniture for your soul.</p>
                </div>

                <a href="{{ route('products.index', ['category' => 'personal-room']) }}"
                    class="col-span-2 row-span-8 relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.01]">
                    <img src="{{ asset('img/asset/FurnitureRoom.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="Interior 3">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-primaryBlue/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-8 left-8 text-white font-heading text-3xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Personal Room
                    </div>
                </a>

                <div class="col-span-2 row-span-3 bg-secondary p-6 rounded-[30px] flex flex-col justify-center border border-accent-blue/10">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Minimalist</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Less is more, but luxury is mandatory.</p>
                </div>

                <a href="{{ route('products.index', ['category' => 'hobby']) }}"
                    class="col-span-3 row-span-5 relative overflow-hidden rounded-[30px] group cursor-pointer transition-transform duration-300 hover:scale-[1.01]">
                    <img src="{{ asset('img/asset/FurnitureHobby.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="Interior 4">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-primaryBlue/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-8 left-8 text-white font-heading text-3xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        Hobby
                    </div>
                </a>

                <div class="col-span-1 row-span-5 bg-primary-primaryPink/20 p-5 rounded-[30px] flex flex-col justify-center border border-primary-primaryPink/30">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Hobby</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Your comfort zone, redefined.</p>
                </div>

                <div class="col-span-2 row-span-3 bg-secondary p-6 rounded-[30px] flex flex-col justify-center border border-accent-blue/5">
                    <h3 class="font-heading font-bold text-primary-primaryBlue mb-2">Private Room</h3>
                    <p class="text-sm text-black/70 leading-relaxed">Enjoy with yourself.</p>
                </div>

                <a href="{{ route('products.index') }}"
                    class="col-span-2 row-span-1 bg-primary-primaryBlue rounded-[20px] flex items-center justify-center text-white font-heading font-bold text-base uppercase tracking-[0.2em] transition-all duration-300 hover:bg-accent-blue hover:shadow-[0_10px_30px_rgba(5,31,61,0.3)] hover:-translate-y-1 active:scale-95 group">
                    <span class="flex items-center gap-3">
                        Discover
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </span>
                </a>

            </div>
        </div>
    </section>

    <section id="kontak" class="py-20 md:py-24 flex items-center justify-center min-h-screen"
        style="background-color: #D7EBF7;">

        <div class="w-full mx-auto px-6 md:px-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

                <div class="bg-white rounded-[20px] p-8 md:p-12 shadow-xl">

                    <div class="mb-8">
                        <p class="font-bold text-sm uppercase tracking-wider mb-2" style="color: #305C8E;">Get in Touch</p>
                        <h3 class="font-heading font-bold text-3xl md:text-4xl leading-tight" style="color: #305C8E;">
                            Let us Know, What you think!
                        </h3>
                        <p class="mt-4 text-sm md:text-base opacity-80" style="color: #305C8E;">
                            Punya kritik, masukan atau pertanyaan? Isi form ini, dan akan kami respon 1 kali 24 jam
                        </p>
                    </div>

                    <form action="{{ route('contact.zeniro') }}" method="POST" class="space-y-2">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label for="first_name" class="font-bold text-sm pl-2" style="color: #305C8E;">Nama
                                    Depan</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                                    required
                                    class="w-full h-12 rounded-xl px-4 focus:outline-none focus:ring-2 focus:ring-[#305C8E]/50 transition"
                                    style="background-color: #C1DAF2; color: #305C8E;">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="last_name" class="font-bold text-sm pl-2" style="color: #305C8E;">Nama
                                    Belakang</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                    class="w-full h-12 rounded-xl px-4 focus:outline-none focus:ring-2 focus:ring-[#305C8E]/50 transition"
                                    style="background-color: #C1DAF2; color: #305C8E;">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="email" class="font-bold text-sm pl-2" style="color: #305C8E;">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full h-12 rounded-xl px-4 focus:outline-none focus:ring-2 focus:ring-[#305C8E]/50 transition"
                                style="background-color: #C1DAF2; color: #305C8E;">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="message" class="font-bold text-sm pl-2" style="color: #305C8E;">Pesan</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-[#305C8E]/50 transition resize-none"
                                style="background-color: #C1DAF2; color: #305C8E;">{{ old('message') }}</textarea>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="px-10 py-3 rounded-xl font-bold text-white shadow-md hover:opacity-90 transition transform hover:scale-105 active:scale-95"
                                style="background-color: #E8A9B1;">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>


                <div class="flex flex-col h-full">

                    <div class="flex-1 w-full rounded-[20px] overflow-hidden shadow-lg mb-6">
                        <img src="{{ asset('img/asset/ContactUs.jpg') }}" alt="Contact Zeniro"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="grid grid-cols-3 gap-4 md:gap-6">

                        <a href="#"
                            class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-3 text-white hover:opacity-90 transition shadow-md group"
                            style="background-color: #E8A9B1;">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                                <img src="{{ asset('img/icons/instagram.png') }}" class="w-6 h-6 object-contain">
                            </div>
                            <span class="hidden md:block text-[10px] md:text-xs font-bold text-center px-2">@zeniro.furniture</span>
                        </a>

                        <a href="#"
                            class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-3 text-white hover:opacity-90 transition shadow-md group"
                            style="background-color: #E8A9B1;">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                                <img src="{{ asset('img/icons/youtube.png') }}" class="w-6 h-6 object-contain">
                            </div>
                            <span class="hidden md:block text-[10px] md:text-xs font-bold text-center px-2">Zeniro Official</span>
                        </a>

                        <a href="#"
                            class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-3 text-white hover:opacity-90 transition shadow-md group"
                            style="background-color: #E8A9B1;">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                                <img src="{{ asset('img/icons/mail.png') }}" class="w-6 h-6 object-contain">
                            </div>
                            <span
                                class="hidden md:block text-[10px] md:text-xs font-bold text-center px-2 break-all">hello@zeniro.com</span>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection