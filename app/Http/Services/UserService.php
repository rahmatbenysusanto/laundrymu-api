<?php

namespace App\Http\Services;

use App\Http\Repository\DiskonRepository;
use App\Http\Repository\LisensiRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PembayaranOutletRepository;
use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\PengirimanRepository;
use App\Http\Repository\StatusTransaksiHasTokoRepository;
use App\Http\Repository\TokoRepository;
use App\Http\Repository\TransaksiHasTokoRepository;
use App\Http\Repository\UserHasTokoRepository;
use App\Http\Repository\UserRepository;
use App\Mail\LupaPassword;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AuthService $authService,
        protected TokoRepository $tokoRepository,
        protected ParfumRepository $parfumRepository,
        protected PembayaranRepository $pembayaranRepository,
        protected DiskonRepository $diskonRepository,
        protected PengirimanRepository $pengirimanRepository,
        protected UserHasTokoRepository $userHasTokoRepository,
        protected StatusTransaksiHasTokoRepository $statusTransaksiHasTokoRepository,
        protected TransaksiHasTokoRepository $transaksiHasTokoRepository,
        protected PembayaranOutletRepository $pembayaranOutletRepository,
        protected LisensiRepository $lisensiRepository,
        protected NotificationService $notificationService
    ){}

    public function create($request): void
    {
        if ($this->userRepository->findByEmail($request->email) != null) {
            abort(400, 'Email sudah pernah digunakan');
        }

        if ($this->userRepository->findByNoHp($request->no_hp) != null) {
            abort(400, 'No HP sudah pernah digunakan');
        }
        $otp = rand(1000, 9999);
        $user = $this->userRepository->create([
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password, ['rounds' => 12]),
            'status'    => 'inactive',
            'otp'       => $otp,
        ]);

        // Create Toko
        $toko = $this->tokoRepository->create([
            "user_id"   => $user->id,
            "nama"      => $request->post("outlet"),
            "no_hp"     => $request->post("no_hp"),
            "logo"      => 'default.png',
            "status"    => "active",
            "expired"   => date('Y-m-d H:i:s', strtotime('+1 months')),
            "alamat"    => '',
            "provinsi"  => '',
            "kabupaten" => '',
            "kecamatan" => '',
            "kelurahan" => '',
            "kode_pos"  => '',
            "lat"       => '',
            "long"      => ''
        ]);

        // Create Default Value
        $this->diskonRepository->create([
            'toko_id'   => $toko->id,
            'nama'      => 'tidak ada diskon',
            'type'      => 'nominal',
            'nominal'   => 0
        ]);

        $this->parfumRepository->create([
            'toko_id'   => $toko->id,
            'nama'      => 'standar',
            'harga'     => 0
        ]);

        $this->pembayaranRepository->create([
            'toko_id'   => $toko->id,
            'nama'      => 'tunai',
        ]);

        $this->pengirimanRepository->create([
            'toko_id'   => $toko->id,
            'nama'      => 'Ambil antar sendiri',
            'harga'     => 0
        ]);

        $this->statusTransaksiHasTokoRepository->create([
            'toko_id'   => $toko->id,
            'baru'      => 0,
            'diproses'  => 0,
            'selesai'   => 0
        ]);

        $this->transaksiHasTokoRepository->create([
            'toko_id'           => $toko->id,
            'jumlah_transaksi'  => 0,
            'nominal_transaksi' => 0,
            'waktu'             => date('Y-m-d H:i:s', time())
        ]);

$message = "Hallo ".$request->post('nama').", terimakasih telah mendaftar di aplikasi LaundryMu. :)

Silahkan melakukan login dan masukan kode OTP berikut ini untuk menyelesaikan proses pendaftaran Anda.

*".$otp."*

Harap jangan infokan kode OTP ini kepada siapapun.

Terima kasih.

*Laundrymu*";
        $this->notificationService->whatsAppNotification($request->post("no_hp"), $message);
    }

    public function login($request)
    {
        $credentials = $request->only('no_hp', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->find($request->no_hp);
            $issuedAt   = new DateTimeImmutable();
            $payload = [
                'iss' => 'laundrymu-api',
                'aud' => $user->email,
                'iat' => $issuedAt->getTimestamp(),
                'nbf' => $issuedAt->getTimestamp(),
                'data'=> [
                    'id'    => $user->id,
                    'email' => $user->email,
                    'role'  => $user->role
                ]
            ];

            $token = $this->authService->generateTokenJWT($payload);

            return [
                'token' => $token,
                'type'  => 'bearer',
                'id'    => $user->id,
                'nama'  => $user->nama,
                'no_hp' => $user->no_hp,
                'role'  => $user->role,
                'status'=> $user->status
            ];
        } else {
            abort(400, "Login Gagal, silahkan cek no hp atau password anda");
        }
    }

    public function generateNewToken($user_id): array
    {
        $user = $this->userRepository->findById($user_id);

        $issuedAt   = new DateTimeImmutable();
        $payload = [
            'iss' => 'laundrymu-api',
            'aud' => $user->email,
            'iat' => $issuedAt->getTimestamp(),
            'nbf' => $issuedAt->getTimestamp(),
            'data'=> [
                'id'    => $user->id,
                'email' => $user->email,
                'role'  => $user->role
            ]
        ];

        return [
            'user'  => [
                'id'    => $user->id,
                'nama'  => $user->nama,
                'no_hp' => $user->no_hp,
                'role'  => $user->role,
                'status'=> $user->status
            ],
            'token' => $this->authService->generateTokenJWT($payload)
        ];
    }

    public function verifikasiOTP($user_id, $otp): void
    {
        $user = $this->userRepository->findById($user_id);

        if ($user->otp == $otp) {
            $this->userRepository->update($user_id, [
                'status'    => 'active'
            ]);
        } else {
            abort(400, 'Kode OTP salah');
        }
    }

    public function generateNewOTP($user_id): void
    {
        $otp = rand(1000, 9999);
        $this->userRepository->update($user_id, [
           'otp'    => $otp
        ]);

        $user = $this->userRepository->findById($user_id);

        $message = "Hallo ".$user->nama." ini kode OTP yang terbaru

*".$otp."*.

Harap jangan infokan kode OTP ini kepada siapapun.

Terima kasih.

*Laundrymu*";
        $this->notificationService->whatsAppNotification($user->no_hp, $message);
    }

    public function lupaPassword($email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user == null) {
            abort(400, "User tidak terdaftar");
        }

        $otp = rand(1000, 9999);
        $this->userRepository->update($user->id, [
            "otp"  => $otp,
        ]);

        $dataMail = [
            "subject"   => "Lupa Password Laundrymu",
            "title"     => "Permintaan Pergantian Sandi",
            "text"      => "Hallo pelanggan Laundrymu, anda baru saya mengajukan lupa password pada sistem kami, silahkan tekan tombol dibawah untuk melanjutkan proses ganti password anda yang baru. Jika anda tidak merasa mengajukan ganti password harap hiraukan email ini dan segera laporkan kepada amin Laundrymu, Terimakasih",
            "link"      => "https://mobile.laundrymu.id/lupa-password/".base64_encode($user->email),
            "otp"       => $otp
        ];

        Mail::to($user->email)->send(new LupaPassword($dataMail));
    }

    public function checkValidateEmail($email): void
    {
        $result = $this->userRepository->findByEmail(base64_decode($email));
        if ($result == null) {
            abort(400, "User tidak ditemukan");
        }
    }

    public function gantiPassword($request): void
    {
        $user = $this->userRepository->findByEmail($request->email);
        if ($user->otp != $request->otp) {
            abort(400, "OTP tidak sesuai, Silahkan cek kode OTP anda");
        }

        $this->userRepository->update($user->id, [
            "password"  => Hash::make($request->password, ['rounds' => 12]),
        ]);

        $message = "Hallo ".$user->nama.", Kata sandi anda berhasil diperbarui, Silahkan login dengan sandi anda yang baru";
        $this->notificationService->whatsAppNotification($user->no_hp, $message);
    }

    public function getAllUser()
    {
        return $this->userRepository->getAll();
    }
}
