@extends('admin.layouts.app')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
    <div class="space-y-6">

        <!-- Stats & Filter -->
        <div class="flex items-center justify-between">
            <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                <a href="{{ route('admin.users.index') }}"
                    class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $filter === 'all' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
                    All Users ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'admin']) }}"
                    class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $filter === 'admin' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
                    Admins ({{ $counts['admin'] }})
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'user']) }}"
                    class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $filter === 'user' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
                    Members ({{ $counts['user'] }})
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'with_orders']) }}"
                    class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $filter === 'with_orders' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
                    With Orders ({{ $counts['with_orders'] }})
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'without_orders']) }}"
                    class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $filter === 'without_orders' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
                    Without Orders ({{ $counts['without_orders'] }})
                </a>
            </div>

            <!-- Search & Add Button -->
            <div class="flex items-center gap-3">
                <form method="GET" class="flex items-center gap-3">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                            class="w-55 pl-10 pr-4 py-1.5 text-sm rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans">
                        <svg class="w-5 h-5 absolute left-3 top-2 text-gray" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.users.index', ['filter' => $filter]) }}"
                            class="px-4 py-2 bg-gray/20 text-gray rounded-xl hover:bg-gray/30 transition font-sans font-bold">
                            Clear
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.users.create') }}"
                    class="px-2 py-1.5 text-sm bg-accent-blue text-white rounded-lg hover:bg-accent-blue/90 transition font-sans font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add User
                </a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-primary-primaryBlue">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">User</th>
                        <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Email</th>
                        <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Joined</th>
                        <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Orders</th>
                        <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Actions</th>
                        <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Role</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray/20">
                    @forelse($users as $user)
                        <tr class="hover:bg-secondary/30 transition">
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-primary-primaryPink rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="font-heading font-bold text-white">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-sans font-bold text-black">{{ $user->name }}</p>
                                        @if($user->id === auth()->id())
                                            <span class="text-xs font-sans text-accent-blue">(Kamu Adminnya)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 font-sans text-black">{{ $user->email }}</td>
                            <td class="px-4 py-2.5 font-sans text-sm text-gray">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-2.5">
                                @if($user->orders_count > 0)
                                    <span class="font-sans font-bold text-black">{{ $user->orders_count }}</span>
                                @else
                                    <span class="font-sans text-gray">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-2">
                                    <button onclick="showUserDetail({{ $user->id }})"
                                        class="p-2 text-accent-blue hover:bg-accent-blue/10 rounded-lg transition"
                                        title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Hapus user {{ $user->name }}? Semua data terkait akan dihapus.')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition"
                                                title="Delete User">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2.5">
                                <span class="px-3 py-1 {{ $user->role_color }} rounded-full text-xs font-sans font-bold">
                                    {{ $user->role_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="font-sans text-gray text-lg">
                                    @if(request('search'))
                                        No users found matching your search
                                    @else
                                        Belum ada user
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="flex items-center justify-between bg-white rounded-2xl p-6">
                <p class="font-sans text-gray text-sm">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </p>
                <div class="flex items-center gap-2">
                    @if ($users->onFirstPage())
                        <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $users->appends(request()->except('page'))->previousPageUrl() }}"
                            class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-white transition">
                            Previous
                        </a>
                    @endif

                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="px-4 py-2 bg-accent-blue text-white rounded-lg font-sans font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $users->appends(request()->except('page'))->url($page) }}"
                                class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-white transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($users->hasMorePages())
                        <a href="{{ $users->appends(request()->except('page'))->nextPageUrl() }}"
                            class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-white transition">
                            Next
                        </a>
                    @else
                        <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <!-- User Detail Modal -->
    <div id="userDetailModal" class="hidden fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
        onclick="handleModalClick(event)">
        <div class="bg-white rounded-2xl max-w-sm w-full relative" style="max-height: 90vh;"
            onclick="event.stopPropagation()">

            <!-- Header -->
            <div class="bg-primary-primaryBlue rounded-t-2xl px-4 py-3 flex items-center justify-between">
                <h2 class="text-lg font-heading font-bold text-white">User Details</h2>
                <button onclick="closeModal()" class="text-white hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div id="userDetailContent" class="p-4 overflow-y-auto" style="max-height: calc(90vh - 60px);">
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-blue"></div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function showUserDetail(userId) {
            const modal = document.getElementById('userDetailModal');
            const content = document.getElementById('userDetailContent');

            modal.classList.remove('hidden');

            content.innerHTML = `
                            <div class="flex justify-center items-center py-12">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-blue"></div>
                            </div>
                        `;

            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderUserDetail(data.user);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                                    <div class="text-center py-12">
                                        <p class="text-red-600 font-sans">Failed to load user details</p>
                                    </div>
                                `;
                });
        }

        function renderUserDetail(user) {
            const content = document.getElementById('userDetailContent');

            const ordersHtml = user.orders.length > 0
                ? user.orders.map(order => `
                                <div class="p-2 bg-secondary/30 rounded-lg text-xs">
                                    <div class="flex items-center justify-between mb-1">
                                        <div>
                                            <p class="font-sans font-bold text-black">${order.order_number}</p>
                                            <p class="text-xs font-sans text-gray">${order.date}</p>
                                        </div>
                                        <span class="px-2 py-0.5 ${order.status_color} rounded-full text-xs font-sans font-bold">
                                            ${order.status_label}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                        <p class="text-xs font-sans text-gray">${order.items_count} item(s)</p>
                                        <p class="font-sans font-bold text-primary-primaryBlue">${order.total_formatted}</p>
                                    </div>
                                </div>
                            `).join('')
                : '<p class="text-center font-sans text-gray py-4 text-xs">No orders yet</p>';

            const contactsHtml = user.contacts.length > 0
                ? user.contacts.map(contact => `
                                <div class="p-2 bg-secondary/30 rounded-lg text-xs">
                                    <p class="text-xs font-sans text-gray mb-1">${contact.date}</p>
                                    <p class="font-sans text-black text-xs">${contact.message}</p>
                                </div>
                            `).join('')
                : '<p class="text-center font-sans text-gray py-4 text-xs">No messages</p>';

            content.innerHTML = `
                            <div class="space-y-3">
                                <!-- User Info -->
                                <div class="flex items-center gap-3 bg-white rounded-lg p-3">
                                    <div class="w-10 h-10 bg-primary-primaryPink rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-lg font-heading font-bold text-white">
                                            ${user.initials}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-heading font-bold text-primary-primaryBlue truncate">${user.name}</h3>
                                        <p class="font-sans text-gray text-xs mt-0.5 truncate">${user.email}</p>
                                         <span class="inline-block px-2 py-0.5 bg-accent-blue text-white rounded-full text-xs font-sans font-bold mt-1">
                                            ${user.role_label}
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-2 text-right flex-shrink-0">
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-xs font-sans text-gray">Joined</p>
                                            <p class="font-sans font-bold text-black text-xs">${user.joined_date}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-xs font-sans text-gray">Phone</p>
                                                <div class="font-sans font-bold text-xs">
                                                    ${user.phone 
                                                        ? `<span class="text-black">${user.phone}</span>` 
                                                        : `<span class="text-red-500 italic">Tidak ada Nomor</span>`
                                                    }
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                    <hr class="border-gray/30">
                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="bg-white rounded-lg p-2 text-center">
                                        <p class="text-lg font-heading font-bold text-primary-primaryBlue">${user.orders_count}</p>
                                        <p class="text-xs font-sans text-gray mt-0.5">Orders</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-2 text-center">
                                        <p class="text-sm font-heading font-bold text-primary-primaryBlue">${user.total_spent_formatted}</p>
                                        <p class="text-xs font-sans text-gray mt-0.5">Spent</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-2 text-center">
                                        <p class="text-lg font-heading font-bold text-primary-primaryBlue">${user.contacts_count}</p>
                                        <p class="text-xs font-sans text-gray mt-0.5">Messages</p>
                                    </div>
                                </div>

                                <!-- Orders -->
                                <div>
                                    <h3 class="text-sm font-heading font-bold text-primary-primaryBlue mb-2">Order History</h3>
                                    <div class="space-y-2 max-h-40 overflow-y-auto text-xs">
                                        ${ordersHtml}
                                    </div>
                                </div>

                                <!-- Contact Messages -->
                                <div>
                                    <h3 class="text-sm font-heading font-bold text-primary-primaryBlue mb-2">Contact Messages</h3>
                                    <div class="space-y-2 max-h-40 overflow-y-auto text-xs">
                                        ${contactsHtml}
                                    </div>
                                </div>
                            </div>
                        `;
        }

        function closeModal() {
            document.getElementById('userDetailModal').classList.add('hidden');
        }

        function handleModalClick(event) {
            if (event.target.id === 'userDetailModal') {
                closeModal();
            }
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>

@endsection