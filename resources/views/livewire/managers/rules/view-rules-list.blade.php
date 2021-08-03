{{-- Have this as absolute right now just for testing --}}
<div x-data class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-full w-11/12">
    <div
        class="flex flex-col items-center border border-2 border-white rounded-lg p-3 bg-gradient-to-b from-indigo-300 to-indigo-400 max-h-60">

        {{-- Rule List Headings --}}
        <div class="w-11/12 mb-2">
            <table class="w-11/12">
                <tr class="text-white ">
                    <td class="pr-2">Name</td>
                    <td class="text-center">Active</td>
                    <td class="text-right">%</td>
                </tr>
                </tbody>
            </table>
        </div>

        {{-- Rule list --}}
        <div class="w-11/12 overflow-scroll max-h-60">
            <table class="w-11/12">
                @foreach ($rules as $rule )
                <tr class="border-b border-white text-white ">
                    <td class="pr-2">{{ $rule->rule_name }}</td>
                    <td class="pr-4  ">{{ $rule->active }}</td>
                    <td class="text-right">{{ $rule->percentage }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- New Rule Button --}}
        <div class="flex justify-center mt-3 text-xl">
            <button @click="$dispatch('custom-new-rule-modal')"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">New
                Rule</button>
        </div>

    </div>
</div>

{{-- Alpine JS Script --}}
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>