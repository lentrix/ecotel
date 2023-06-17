<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-addon-item-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-addon-item-wrapper">

    <div class="bg-green-100 w-[1100px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="add-addon-item-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="add-addon">
            <i class="fa fa-close"></i>
        </button>

        <div class="flex justify-between align-center">
            <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add Addon Item</h2>
            <form class="flex" id="filter_addon_form">
                <input type="text" id="filter_text" />
                <button class="bg-gray-200 border border-gray-400 rounded-sm px-2 h-[40px]">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <div>&nbsp;</div>
        </div>

        <div class="overflow-auto max-h-[70vh] border">
            {!! Form::open(['url'=>'/bookings/add-on/' . $booking->id,'method'=>'post','id'=>'submit_addon_form']) !!}
                    <input type="hidden" id="addon_id" name="addon_id" />
                    <input type="hidden" name="qty" id="addon_qty" value="1" min="1">
            {!! Form::close() !!}
            <div class="grid grid-cols-3 gap-5 mt-4" id="addons_result">



                {{-- @foreach($addons as $addon)
                    <div class="bg-white border border-green-500 p-2 rounded-md shadow flex flex-col">
                        <h2 class="text-xl">{{$addon->name}}</h2>
                        <div class="italic">{{$addon->description}}</div>
                        <div class="flex-1 flex flex-col justify-end">
                            <div class="flex justify-between">
                                <h4 class="text-xl font-bold">
                                    <i class="fa-solid fa-peso-sign"></i>
                                    {{number_format($addon->amount)}}
                                </h4>
                                <div>
                                    {!! Form::open(['url'=>'/bookings/add-on/' . $booking->id,'method'=>'post']) !!}
                                        <input type="hidden" name="addon_id" value="{{$addon->id}}">
                                        <input type="number" name="qty" value="1" min="1" class='w-[70px] p-0 text-center'>
                                        <button class="primary" type="submit">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach --}}



            </div>
        </div>

    </div>

</div>
