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

    public function mount($codetransaksi = null)
    {
        $this->transaksi = Transaction::where('code_transaksi', $codetransaksi)->first();
        if (!$this->transaksi) {
            abort(404, 'Transaksi not found');
        }
        $this->imagepayprof = $this->transaksi->payment_proof ?? null;
    }

    // Upload Bukti Pembayaran
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

    // Verfikasi Pembayaran oleh Admin
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

            $product = $this->transaksi->bid->room->product;
            $status = $this->status === 'approve' ? 'success' : 'failed';
            $productStatus = $this->status === 'approve' ? 'sold' : 'available';

            Product::updateOrCreate(
                ['id' => $product->id],
                ['status' => $productStatus]
            );

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

            $this->redirectIntended(default: route('transaction.detail', $this->transaksi->code_transaksi, absolute: false));

            DB::commit();
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
