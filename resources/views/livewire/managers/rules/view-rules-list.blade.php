
{{-- Have this as absolute right now just for testing --}}
{{-- absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-full  --}}
<div x-data class="">
    <div
        class="flex flex-col items-center border border-2 border-white p-3 rounded-lg bg-gradient-to-b from-indigo-300 to-indigo-400 max-h-60 md:max-h-full">

        @if(!$rules->isEmpty())
        

        {{-- Rule list --}}
        <div class="w-11/12 overflow-scroll max-h-60 md:max-h-full">

            <table class="w-11/12">
                {{-- Rule List Headings --}}
                <tr class="text-white ">
                    <td class="">Name</td>
                    <td class="text-center pr-5">Active</td>
                    <td class="text-right">%</td>
                </tr>
                {{-- Rules --}}
                @foreach ($rules as $rule )
                <tr  class="border-b border-white text-white">
                    <td  class=""><button class="font-bold">{{ $rule->rule_name }}</button></td>
                    <td class="text-center pr-5">{{ $rule->active ? 'Yes' : 'No' }}</td>
                    <td class="text-right">{{ $rule->percentage }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
        {{-- New Rule Button --}}
        <div class="mt-3 text-xl">
            <button @click="$dispatch('custom-new-rule-modal')"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">New
                Rule</button>
        </div>

    </div>
</div>


