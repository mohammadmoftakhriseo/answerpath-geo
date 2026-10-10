<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $leads = Lead::all();
        $this->render('admin/leads/index', [
            'title' => 'مدیریت لیدها، درخواست‌ها و بریف‌های سئو',
            'leads' => $leads,
        ], 'admin/layouts/admin');
    }

    public function show(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $lead = Lead::findById($id);

        if (!$lead) {
            $response->redirect('/admin/leads?error=notfound');
            return;
        }

        $this->render('admin/leads/show', [
            'title' => 'مشاهده جزییات لید: ' . ($lead['full_name'] ?? 'بی‌نام'),
            'lead'  => $lead,
        ], 'admin/layouts/admin');
    }

    public function updateStatus(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $status = (string)$request->input('status', 'contacted');
        $notes = (string)$request->input('admin_notes', '');

        Lead::updateStatus($id, $status, $notes);
        $response->redirect('/admin/leads/' . $id . '?status=updated');
    }

    public function delete(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        Lead::delete($id);
        $response->redirect('/admin/leads?status=deleted');
    }
}
