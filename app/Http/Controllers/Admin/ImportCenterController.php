<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportCenterController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    public function template(string $type)
    {
        $headers = match ($type) {
            'customers' => [
                'name','code','industry','contact_person','contact_email',
                'contact_phone','address','status','sla_enabled',
                'response_minutes','resolution_minutes'
            ],
            'branches' => [
                'customer_code','region_name','branch_code','name','address','status'
            ],
            'assets' => [
                'customer_code','branch_code','category_name','name','asset_code',
                'brand','model','serial_number','ip_address','status'
            ],
            'inventory-items' => [
                'sku','name','category_name','unit','minimum_stock','unit_cost','status'
            ],
            'users' => [
                'name','email','password','role','is_approved',
                'customer_code','customer_access_scope','branch_code'
            ],
            default => abort(404),
        };

        $sample = match ($type) {
            'customers' => [
                'NRS','NRS','Retail','Admin NRS','admin@nrs.co.id',
                '08123456789','Jakarta','active','1','30','240'
            ],
            'branches' => [
                'NRS','Jabodetabek','BDG','Bandung Branch','Bandung','active'
            ],
            'assets' => [
                'NRS','BDG','Network','Cisco Core Switch','ASSET-001',
                'Cisco','CBS350','SN123','192.168.1.10','active'
            ],
            'inventory-items' => [
                'PART-001','LAN Cable Cat6','Network Parts','pcs','5','25000','active'
            ],
            'users' => [
                'Customer Admin NRS','admin.nrs@example.com','password123',
                'customer_admin','1','NRS','ho',''
            ],
            default => [],
        };

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($headers as $i => $header) {
            $sheet->setCellValueByColumnAndRow($i + 1, 1, $header);
            $sheet->setCellValueByColumnAndRow($i + 1, 2, $sample[$i] ?? '');
        }

        $path = storage_path("app/template-{$type}.xlsx");
        (new Xlsx($spreadsheet))->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function import(Request $request, string $type)
    {
        $request->validate([
            'file' => ['required','file','mimes:xlsx,xls'],
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        if (count($rows) < 2) {
            return back()->with('error','File has no data rows.');
        }

        $headers = array_map(
            fn($v) => strtolower(trim(str_replace(' ', '_', (string)$v))),
            array_values($rows[1])
        );

        $imported = 0;

        foreach (array_slice($rows, 1) as $row) {
            $values = array_values($row);
            $data = [];

            foreach ($headers as $i => $header) {
                if ($header !== '') {
                    $data[$header] = trim((string)($values[$i] ?? ''));
                }
            }

            if (!array_filter($data)) {
                continue;
            }

            match ($type) {
                'customers' => $this->importCustomer($data),
                'branches' => $this->importBranch($data),
                'assets' => $this->importAsset($data),
                'inventory-items' => $this->importInventoryItem($data),
                'users' => $this->importUser($data),
                default => abort(404),
            };

            $imported++;
        }

        return back()->with('success', "{$imported} rows imported.");
    }

    private function importCustomer(array $data): void
    {
        Customer::updateOrCreate(
            ['code' => $data['code'] ?: $data['name']],
            [
                'name' => $data['name'] ?? '',
                'industry' => $data['industry'] ?? null,
                'contact_person' => $data['contact_person'] ?? null,
                'contact_email' => $data['contact_email'] ?? null,
                'contact_phone' => $data['contact_phone'] ?? null,
                'address' => $data['address'] ?? null,
                'status' => $data['status'] ?: 'active',
                'sla_enabled' => (bool)($data['sla_enabled'] ?? false),
                'response_minutes' => $data['response_minutes'] ?: null,
                'resolution_minutes' => $data['resolution_minutes'] ?: null,
            ]
        );
    }

    private function importBranch(array $data): void
    {
        $customer = $this->customer($data['customer_code'] ?? null);

        if (!$customer) {
            return;
        }

        $region = null;

        if (!empty($data['region_name'])) {
            $region = CustomerRegion::firstOrCreate([
                'customer_id' => $customer->id,
                'name' => $data['region_name'],
            ]);
        }

        CustomerBranch::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'code' => $data['branch_code'] ?: $data['name'],
            ],
            [
                'customer_region_id' => $region?->id,
                'name' => $data['name'] ?? '',
                'address' => $data['address'] ?? null,
                'status' => $data['status'] ?: 'active',
            ]
        );
    }

    private function importAsset(array $data): void
    {
        $customer = $this->customer($data['customer_code'] ?? null);
        $branch = $this->branch($data['branch_code'] ?? null, $customer?->id);

        if (!$customer) {
            return;
        }

        $category = null;

        if (!empty($data['category_name'])) {
            $category = AssetCategory::firstOrCreate([
                'name' => $data['category_name'],
            ], [
                'status' => 'active',
            ]);
        }

        DB::table('assets')->updateOrInsert(
            ['asset_code' => $data['asset_code'] ?: $data['name']],
            $this->onlyExistingColumns('assets', [
                'customer_id' => $customer->id,
                'customer_branch_id' => $branch?->id,
                'asset_category_id' => $category?->id,
                'name' => $data['name'] ?? '',
                'asset_code' => $data['asset_code'] ?: null,
                'brand' => $data['brand'] ?? null,
                'model' => $data['model'] ?? null,
                'serial_number' => $data['serial_number'] ?? null,
                'ip_address' => $data['ip_address'] ?? null,
                'status' => $data['status'] ?: 'active',
                'updated_at' => now(),
                'created_at' => now(),
            ])
        );
    }

    private function importInventoryItem(array $data): void
    {
        DB::table('inventory_items')->updateOrInsert(
            ['sku' => $data['sku'] ?: $data['name']],
            $this->onlyExistingColumns('inventory_items', [
                'sku' => $data['sku'] ?: null,
                'name' => $data['name'] ?? '',
                'category_name' => $data['category_name'] ?? null,
                'unit' => $data['unit'] ?? 'pcs',
                'minimum_stock' => $data['minimum_stock'] ?: 0,
                'unit_cost' => $data['unit_cost'] ?: 0,
                'status' => $data['status'] ?: 'active',
                'updated_at' => now(),
                'created_at' => now(),
            ])
        );
    }

    private function importUser(array $data): void
    {
        $customer = $this->customer($data['customer_code'] ?? null);
        $branch = $this->branch($data['branch_code'] ?? null, $customer?->id);

        User::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? '',
                'password' => Hash::make($data['password'] ?: 'password123'),
                'role' => $data['role'] ?: 'customer',
                'is_approved' => (bool)($data['is_approved'] ?? true),
                'customer_id' => $customer?->id,
                'customer_access_scope' => $data['customer_access_scope'] ?: 'ho',
                'customer_branch_id' => $branch?->id,
            ]
        );
    }

    private function customer(?string $code): ?Customer
    {
        if (!$code) return null;

        return Customer::where('code', $code)
            ->orWhere('name', $code)
            ->first();
    }

    private function branch(?string $code, ?int $customerId = null): ?CustomerBranch
    {
        if (!$code) return null;

        return CustomerBranch::query()
            ->when($customerId, fn($q) => $q->where('customer_id', $customerId))
            ->where(fn($q) => $q->where('code', $code)->orWhere('name', $code))
            ->first();
    }

    private function onlyExistingColumns(string $table, array $data): array
    {
        $columns = Schema::getColumnListing($table);

        return collect($data)
            ->filter(fn($v, $k) => in_array($k, $columns))
            ->toArray();
    }
}
