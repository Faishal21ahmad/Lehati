<div class="px-6 pt-2 md:p-8 md:ml-64 text-black dark:text-white">
    <x-layouts.app-header :title="__('Account')" :description="__('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellat, dolorem.')" />
    
    <section id="userAccount" class="w-full lg:w-[70%] mt-4 gap-2 flex flex-col lg:flex-row">
        {{-- {{ $account }} --}}
        <div class="w-full lg:w-1/5">
            <h1 class="text-xl font-semibold">Account</h1>
        </div>
        <div class="lg:max-w-[80%] w-full">
            <form wire:submit="updateAccount">
                <x-input.input type="text" id="codeUser" label="Code User" placeholder="code user" required error="{{ $errors->first('codeUser') }}"/>
                <x-input.input type="text" id="name" label="Username" placeholder="Freya" required error="{{ $errors->first('name') }}"/>
                <x-input.input type="email" id="email" label="Email" placeholder="Freya" required error="{{ $errors->first('email') }}"/>
                <x-input.input type="text" id="role" label="Role" placeholder="Freya" required error="{{ $errors->first('role') }}"/>
                {{-- <x-input.input type="text" id="status" label="status" placeholder="Freya" required error="{{ $errors->first('status') }}"/> --}}
                <x-input.radio-group title="Status" name="status"
                    :options="[
                        ['value' => 1, 'label' => 'Active'],
                        ['value' => 0, 'label' => 'Inactive']
                    ]"
                    wire:model="status"
                    error="{{ $errors->first('status') }}"
                />
                <x-input.datepicker id="verified" label="Email Verified" error="{{ $errors->first('verified') }}" value="{{ old('verified', $verified) }}"/>
                <x-button.btn type="submit" color="blue">Save</x-button.btn>
            </form>
        </div>

    </section>

    <hr class="my-4 border-gray-300 dark:border-gray-600">

    <section id="userDataAccount" class="w-full lg:w-[70%] mt-4 gap-2 flex flex-col lg:flex-row">
        {{-- {{ $userdata }} --}}
        <div class="w-full lg:w-1/5">
            <h1 class="text-xl font-semibold">Data User Account</h1>
        </div>
        <div class="lg:max-w-[80%] w-full">
            <form wire:submit="updateDataAccount">
                <x-input.input type="number" id="phone" label="Phone" placeholder="08xx" required error="{{ $errors->first('phone') }}"/>
                <x-input.input type="text" id="address" label="Address" placeholder="jln. melati - Kec - Kab - PROV - Code Pos" required error="{{ $errors->first('name') }}"/>
                <x-input.input type="number" id="nik" label="NIK" placeholder="0000 - 00 - 0000 - 00" required error="{{ $errors->first('nik') }}"/>
                {{-- <x-input.input type="number" id="nik" label="Username" placeholder="0000 - 00 - 0000 - 00" required error="{{ $errors->first('nik') }}"/> --}}
                <x-input.radio-group title="Gender" name="gender"
                    :options="[
                        ['value' => 'female', 'label' => 'Female'],
                        ['value' => 'male', 'label' => 'Male']
                    ]"
                    wire:model="gender"
                    error="{{ $errors->first('gender') }}"
                />
                <x-input.input id="bank" label="Bank" placeholder="BRI" required error="{{ $errors->first('bank') }}"/>
                <x-input.input id="bank_name" label="Username Bank" placeholder="Freya" required error="{{ $errors->first('bank_name') }}"/>
                <x-input.input id="bank_number" label="Account Number" placeholder="08xx" required error="{{ $errors->first('bank_number') }}"/>

                <x-button.btn type="submit" color="blue">Save</x-button.btn>
            </form>
        </div>
    </section>
</div>