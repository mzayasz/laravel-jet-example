<div wire:init="loadPosts">

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            M ZAYAS
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <x-table>

            <div class="px-6 py-4 flex items-center">
                <!--<input type="text" wire:model="search">-->

                <div class="flex items-center">
                    <span>Mostrar</span>
                    <select class="mx-2 form-control" wire:model="count">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entradas</span>
                </div>

                <x-jet-input class="flex-1 mx-4" type="text" placeholder="Busqueda" :disabled="false"
                    wire:model="search"></x-jet-input>

                @livewire('create-post')
            </div>

            @if (count($posts))
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th wire:click="order('id')" scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                ID
                                <!-- sort -->
                                @if ($sort == 'id')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right"></i>
                                @endif
                            </th>
                            <th wire:click="order('title')" scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Title

                                <!-- sort -->
                                @if ($sort == 'title')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right"></i>
                                @endif
                            </th>
                            <th wire:click="order('content')" scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Content
                                <!-- sort -->
                                @if ($sort == 'content')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right"></i>
                                @endif
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->title }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->content }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium flex">
                                    <a class="btn btn-green" wire:click="edit({{ $item }})">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a class="btn btn-red ml-2" wire:click="$emit('deletePost', {{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        <!-- More people... -->
                    </tbody>
                </table>

                @if ($posts->hasPages())
                    <div class="px-6 py-3">
                        {{ $posts->links() }}
                    </div>
                @endif

            @else
                <div class="px-6 py-4">
                    No existe ningún registro
                </div>
            @endif

        </x-table>

    </div>

    <!-- MODAL PARA EDITAR LOS POSTS -->
    <x-jet-dialog-modal wire:model="open_edit">
        <x-slot name="title">
            Editar post <span class="font-bold">{{ $post->title }}</span>
        </x-slot>
        <x-slot name="content">
            <div wire:loading wire:target="post.image"
                class="mb-4 w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Imagen cargando!</strong>
                <span class="block sm:inline">Espere un momento.</span>
            </div>

            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
            @else
                <img src="{{ Storage::url($post->image) }}" alt="">
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
            <x-jet-secondary-button wire:click="$set('open_edit', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" class="disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            Livewire.on('deletePost', postId => {
                Swal.fire({
                    title: 'Estás seguro?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('show-posts', 'delete', postId);

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })
        </script>
    @endpush


</div>
