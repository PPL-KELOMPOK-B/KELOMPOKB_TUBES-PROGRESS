<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi milik user yang sedang login.
     */
    public function index()
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadCount = $notifications->where('is_read', false)->count();

        return view('petugas.notifikasi', compact('notifications', 'unreadCount'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markAsRead($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        if ($notification->laporan_id) {
            return redirect()->route('petugas.show_laporan', ['id' => $notification->laporan_id, 'from' => 'notifikasi']);
        }

        return redirect()->route('petugas.notifikasi');
    }

    /**
     * Tandai semua notifikasi user sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->route('petugas.notifikasi')
            ->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * Helper statis: Buat notifikasi perubahan status laporan.
     * Dipanggil dari controller lain saat status laporan berubah.
     */
    public static function createStatusNotification($laporan, $newStatus)
    {
        $kode = 'R' . str_pad($laporan->id, 3, '0', STR_PAD_LEFT);
        $desa = $laporan->kelurahan ?? $laporan->kecamatan ?? '-';

        $statusLabels = [
            'menunggu_validasi' => 'menunggu validasi',
            'proses'            => 'sudah divalidasi dan sedang diproses',
            'diterima'          => 'telah diterima',
            'ditolak'           => 'ditolak',
            'selesai'           => 'telah selesai ditangani',
        ];

        $label = $statusLabels[$newStatus] ?? $newStatus;
        $title = "Laporan {$kode} - Desa {$desa} {$label}";

        Notification::create([
            'user_id'    => $laporan->user_id,
            'laporan_id' => $laporan->id,
            'title'      => $title,
            'message'    => "Status laporan {$kode} telah berubah menjadi: {$label}.",
            'status'     => $newStatus,
            'is_read'    => false,
        ]);
    }
}
