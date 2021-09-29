<div>

    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fas fa-edit"></i>
    </a>

    <x-jet-dialog-modal wire:model="open">

        <x-slot name="title">
            Editar post <span class="font-bold">{{$post->title}}</span>
        </x-slot>

        <x-slot name="content">
            <div wire:loading wire:target="post.image" class="mb-4 w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen cargando!</strong>
                <span class="block sm:inline">Espere un momento.</span>
            </div>

            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
            @else
                <img src="{{Storage::url($post->image)}}" alt="">
            @endif

            <div class="mb-4">
                <x-jet-label value="Título"></x-jet-label>
                <x-jet-input wire:model="post.title" type="text" class="w-full"></x-jet-input>
            </div>
            <div>
                <x-jet-label value="Contenido"></x-jet-label>
                <textarea wire:model="post.content" class="form-control w-full" rows="6"></textarea>
            </div>
            <div>
                <input type="file" wire:model="image" id="{{ $identificador }}">
                <x-jet-input-error for="image"></x-jet-input-error>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" class="disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>

</div>
