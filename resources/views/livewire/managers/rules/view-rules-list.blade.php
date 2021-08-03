<div x-data class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-full w-11/12">
    <div
        class="flex flex-col items-center border border-2 border-white rounded-lg p-3 bg-gradient-to-b from-indigo-300 to-indigo-400 ">
        <div class="w-11/12">
            <table class="w-11/12">
                <thead class="text-white font-semibold ">
                    <tr class="">
                        <td class="pr-8 pb-4 ">Name</td>
                        <td class="pr-4 pb-4 text-center">Active</td>
                        <td class="pr-2 pb-4 text-right">%</td>

                    </tr>
                </thead>

                {{-- Will have it generate one of these table rows for every rule in the db --}}
                <tbody class="text-white ">
                    
                    <tr class="border-b border-white ">
                        <td class="pr-2 pb-2 ">Holidays</td>
                        <td class="pr-4 pb-2 text-center">Yes</td>
                        <td class="pb-2 text-center">100</td>
                    </tr>
                    <tr class="">
                        <td class="py-3"></td>
                    </tr>

                    <tr class="border-b border-white ">
                        <td class="pr-2 pb-2">Public Holidays</td>
                        <td class="pr-4 pb-2 text-center">No</td>
                        <td class="pb-2 text-center">50</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        <div class="flex justify-center mt-8 mb-4 text-xl">
            <button @click="$dispatch('custom-new-rule-modal')"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white pb-1">New
                Rule</button>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>