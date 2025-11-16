<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Make New Waste Collection Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

                <form method="POST" action="{{ route('requests.store') }}" class="space-y-6">
                    @csrf

                    <!-- Card Header -->
                    <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 border-b pb-3 mb-6">
                        Collection Details
                    </h3>

                    <!-- Waste Type -->
                    <div>
                        <x-input-label for="waste_type" :value="__('Type of Waste')" />
                        <select id="waste_type" name="waste_type" required autofocus 
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Waste Category</option>
                            <option value="Household">Household (General)</option>
                            <option value="Recyclable">Recyclable (Paper/Card/Metal)</option>
                            <option value="Plastic">Plastic Bottles/Containers</option>
                            <option value="E-Waste">E-Waste (Batteries/Small Electronics)</option>
                            <option value="Yard-Waste">Yard Waste (Branches/Leaves)</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('waste_type')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantity -->
                        <div>
                            <x-input-label for="quantity" :value="__('Estimated Quantity')" />
                            <select id="quantity" name="quantity" required 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select Size</option>
                                <option value="Small">Small (1-2 Bags)</option>
                                <option value="Medium">Medium (3-5 Bags/Bin)</option>
                                <option value="Large">Large (Multiple Bins/Piles)</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>
                        
                        <!-- Scheduled Time -->
                        <div>
                            <x-input-label for="scheduled_time" :value="__('Preferred Collection Time')" />
                            <x-text-input id="scheduled_time" name="scheduled_time" type="datetime-local" class="mt-1 block w-full" :value="old('scheduled_time')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('scheduled_time')" />
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <x-input-label for="address" :value="__('Collection Address')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="Auth::user()->address ?? old('address')" required autocomplete="street-address" placeholder="Enter your full street address here" />
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            The latitude and longitude fields will be automatically calculated later, but the address is essential.
                        </p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <x-input-label for="notes" :value="__('Special Notes / Instructions')" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>
                            {{ __('Submit Collection Request') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
