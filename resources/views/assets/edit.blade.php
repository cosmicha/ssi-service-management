<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Edit Asset</h1>
        <p class="text-slate-500 mt-1">{{ $asset->name }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('assets.update', $asset) }}">
            @csrf
            @method('PUT')
            @include('assets.form')
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mt-6">
        <h2 class="text-lg font-black mb-4">Documents & Files</h2>

        <form
            method="POST"
            action="{{ route('assets.attachments.store',$asset) }}"
            enctype="multipart/form-data"
            class="mb-6"
        >
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <select name="attachment_type" class="rounded-xl border-slate-300">
                    <option value="photo">Photo</option>
                    <option value="manual">Manual</option>
                    <option value="configuration">Configuration</option>
                    <option value="diagram">Diagram</option>
                    <option value="license">License</option>
                    <option value="warranty">Warranty</option>
                    <option value="invoice">Invoice</option>
                    <option value="document">Document</option>
                    <option value="other">Other</option>
                </select>

                <input
                    type="file"
                    name="attachments[]"
                    multiple
                    class="border rounded-xl p-2"
                />
            </div>

            <button class="mt-3 px-4 py-2 bg-slate-900 text-white rounded-xl">
                Upload Files
            </button>
        </form>

        <div class="space-y-3">
            @forelse($asset->attachments as $file)
                <div class="border rounded-xl p-3 flex justify-between">
                    <div>
                        <div class="font-semibold">{{ $file->file_name }}</div>
                        <div class="text-xs text-slate-500">
                            {{ ucfirst($file->attachment_type) }} •
                            {{ $file->file_size ? number_format($file->file_size / 1024, 1) . ' KB' : '-' }}
                        </div>
                    </div>

                    <div class="flex gap-3 items-center">
                        <a
                            href="{{ asset('storage/'.$file->file_path) }}"
                            target="_blank"
                            class="text-blue-600 font-semibold"
                        >
                            View
                        </a>

                        <form
                            method="POST"
                            action="{{ route('asset-attachments.destroy',$file) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 font-semibold">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-slate-500">No documents uploaded.</div>
            @endforelse
        </div>
    </div>

</x-app-layout>
