<?php

namespace App\Livewire\Transaction;

use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.app',  ['title' => "Transaction"])]
class TransactionForm extends Component
{
    use WithFileUploads;
    public $transaksi, $codetransaksi, $filepayment, $imagepayprof, $notes, $status;

    // Load inisialisasi data transaksi
    public function mount($codetransaksi = null)
    {
        // Load data transaksi berdasarkan code transaksi
        $this->transaksi = Transaction::where('code_transaksi', $codetransaksi)->first();
        // Jika data transaksi tidak ditemukan, tampilkan halaman 404
        if (!$this->transaksi) {
            abort(404, 'Transaksi not found');
        }
        // Inisialisasi bukti transaksi dari data transaksi
        $this->imagepayprof = $this->transaksi->payment_proof ?? null;
    }

    // action Upload Bukti Pembayaran
    public function paymenproof()
    {   // validasi input bukti pembayaran
        $this->validate([
            'filepayment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // max dalam KB (2048 KB = 2 MB)
        ], [
            'filepayment.required' => 'Bukti pembayaran wajib diunggah.',
            'filepayment.file'     => 'File tidak valid.',
            'filepayment.mimes'    => 'Format file harus berupa JPG, PNG, atau PDF.',
            'filepayment.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            DB::beginTransaction();
            // Jika ada file bukti pembayaran yang diunggah
            if (!empty($this->filepayment)) {
                // Simpan Image ke storage 
                $path = $this->filepayment->store('payproof', 'public');
                // update data transaksi 
                Transaction::updateOrCreate([
                    'code_transaksi' => $this->transaksi->code_transaksi
                ], [
                    'payment_proof' => $path,
                    'status' => 'payment-verification'
                ]);
            }

            session()->flash('toast', [ // triger notifikasi 
                'id' => uniqid(),
                'message' => __('Upload Transaction successful'),
                'type' => 'success',
                'duration' => 5000
            ]);

            $this->redirectIntended(default: route('transaction.detail', $this->transaksi->code_transaksi, absolute: false));
            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Upload failed',
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
        }
    }

    // action Verfikasi Pembayaran oleh Admin
    public function paymenVerification()
    {   // validasi input verfikasi pembayaran 
        $this->validate([
            'status' => 'required',
            'notes' => 'nullable|string',
        ], [
            'status.required' => 'Status wajib diisi!',
            'notes.string' => 'Notes string'
        ]);

        try {
            DB::beginTransaction();
            // load data product dari transaksi 
            $product = $this->transaksi->bid->room->product;
            $status = $this->status === 'approve' ? 'success' : 'failed';
            $productStatus = $this->status === 'approve' ? 'sold' : 'available';

            // update status product dan transaksi
            Product::updateOrCreate(
                ['id' => $product->id],
                ['status' => $productStatus]
            );

            // update data transaksi 
            Transaction::updateOrCreate([
                'code_transaksi' => $this->transaksi->code_transaksi
            ], [
                'status' => $status,
                'notes' => $this->notes,
                'payment_verified_at' => now(),
            ]);

            session()->flash('toast', [ // triger notifikasi 
                'id' => uniqid(),
                'message' => __('Verification successful'),
                'type' => 'success',
                'duration' => 5000
            ]);
            // direct ke halaman detail transaksi
            $this->redirectIntended(default: route('transaction.detail', $this->transaksi->code_transaksi, absolute: false));

            DB::commit();

            // jika data gagal di proses tampilkan pesan error 
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->dispatch( // triger notifikasi 
                'showToast',
                message: 'Verification failed',
                type: 'error', // 'error', 'success' ,'info'
                duration: 5000
            );
        }
    }

    public function render()
    {
        return view('livewire.transaction.transaction-form');
    }
}
