<x-app-layout>

<div class="mb-8">

    <h1 class="text-3xl font-black">
        Warranty Tracking
    </h1>

    <p class="text-slate-500 mt-2">
        Monitor expiring and expired warranties.
    </p>

</div>

<div class="grid md:grid-cols-2 gap-6">

<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-5 bg-orange-50 font-black">
        Expiring Within 90 Days
    </div>

    <div class="divide-y">

        @forelse($expiring as $asset)

        <div class="p-5">

            <div class="font-black">
                {{ $asset->name }}
            </div>

            <div class="text-sm text-slate-500">

                {{ $asset->asset_code }}

            </div>

            <div class="mt-2 text-orange-600 font-bold">

                {{ $asset->warranty_expiry }}

            </div>

        </div>

        @empty

        <div class="p-5 text-slate-400">

            No assets.

        </div>

        @endforelse

    </div>

</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-5 bg-red-50 font-black">
        Expired Warranty
    </div>

    <div class="divide-y">

        @forelse($expired as $asset)

        <div class="p-5">

            <div class="font-black">
                {{ $asset->name }}
            </div>

            <div class="text-sm text-slate-500">

                {{ $asset->asset_code }}

            </div>

            <div class="mt-2 text-red-600 font-bold">

                {{ $asset->warranty_expiry }}

            </div>

        </div>

        @empty

        <div class="p-5 text-slate-400">

            No assets.

        </div>

        @endforelse

    </div>

</div>

</div>

</x-app-layout>
