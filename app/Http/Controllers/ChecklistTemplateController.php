<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\ChecklistTemplate;
use App\Models\ChecklistTemplateItem;
use Illuminate\Http\Request;

class ChecklistTemplateController extends Controller
{
    public function index()
    {
        $templates = ChecklistTemplate::with('category')
            ->withCount('items')
            ->latest()
            ->paginate(15);

        return view('checklist-templates.index', compact('templates'));
    }

    public function create()
    {
        $categories = AssetCategory::where('status', 'active')->orderBy('name')->get();

        return view('checklist-templates.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $template = ChecklistTemplate::create($request->validate([
            'asset_category_id' => ['nullable', 'exists:asset_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'frequency' => ['required', 'in:daily,weekly,monthly,quarterly,semester,yearly,manual'],
            'status' => ['required', 'in:active,inactive'],
        ]));

        return redirect()->route('checklist-templates.show', $template)
            ->with('success', 'Checklist template created.');
    }

    public function show(ChecklistTemplate $checklistTemplate)
    {
        $checklistTemplate->load(['category', 'items']);

        return view('checklist-templates.show', compact('checklistTemplate'));
    }

    public function edit(ChecklistTemplate $checklistTemplate)
    {
        $categories = AssetCategory::orderBy('name')->get();

        return view('checklist-templates.edit', compact('checklistTemplate', 'categories'));
    }

    public function update(Request $request, ChecklistTemplate $checklistTemplate)
    {
        $checklistTemplate->update($request->validate([
            'asset_category_id' => ['nullable', 'exists:asset_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'frequency' => ['required', 'in:daily,weekly,monthly,quarterly,semester,yearly,manual'],
            'status' => ['required', 'in:active,inactive'],
        ]));

        return redirect()->route('checklist-templates.show', $checklistTemplate)
            ->with('success', 'Checklist template updated.');
    }

    public function destroy(ChecklistTemplate $checklistTemplate)
    {
        $checklistTemplate->delete();

        return redirect()->route('checklist-templates.index')
            ->with('success', 'Checklist template deleted.');
    }

    public function storeItem(Request $request, ChecklistTemplate $checklistTemplate)
    {
        $checklistTemplate->items()->create($request->validate([
            'section' => ['nullable', 'string', 'max:255'],
            'item_name' => ['required', 'string', 'max:255'],
            'instruction' => ['nullable', 'string'],
            'input_type' => ['required', 'in:pass_fail,text,number,photo,file'],
            'is_required' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
        ]) + [
            'is_required' => $request->boolean('is_required'),
        ]);

        return redirect()->route('checklist-templates.show', $checklistTemplate)
            ->with('success', 'Checklist item added.');
    }

    public function destroyItem(ChecklistTemplate $checklistTemplate, ChecklistTemplateItem $item)
    {
        if ($item->checklist_template_id === $checklistTemplate->id) {
            $item->delete();
        }

        return redirect()->route('checklist-templates.show', $checklistTemplate)
            ->with('success', 'Checklist item deleted.');
    }
}
