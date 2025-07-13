<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <x-layouts.auth-header title="Lehati" description="Enter your OTP" icon="aloevera"/>
    {{-- Body --}}
    <form wire:submit="otp" class="max-w-sm mx-auto">
        <div class="flex justify-center mb-2 space-x-2 rtl:space-x-reverse">
            <div>
                <label for="code-1" class="sr-only">First code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-next="code-2" id="code-1" class="block w-11 h-11 py-3 text-md font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-2" class="sr-only">Second code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-1" data-focus-input-next="code-3" id="code-2" class="block w-11 h-11 py-3 text-md font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-3" class="sr-only">Third code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-2" data-focus-input-next="code-4" id="code-3" class="block w-11 h-11 py-3 text-md font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-4" class="sr-only">Fourth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-3" data-focus-input-next="code-5" id="code-4" class="block w-11 h-11 py-3 text-md font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-5" class="sr-only">Fifth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-4" data-focus-input-next="code-6" id="code-5" class="block w-11 h-11 py-3 text-md font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-6" class="sr-only">Sixth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-5" id="code-6" class="block w-11 h-11 py-3 text-md font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
        </div>
        <p id="helper-text-explanation" class="my-2 text-sm text-gray-500 dark:text-gray-400">Please introduce the 6 digit code we sent via email.</p>
        <x-button.btn type="submit" class="w-full" color="blue">Submit</x-button.btn>
    </form>

    <div class="mt-10 text-sm text-center font-medium text-gray-500 dark:text-gray-300">
        Didn't receive the code?<x-button.accorlink href="{{ url('resend-otp') }}" color="blue">Resend OTP</x-button.accorlink>
    </div>
</div>

<script>
// use this simple function to automatically focus on the next input
function focusNextInput(el, prevId, nextId) {
    if (el.value.length === 0) {
        if (prevId) {
            document.getElementById(prevId).focus();
        }
    } else {
        if (nextId) {
            document.getElementById(nextId).focus();
        }
    }
}

document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
    element.addEventListener('keyup', function() {
        const prevId = this.getAttribute('data-focus-input-prev');
        const nextId = this.getAttribute('data-focus-input-next');
        focusNextInput(this, prevId, nextId);
    });
    
// Handle paste event to split the pasted code into each input
    element.addEventListener('paste', function(event) {
        event.preventDefault();
        const pasteData = (event.clipboardData || window.clipboardData).getData('text');
        const digits = pasteData.replace(/\D/g, ''); // Only take numbers from the pasted data

        // Get all input fields
        const inputs = document.querySelectorAll('[data-focus-input-init]');
        
        // Iterate over the inputs and assign values from the pasted string
        inputs.forEach((input, index) => {
            if (digits[index]) {
                input.value = digits[index];
                // Focus the next input after filling the current one
                const nextId = input.getAttribute('data-focus-input-next');
                if (nextId) {
                    document.getElementById(nextId).focus();
                }
            }
        });
    });
});
</script>

