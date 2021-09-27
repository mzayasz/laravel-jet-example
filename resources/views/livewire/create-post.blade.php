<div>

    <x-jet-danger-button wire:click="$set('open', true)">
        Crear nuevo post
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">

        <x-slot name="title">Crear nuevo post</x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Título"></x-jet-label>
                <x-jet-input type="text" class="w-full" wire:model="title"></x-jet-input>
                <x-jet-input-error for="title"></x-jet-input-error>
            </div>
            <div class="mb-4">
                <x-jet-label value="Contenido"></x-jet-label>
                <textarea class="form-control w-full" cols="30" rows="6" wire:model="content"></textarea>
                <x-jet-input-error for="content"></x-jet-input-error>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save">
                Crear
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
