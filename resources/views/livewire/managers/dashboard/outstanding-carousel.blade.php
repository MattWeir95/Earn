<div x-data="{index: 0,total: {{ $total }}, commissionApprovals:{{ $commissionApprovals }}}"
    class="main-div-height p-4 pt-2 text-base bg-gradient-to-b from-indigo-300 to-indigo-400 rounded-xl shadow-xl text-white relative">
    <commission-approval class="text-black p-12 m-6 rounded-xl bg-white flex flex-col items-center justify-center">
        <div class=" text-5xl items-center flex flex-col pb-10 sm: text-base pb-4"
            x-text="commissionApprovals[index].name">
        </div>
        <div class=" text-2xl items-center flex flex-col md:text-4xl lg:text-4xl"
            x-text="`$${parseFloat(commissionApprovals[index].totalCommission).toFixed(2)}`">

        </div>
        <div class=" text-1xl items-center flex flex-col pt-10 sm: text-sm sm: pt-2">
            Active Period:
        </div>
        <div class="grid grid-cols-2">
            <div class=" text-1xl items-center flex flex-col pt-10 sm: text-sm pt-2 mr-6"
                x-text="commissionApprovals[index].start_time">
            </div>
            <div class="text-1xl items-center flex flex-col pt-10 sm: text-sm pt-2 ml-6"
                x-text="commissionApprovals[index].end_time">
            </div>
        </div>
    </commission-approval>
    <div class="absolute inset-0 flex">
        <div class="flex items-center justify-start w-1/2">
            <button class="bg-white text-indigo-500 font-bold hover:shadow-lg rounded-full w-12 h-12 -ml-6"
                x-on:click="index = index === 0 ? total - 1 : index - 1">
                &#8592;
            </button>
        </div>
        <div class="flex items-center justify-end w-1/2">
            <button class="bg-white text-indigo-500 font-bold hover:shadow-lg rounded-full w-12 h-12 -mr-6"
                x-on:click="index = index === total - 1 ? 0 : index + 1">
                &#8594;
            </button>
        </div>
    </div>
    <div class="flex flex-1 justify-around mt-6">
        <button @click="$wire.approve(commissionApprovals[index].id)" 
            class="text-white border border-white rounded-lg mx-1 w-28 transform hover:bg-indigo-500 hover:text-white">Approve</button>
        <button @click="$wire.flag(commissionApprovals[index].id)"
            class="text-white border border-white rounded-lg mx-1 w-28 transform hover:bg-indigo-500 hover:text-white">Flag</button>
    </div>
</div>
