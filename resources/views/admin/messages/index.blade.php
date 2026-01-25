@extends('admin.layouts.app')

@section('title', 'Messages')
@section('page-title', 'Contact Messages')

@section('content')
    <div class="space-y-6">

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl px-6 py-4 border-l-4 border-accent-blue">
                <p class="text-sm font-sans text-gray mb-1">Total Messages</p>
                <p class="text-2xl font-heading font-bold text-primary-primaryBlue">{{ $messages->total() }}</p>
            </div>
            <div class="bg-white rounded-2xl px-6 py-4 border-l-4 border-green-500">
                <p class="text-sm font-sans text-gray mb-1">From Users</p>
                <p class="text-2xl font-heading font-bold text-primary-primaryBlue">
                    {{ $messages->where('user_id', '!=', null)->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl px-6 py-4 border-l-4 border-primary-primaryPink">
                <p class="text-sm font-sans text-gray mb-1">From Guests</p>
                <p class="text-2xl font-heading font-bold text-primary-primaryBlue">
                    {{ $messages->where('user_id', null)->count() }}</p>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="bg-white rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead class="bg-primary-primaryBlue">
                        <tr>
                            <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Name</th>
                            <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Role</th>
                            <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Email</th>
                            <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Message</th>
                            <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray/20">
                        @forelse($messages as $message)
                            <tr class="hover:bg-secondary/30 transition">
                                <td class="px-4 py-2.5">
                                    <p class="font-sans font-bold text-black">{{ $message->full_name }}</p>
                                </td>
                                <td>@if($message->user)
                                    <span
                                        class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-sans font-bold mt-1">
                                        Registered User
                                    </span>
                                @else
                                        <span
                                            class="inline-block px-2 py-1 bg-gray/20 text-gray rounded text-xs font-sans font-bold mt-1">
                                            Guest
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 font-sans text-black">{{ $message->email }}</td>
                                <td class="px-4 py-2.5 font-sans text-gray w-70">
                                    <p class="whitespace-normal">{{ $message->message }}</p>
                                </td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button onclick="showMessage({{ $message->id }})"
                                            class="p-2 text-accent-blue hover:bg-accent-blue/10 rounded-lg transition"
                                            title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                                            onsubmit="return confirm('Hapus pesan ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <p class="font-sans text-gray text-lg">Belum ada pesan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white rounded-2xl p-6">
                <p class="font-sans text-gray text-sm">
                    <span class="hidden md:block">Showing {{ $messages->firstItem() }} to {{ $messages->lastItem() }} of {{ $messages->total() }} messages</span>
                    <span class="md:hidden">{{ $messages->firstItem() }}-{{ $messages->lastItem() }} of {{ $messages->total() }}</span>
                </p>
                <div class="flex items-center gap-2">
                    @if ($messages->onFirstPage())
                        <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed">
                            <span class="hidden md:block">Previous</span>
                            <span class="md:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $messages->previousPageUrl() }}"
                            class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-gray/10 transition">
                            <span class="hidden md:block">Previous</span>
                            <span class="md:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        </a>
                    @endif

                    @foreach($messages->getUrlRange(1, $messages->lastPage()) as $page => $url)
                        @if($page == $messages->currentPage())
                            <span class="px-4 py-2 bg-accent-blue text-white rounded-lg font-sans font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-gray/10 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($messages->hasMorePages())
                        <a href="{{ $messages->nextPageUrl() }}"
                            class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-gray/10 transition">
                            <span class="hidden md:block">Next</span>
                            <span class="md:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed">
                            <span class="hidden md:block">Next</span>
                            <span class="md:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <!-- Message Detail Modal -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
        onclick="handleModalClick(event)">
        <div class="bg-white rounded-2xl max-w-md w-full relative" onclick="event.stopPropagation()">

            <!-- Header -->
            <div class="bg-primary-primaryBlue rounded-t-2xl px-4 py-3 flex items-center justify-between">
                <h2 class="text-lg font-heading font-bold text-white">Message Detail</h2>
                <button onclick="closeModal()" class="text-white hover:text-gray-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div id="messageContent" class="p-4">
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-blue"></div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function showMessage(messageId) {
            const modal = document.getElementById('messageModal');
            const content = document.getElementById('messageContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            content.innerHTML = `
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-blue"></div>
            </div>
        `;

            fetch(`/admin/messages/${messageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderMessageDetail(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                    <div class="text-center py-12">
                        <p class="text-red-600 font-sans">Failed to load message</p>
                    </div>
                `;
                });

            function closeModal() {
                const modal = document.getElementById('messageModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function renderMessageDetail(message) {
            const content = document.getElementById('messageContent');

            const userBadge = message.is_user
                ? '<span class="inline-block px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-sans font-bold">Registered User</span>'
                : '<span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-700 rounded-full text-xs font-sans font-bold">Guest</span>';

            // 2. Logic Nama & Email
            // Kita tampilin nama dari FORM dulu, baru info akun aslinya (biar admin tau kalau ada beda)
            const displayEmail = message.is_registered 
                ? `${message.form_email} <br><span class="text-[10px] text-gray-500">(Account: ${message.user_data.email})</span>`
                : message.form_email;

            const displayName = message.is_registered 
                ? `${message.form_name} <br><span class="text-[10px] text-gray-500">(Account: ${message.user_data.name})</span>`
                : message.form_name;

                
            // 1. Bikin variabel penampung HTML kosong
            let accountInfoHtml = '';

            // 2. Cek Logic di JS: Kalau dia Registered User, isi variabelnya
            // Pastikan message.user_data ada isinya biar gak error
            if (message.is_registered && message.user_data) {
                accountInfoHtml = `
                    <div class="bg-secondary rounded-lg p-3 mb-3">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-heading font-bold text-primary-primaryBlue">Account Information</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-xs font-sans font-sans text-gray mb-0.5">Name</p>
                                <p class="font-sans font-bold text-black text-xs font-sans">${message.user_data.name}</p>
                            </div>
                            <div>
                                <p class="text-xs font-sans font-sans text-gray mb-0.5">Email</p>
                                <p class="font-sans font-bold text-black text-xs font-sans break-all">${message.user_data.email}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
            content.innerHTML = `
            <div class="space-y-4">
                <div class="bg-secondary rounded-lg p-3">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-heading font-bold text-primary-primaryBlue">Sender Information</h3>
                        ${userBadge}
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-xs font-sans font-sans text-gray mb-0.5">Name</p>
                            <p class="font-sans font-bold text-black text-xs font-sans">${message.full_name} </p>
                        </div>
                        <div>
                            <p class="text-xs font-sans font-sans text-gray mb-0.5">Email</p>
                            <p class="font-sans font-bold text-black text-xs font-sans">${message.email}</p>
                        </div>
                        <div>
                            <p class="text-xs font-sans font-sans text-gray mb-0.5">Date</p>
                            <p class="font-sans text-black text-xs font-sans">${message.date}</p>
                        </div>
                        <div>
                            <p class="text-xs font-sans font-sans text-gray mb-0.5">Time</p>
                            <p class="font-sans text-black text-xs font-sans">${message.time}</p>
                        </div>
                    </div>
                </div>

                <!-- Message Content -->
                <div>
                    <h3 class="text-sm font-heading font-bold text-primary-primaryBlue mb-2">Message</h3>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="font-sans text-black leading-relaxed whitespace-pre-wrap text-sm">${message.message}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <a href="mailto:${message.email}" 
                       class="flex-1 px-4 py-2 bg-accent-blue text-white rounded-lg hover:bg-accent-blue/90 transition font-sans font-bold text-center text-xs">
                        Reply via Email
                    </a>
                    <form action="/admin/messages/${message.id}" method="POST" class="flex-1" onsubmit="return confirm('Hapus pesan ini?')">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]')?.content || ''}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-sans font-bold text-xs">
                            Delete Message
                        </button>
                    </form>
                </div>
            </div>
        `;
        }

        function closeModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }

        function handleModalClick(event) {
            if (event.target.id === 'messageModal') {
                closeModal();
            }
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>

    <style>
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

@endsection