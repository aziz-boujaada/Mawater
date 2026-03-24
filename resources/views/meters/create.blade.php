<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Create Meter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#005461] to-[#3BC1A8]">

    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-[#005461]">
            Create Meter
        </h2>

        <!-- Errors -->
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('meter.store') }}" method="post" class="space-y-4">
            @csrf

            <!-- Villager Select -->
            <select
                name="villager_id"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#249E94] outline-none">
                <option value="">Select Villager</option>
                @foreach($villagers as $villager)
                    <option value="{{ $villager->id }}">
                        {{ $villager->name }}
                    </option>
                @endforeach
            </select>

            <!-- Status -->
            <select
                name="status"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#249E94] outline-none">
                <option value="">Meter Status</option>
                <option value="active">Active</option>
                <option value="broken">Broken</option>
                <option value="repaired">Repaired</option>
                <option value="out_of_service">Out Of Service</option>
            </select>

            <!-- Date -->
            <div>
                <label class="text-sm text-gray-600">Installation Date</label>
                <input
                    type="date"
                    name="installation_date"
                    class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#249E94] outline-none" />
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full bg-[#005461] text-white py-3 rounded-lg font-semibold hover:bg-[#0C7779] transition">
                Create Meter
            </button>
        </form>
    </div>

</body>

</html>