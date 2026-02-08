<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultationController extends Controller
{
    /**
     * Kirim form konsultasi ke email (gloriouscompt@gmail.com).
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'required|email',
            'service' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        $to = config('app.consultation_email', 'gloriouscompt@gmail.com');
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'service' => $request->service ?: '-',
            'message' => $request->message,
        ];

        try {
            Mail::send('emails.consultation', $data, function ($m) use ($to, $data) {
                $m->to($to)
                    ->subject('Konsultasi dari Website - ' . $data['name']);
                $m->replyTo($data['email'], $data['name']);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan. Silakan coba lagi atau hubungi kami via WhatsApp.');
        }

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Tim kami akan segera menghubungi Anda.');
    }
}
