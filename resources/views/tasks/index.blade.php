 <x-layout-app pageTitle="Home">

     <div class="todo-container">
         <header>
             <h1>Minhas Tarefas</h1>

         </header>
         <form id="form-create" action="{{ route('tasks.store') }}" method="POST" class="todo-form">

             <p>Adicione a sua tarefa:</p>
             <div class="todo-form-control">
                 <input name="title" type="text" placeholder="O que você vai fazer ?">
                 <button class="btn-plus" type="submit">
                     <i class="fa-solid fa-plus" aria-hidden="true"></i>
                 </button>

             </div>
             <div class="errors-message-crud d-block  hide"></div>
             @error('title')
                 <div class="invalid-feedback d-block fade show auto-close">
                     {{ $message }}
                 </div>
             @enderror
             <textarea class="mt-3" name="description" placeholder="Descrição(opcional)"></textarea>


         </form>

         <form method="POST" id="form-edit" class="todo-form hide">

             <p>Edite a sua tarefa:</p>
             <div class="todo-form-control">
                 <input id="edit-title" name="title" type="text" placeholder="O que você vai fazer ?">
                 <button class="btn-check-double" type="submit">
                     <i class="fa-solid fa-check-double" aria-hidden="true"></i>
                 </button>

             </div>
             <div class="errors-message-crud d-block hide"></div>
             @error('title')
                 <div class="invalid-feedback d-block fade show auto-close">
                     {{ $message }}
                 </div>
             @enderror
             <button type="button" id="cancel-edit" class="btn-cancel">Cancelar</button>
         </form>


         <div class="toolbar">
             <div class="search">
                 <h4>Pesquisar:</h4>
                 <div class="search-box">
                     <input id="search-input" type="text" placeholder="Buscar">
                     <button type="button" class="btn-delete-left" id="search-clear">
                         <i class="fa-solid fa-delete-left" aria-hidden="true"></i>
                     </button>

                 </div>

             </div>

             <div class="filter">
                 <h4>Filtrar:</h4>

                 <select id="filter-status">
                     <option value="all">Todos</option>
                     <option value="done">Feitos</option>
                     <option value="todo">A Fazer</option>
                 </select>

             </div>

         </div>
         <div class="todo-list">
             @forelse ($tasks as $task)
                 <div class="todo-item" id="todo-{{ $task->id }}">
                     <span class="{{ $task->is_done ? 'done' : '' }}">
                         {{ $task->title }}

                     </span>

                     <div class="actions">
                         @if (!$task->is_done)
                             <button class="finish-todo" data-id="{{ $task->id }}">
                                 <i class="fa-solid fa-check"></i>
                             </button>
                         @endif

                         <button class="edit-todo" data-id="{{ $task->id }}" data-title="{{ $task->title }}">
                             <i class="fa-solid fa-pen"></i>

                         </button>

                         <button class="remove-todo" data-id="{{ $task->id }}">
                             <i class="fa-solid fa-xmark"></i>
                         </button>

                     </div>

                 </div>
             @empty
             @endforelse

         </div>
     </div>
     <form action="{{ route('logout') }}" method="post" class="dropdown-container">
         @csrf
         <div class="dropdown">
             <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                 aria-expanded="false">

                 <i class="fa-solid fa-bars"></i>
             </button>
             <div class="dropdown-menu">

                 <button type="submit" class="dropdown-item">Sair</button>
             </div>


         </div>
     </form>
 </x-layout-app>
