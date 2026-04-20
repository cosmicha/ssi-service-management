
<div class="spa-view">
    

<div class="page">

    <div class="hero">
        <h1 style="margin:0 0 8px;">Vendor Master</h1>
        <p style="margin:0; color:rgba(255,255,255,.84);">
            Manage vendor support, warranty contacts, and service references.
        </p>

        <div class="actions">
            @if((auth()->user()->role ?? null) === 'admin')
                <a href="{{ route('vendors.create') }}" class="btn btn-secondary">Add Vendor</a>
            @endif
            <a href="{{ url('/devices') }}" class="btn btn-secondary">Devices</a>
            <a href="{{ url('/problem-logs') }}" class="btn btn-secondary">Tickets</a>
        </div>
    </div>

    
        <div class="actions">
            @if((auth()->user()->role ?? null) === 'admin')
                <a href="{{ route('vendors.create') }}" class="btn btn-secondary">Add Vendor</a>
            @endif
            <a href="/devices" class="btn btn-secondary">Devices</a>
            <a href="/problem-logs" class="btn btn-secondary">Tickets</a>
            <a href="/" class="btn btn-secondary">Dashboard</a>
        </div>


        <div class="card">

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
            <tr>
                <th>Vendor</th>
                <th>Contact</th>
                <th>Support</th>
                <th>Status</th>
                <th style="width:200px;">Action</th>
            </tr>
            </thead>

            <tbody>
            @forelse($vendors as $vendor)
                <tr>
                    <td>
                        <div class="vendor-name">{{ $vendor->name }}</div>
                        <div class="muted">{{ $vendor->notes ?? '-' }}</div>
                    </td>

                    <td>{{ $vendor->contact ?? '-' }}</td>

                    <td>{{ $vendor->support_phone ?? '-' }}</td>

                    <td>
                        @if($vendor->is_active ?? true)
                            <span class="pill pill-active">Active</span>
                        @else
                            <span class="pill pill-inactive">Inactive</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('vendors.show', $vendor) }}" class="link-btn">View</a>

                        @if((auth()->user()->role ?? null) === 'admin')
                            <a href="{{ route('vendors.edit', $vendor) }}" class="link-btn">Edit</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted" style="padding:24px 0;">
                        No vendors found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

</div>


</div>
