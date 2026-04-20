
<div class="spa-view">
    

<div class="page">
    
            <div class="actions">
                <a href="/vendors" class="btn btn-secondary">Vendors</a>
                <a href="/problem-logs" class="btn btn-secondary">Tickets</a>
                <a href="/" class="btn btn-secondary">Dashboard</a>
            </div>


        <div class="card">

        <h2>Device Master</h2>

        <table>
            <thead>
                <tr>
                    <th>Device</th>
                    <th>Customer</th>
                    <th>Location</th>
                    <th>Vendor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr>
                    <td>
                        <b>{{ $device->device_code }}</b><br>
                        <span class="muted">{{ $device->cms_device_name }}</span>
                    </td>
                    <td>{{ optional($device->company)->name }}</td>
                    <td>{{ $device->location_name }}</td>
                    <td>{{ optional($device->vendor)->name }}</td>
                    <td>
                        <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-edit">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


</div>
