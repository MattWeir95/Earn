<div>
    <div
        class="flex flex-col items-center  p-3 rounded-xl shadow-xl bg-gradient-to-b from-indigo-300 to-indigo-400 min-h-full ">

        @if($rules->isEmpty())
        <table class="w-full">
            {{-- Rule List Headings --}}
            <tr class="text-white font-bold ">
                <td class="">Name</td>
                <td class="text-right">Active</td>
                <td class="text-right">%</td>
            </tr>
            <tr class="border-b border-white text-white">
                <td>No Active Rules</td>
            </tr>
        </table>

        @endif
        @if(!$rules->isEmpty())
        {{-- Rule list --}}
        <div x-data class="w-full  overflow-y-auto max-h-60 pr-3">

            <table id="table" class="w-full" x-data="{selectedRule: ''}">
                {{-- Rule List Headings --}}
                <tr class="text-white font-bold ">
                    <td class="">Name</td>
                    <td class="text-right">Active</td>
                    <td class="text-right">%</td>
                </tr>
                {{-- Rules --}}
                @foreach ($rules as $rule )

                {{-- Name --}}
                <tr  tabindex="1" class="border-b border-white text-white cursor-pointer"
                    :class="selectedRule == {{ $rule->id }} ? 'font-bold' : ''"
                    @click="$dispatch('custom-sendrule', {message: {{ $rule }}}); selectedRule='{{ $rule->id }}'; ">
                    <td>{{ $rule->rule_name }}

                    </td>
                    <td class="flex justify-end mr-3 mt-1 ">

                        {{-- Return a active or inactive SVG --}}
                        @if($rule->active)
                        <svg wire:click="toggleActive('{{ $rule }}')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="text-green-200 ml-4 bi bi-check-circle transform hover:scale-125" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                        </svg>
                        @else
                        <svg wire:click="toggleActive('{{ $rule }}')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="ml-4 text-red-400 bi bi-x-circle transform hover:scale-125" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </td>

                    @endif

                    {{-- Percentage --}}
                    <td class="text-right ">{{ $rule->percentage }}</td>

                </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        @endif
        {{-- New Rule Button --}}
        <div x-data class="mt-3 text-xl">
            <button @click="$dispatch('custom-new-rule-modal')"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500">New
                Rule</button>
        </div>

    </div>
</div>