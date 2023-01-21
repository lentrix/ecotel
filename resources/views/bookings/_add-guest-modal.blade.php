<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-guest-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-guest-wrapper">

    <div class="bg-green-100 w-[650px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="add-guest-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="add-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add Guest</h2>

        <div class="overflow-auto max-h-[70vh]">
            <div class="mt-3 items-start flex space-x-2">
                <input type="text" id="search_last_name" class="flex-1" autocomplete="off" placeholder="Last Name">
                <input type="text" id="search_first_name" class="flex-1" autocomplete="off" placeholder="First Name">
                <button class="secondary" id="searchGuest">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <ul id="searchGuestResults">

            </ul>
        </div>

    </div>

</div>
