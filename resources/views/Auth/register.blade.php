<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Create Account</h2>

        <form action="{{route('register.store')}}" method="post" class="space-y-4">
            @csrf
            <input
                type="text"
                name="name"
                placeholder="Full Name"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

            <input
                type="email"
                name="email"
                placeholder="Email"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

            <input
                type="text"
                name="phone"
                placeholder="Phone"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

            <select
                id="role"
                name="role"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none"
                onchange="toggleVillagerFields()">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="repair_agent">Repair Agent</option>
                <option value="collector">Collector</option>
                <option value="villager">Villager</option>
            </select>

            <div id="villagerFields" class="space-y-4 hidden">
                <input
                    type="text"
                    name="cin"
                    placeholder="CIN"
                    class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

                <input
                    type="text"
                    name="address"
                    placeholder="Address"
                    class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none" />

                <select
                    name="subscription_status"
                    class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 outline-none">
                    <option value="">Subscription Status</option>
                    <option value="subscribed">Subscribed</option>
                    <option value="not_subscribed">Not Subscribed</option>
                </select>
            </div>
            <div id="message" class="text-center text-sm font-medium"></div>
            <button
                type="submit"
                id="register_btn"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Register
            </button>
            @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </form>

    </div>

    <script>
        function toggleVillagerFields() {
            const role = document.getElementById("role").value;
            const fields = document.getElementById("villagerFields");

            role === "villager" ?
                fields.classList.remove("hidden") :
                fields.classList.add("hidden");
        }
    </script>
</body>

</html>