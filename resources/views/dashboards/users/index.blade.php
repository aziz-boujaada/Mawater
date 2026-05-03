<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deep: '#005461',
                        teal: '#0C7779',
                        mid: '#249E94',
                        light: '#3BC1A8',
                    },
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">

        @include('components.side-bar' , ['active' => 'users'])

        <div class="ml-56 flex-1 flex flex-col min-w-0">
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Users</h1>
                    <p class="text-xs text-gray-400">Discover all Users Profiles</p>
                </div>
                <a href="{{ route('register') }}" class="flex items-center gap-2 bg-deep text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-teal transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i>
                    New User
                </a>
            </header>

            <main class="flex-1 p-6">
                <div class="bg-white mb-4 rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="font-syne font-bold text-deep text-sm">All Users</h3>

                        <div class="flex items-center gap-2 bg-gray-100 rounded-xl px-3 py-2 text-sm text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            <input type="text" placeholder="Search…" class="bg-transparent outline-none text-gray-600 placeholder-gray-400 text-sm w-40">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-[0.72rem] uppercase tracking-widest text-gray-400 font-semibold">
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Full Name</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Role</th>
                                    <th class="px-6 py-3">Phone</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-6 py-3.5 text-gray-400 font-mono text-xs">#{{ $user->id }}</td>
                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center gap-1.5 bg-[#f4fafa] border border-[#d4e8ec] text-teal text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-user text-[0.6rem]"></i>
                                            {{ $user->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="text-gray-700 font-medium text-sm">
                                         <i class="fa-solid fa-envelope text-[0.6rem]"></i>
                                        {{ $user->email ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($user->role == 'admin')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Admin
                                        </span>
                                        @elseif($user->role == 'collector')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Collector
                                        </span>
                                        @elseif($user->role == 'repair_agent')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Repair Agent
                                        </span>
                                        @elseif($user->role == 'villager')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-yellow-600 bg-yellow-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Villager
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-gray-700 font-medium text-sm">{{ $user->phone }}</td>

                                    <td>
                                        <a href="{{ route('user.show' , $user->id) }}" class="text-xs text-mid font-semibold hover:underline">View</a>
                                        <a href="{{ route('user.edit' , $user->id) }}" class="text-xs text-mid font-semibold hover:underline">Edit</a>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                                                <i class="fa-solid fa-file-circle-xmark text-red-400 text-base"></i>
                                            </div>
                                            <p class="text-red-500 font-semibold text-sm">No User found</p>
                                            <p class="text-red-300 text-xs">There are no Users to display at the moment.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="response_messgaes">
                    @if(session('error'))
                    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 p-4 text-red-700">
                        _ {{ session('error') }}
                    </div>
                    @elseif(session('success'))
                    <div class="mb-4 rounded-xl bg-green-50 border border-green-200 p-4 text-green-700">
                        _ {{ session('success') }}
                    </div>
                    @endif
                </div>
                {{ $users->links() }}
            </main>
        </div>
    </div>
</body>

<script>
    const hideresponsMessage = () => {
        const respons_msg = document.getElementById('.resposns_messages')
        if (respons_msg) {
            setTimeout(() => {
                respons_msg.classList.add('hidden');
            }, 5000);
        }
        hideresponsMessage()
    }
</script>

</html>