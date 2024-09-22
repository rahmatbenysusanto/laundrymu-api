<?php

namespace App\Http\Service;

use App\Http\Repository\NotificationRepository;
use App\Http\Repository\OutletRepository;
use App\Http\Repository\PelangganRepository;
use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiRepository;
use App\Http\Repository\WhatsappNotificationRepository;

class NotificationService
{
    public function __construct(
        protected NotificationRepository $notificationRepository,
        protected WhatsappNotificationRepository $whatsappNotificationRepository,
        protected TransaksiRepository $transaksiRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository,
        protected OutletRepository $outletRepository,
        protected PelangganRepository $pelangganRepository,
    ) {}

    public function notification($type, $data): void
    {
        switch ($type) {
            case 'user baru':
                $this->whatsappText($data['no_hp'], $this->waNewUser($data['otp']));
                break;
            case 'transaksi baru':
                $this->whatsappText('62895627637701', $this->waNewOrder($data['transaksi_id']));
                break;
            case 'transaksi selesai':
            case 'transaksi dipickup':
            case 'transaksi delivery':
            case 'pembayaran flip':
                $this->whatsappText($data['no_hp'], $this->pembayaranFlip($data['nama'], $data['link'], $data['no'], $data['tanggal']));
                break;
            case 'pembayaran outlet berhasil':
                $this->whatsappText($data['no_hp'], $this->pembayaranOutletBerhasil($data['nama'], $data['tanggal'], $data['nominal']));
                break;
        }
    }

    private function whatsappText($no_hp, $message): void
    {
        $whatsappNotification = $this->whatsappNotificationRepository->create([
            'no_hp'     => '62895627637701',
            'message'   => 'Testing',
            'status'    => 'failed',
            'created_at' => now()->timestamp * 1000,
            'updated_at' => now()->timestamp * 1000,
        ]);

        $result = $this->notificationRepository->whatsappMessage(preg_replace('/^0/', '62', $no_hp), $message);
        if ($result['message_status'] == 'Success') {
            $this->whatsappNotificationRepository->update($whatsappNotification->id, [
                'status'    => 'success',
                'updated_at' => now()->timestamp * 1000
            ]);
        }
    }

    public function email($mail, $type)
    {

    }

    private function waNewUser($otp): string
    {
        return <<<EOT
        Halo, terima kasih telah menggunakan LaundryMu! 👕✨

        Kode OTP Anda adalah: *{$otp}*

        Kode ini berlaku untuk verifikasi akun Anda. Ingat, kode ini hanya untuk Anda! Jangan bagikan kepada siapa pun, ya.

        Jika Anda tidak meminta kode ini, abaikan pesan ini.

        Selamat menikmati layanan kami! 🚀
        EOT;
    }

    private function waNewOrder($transaksi_id): string
    {
        $transaksi = $this->transaksiRepository->findById($transaksi_id);
        $tanggal = date('d-M-Y H:i:s', strtotime($transaksi->created_at));
        $transaksiDetail = $this->transaksiDetailRepository->findByTransaksiId($transaksi_id);
        $outlet = $this->outletRepository->findById($transaksi->outlet_id);

        $nota = "Hai, ".$transaksi->pelanggan->nama."

Berikut adalah rincian transaksi laundry Anda:

*Nomor Order*: ".$transaksi->order_number."
*Tanggal Terima*: ".date('d-M-Y H:i', $transaksi->created_at / 1000)."

*Rincian Laundry*:
";
        $number = 1;
        foreach ($transaksiDetail as $detail) {
            $tipe = $detail->layanan->type == "berat" ? "KG" : "Pcs";
$nota .=
$number.". *".$detail->layanan->nama."*
   - Jumlah: ".$detail->jumlah." ".$tipe."
   - Harga: Rp ".number_format($detail->harga)."
   - Subtotal: Rp ".number_format($detail->total_harga)."\n";
            $number++;
        }

        $nota .= "
*Harga*: Rp ".number_format($transaksi->harga)."
*Diskon*: Rp ".number_format($transaksi->harga_diskon)."
*Pengiriman*: Rp ".number_format($transaksi->biaya_pengiriman)."
*Total Harga*: Rp ".number_format($transaksi->total_harga)."

*Lokasi*: ".$outlet->nama."

Terima kasih!
        ";

        return $nota;
    }

    private function waTransaksiSelesai($transaksi_id): string
    {
        $transaksi = $this->transaksiRepository->findById($transaksi_id);
        $tanggal = date('d-M-Y H:i:s', strtotime($transaksi->updated_at / 1000));
        $outlet = $this->outletRepository->findById($transaksi->outlet_id);
        $pelanggan = $this->pelangganRepository->findById($transaksi->pelanggan_id);

        return <<<EOT
        🎉 Hai {$pelanggan->nama}!

        Kami sangat senang memberi tahu Anda bahwa laundry Anda sudah selesai dan siap diambil di outlet kami. 💧✨

        Detail Laundry:

        Nomor Order: {$transaksi->order_number}
        Tanggal Selesai: {$tanggal}
        📍 Lokasi Outlet: {$outlet->nama} - {$outlet->alamat}

        Jangan lewatkan kesempatan untuk mengambil laundry Anda dan menikmati hasilnya. Jika Anda memerlukan bantuan lebih lanjut atau memiliki pertanyaan, kami selalu siap membantu!

        Terima kasih telah mempercayakan laundry Anda kepada kami. Sampai jumpa di outlet!

        Salam hangat,
        Tim {$outlet->nama} 🌟
        EOT;
    }

    private function pembayaranFlip($nama, $link, $no, $tanggal): string
    {
        return <<<EOT
        Halo {$nama},

        Terima kasih telah menggunakan layanan LaundryMu! Untuk menyelesaikan transaksi, silakan klik link di bawah ini untuk melakukan pembayaran:

        🔗 {$link}

        Nomor pesanan Anda: {$no}

        Pastikan Anda menyelesaikan pembayaran sebelum {$tanggal} agar pesanan Anda dapat segera kami proses.

        Jika ada pertanyaan, jangan ragu untuk menghubungi kami.

        Salam,
        Tim LaundryMu
        📞: +62 xxx-xxx-xxxx
        🌐: www.laundrymu.com
        EOT;
    }

    private function pembayaranOutletBerhasil($nama, $tanggal, $nominal): string
    {
        return <<< EOT
        Halo {$nama}! 🙌

        Kami dengan senang hati mengonfirmasi bahwa pembayaran lisensi aplikasi LaundryMu kamu telah BERHASIL! 🎉

        🗓 Tanggal Pembayaran: {$tanggal} WIB
        💳 Jumlah Dibayar: {$nominal}

        Lisensi aplikasi kamu sudah aktif dan siap digunakan untuk memaksimalkan manajemen laundry! Terima kasih telah mempercayakan LaundryMu sebagai partner bisnis anda.

        Jika ada pertanyaan atau bantuan yang diperlukan, tim kami siap membantu! 😊

        Selamat menjalankan bisnis!
        LaundryMu Team
        📧 laundrymukasir@gmail.com
        🌐 www.laundrymu.com
        EOT;
    }
}
