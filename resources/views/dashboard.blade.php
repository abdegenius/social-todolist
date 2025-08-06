@extends('layouts.app')

@section('content')
<div>
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="text-xl font-bold text-stone-600 flex items-center">
                        <i class="fas fa-list-check mr-2"></i>
                        SocialTodo
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="#dashboard" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 bg-blue-50">Dashboard</a>
                    <a href="#todo" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-stone-600">My Todos</a>
                    <a href="#invitations" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-stone-600">Invitations</a>
                </div>

                <div class="flex items-center">
                    <div class="ml-3 relative">
                        <div class="flex items-center cursor-pointer" id="user-menu">
                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name=John+Doe&background=3B82F6&color=fff" alt="User">
                            <span class="ml-2 text-gray-700 text-sm font-medium">John Doe</span>
                            <i class="fas fa-chevron-down ml-2 text-gray-500 text-xs"></i>
                        </div>

                        <div id="user-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-10">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <a href="#" onclick="auth.logout()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="hidden md:block w-64 bg-white h-screen border-r pt-5">
            <div class="px-4">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">MAIN NAVIGATION</h3>
                <nav class="space-y-1">
                    <a href="#dashboard" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-stone-600 bg-blue-50">
                        <i class="fas fa-chart-pie mr-3 text-stone-600"></i>
                        Dashboard
                    </a>
                    <a href="#todo" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-stone-600 hover:bg-gray-50">
                        <i class="fas fa-list-check mr-3 text-gray-500"></i>
                        My Todo Lists
                    </a>
                    <a href="#invitations" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-stone-600 hover:bg-gray-50">
                        <i class="fas fa-envelope mr-3 text-gray-500"></i>
                        Invitations
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-stone-600 hover:bg-gray-50">
                        <i class="fas fa-cog mr-3 text-gray-500"></i>
                        Settings
                    </a>
                </nav>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6">
            <!-- Dashboard Section -->
            <section id="dashboard" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                    <!-- <button class="bg-stone-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> New Todo List
                    </button> -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" x-data="dashboardSummary()" x-init="loadSummary()">
                    <!-- Stats Card 1 -->
                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-stone-600">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-600">Total Lists</h3>
                                <p class="text-3xl font-bold mt-2"><span x-text="data.total_accessible_todos"></span></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-list-check text-stone-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 2 -->
                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-secondary">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-600">Completed</h3>
                                <p class="text-3xl font-bold mt-2"><span x-text="data.completed_items"></span></p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i class="fas fa-check-circle text-secondary text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 3 -->
                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-600">Pending</h3>
                                <p class="text-3xl font-bold mt-2"><span x-text="data.pending_items"></span></p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <i class="fas fa-clock text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                    </div>

                </div>

            </section>

            <!-- Todo Lists Section -->
            <section id="todo" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">My Todo Lists</h2>
                    <!-- <div class="flex space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Search lists..." class="border rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-stone-600">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="bg-stone-600 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> New List
                        </button>
                    </div> -->
                </div>

                <div x-data="newTodo()" class="flex items-center space-x-4 p-2 mb-6 w-full">
                    <input
                        type="text"
                        x-model="title"
                        placeholder="Enter todo list title"
                        class="w-full border px-4 py-2 rounded-md focus:outline-none">

                    <button
                        @click="create"
                        :disabled="loading"
                        class="bg-stone-600 text-white px-4 py-2 rounded-lg flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-plus mr-2"></i>
                        <span x-show="!loading">New </span>
                        <span x-show="loading">Creating...</span>
                    </button>
                </div>


                <div x-data="todoList()" x-init="loadTodos()" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="todo in todos" :key="todo.id">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-5">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-lg text-gray-800" x-text="todo.title"></h3>
                                    <button class="text-gray-500 hover:text-red-500" @click="deleteTodo(todo.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <template x-if="todo.items">
                                    <p class="text-gray-600 text-sm mt-1" x-text="`${todo.items.length ?? 0} tasks, ${todo.items.filter(i => i.status == '1').length ?? 0} completed`"></p>
                                </template>

                                <template x-if="todo.items">
                                    <div class="mt-4">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-600">Progress</span>
                                            <span class="text-sm font-medium text-gray-600"
                                                x-text="`${todo.items.length > 0 ? Math.round((todo.items.filter(i => i.status == '1').length / todo.items.length) * 100) : 0}%`"></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-stone-600 h-2 rounded-full"
                                                :style="`width: ${todo.items.length > 0 ? Math.round((todo.items.filter(i => i.status == '1').length / todo.items.length) * 100) : 0}%`"></div>
                                        </div>
                                    </div>
                                </template>

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex -space-x-2">
                                        <template x-for="access in todo.accesses" :key="access.id">
                                            <img class="w-8 h-8 rounded-full border-2 border-white"
                                                :src="`https://ui-avatars.com/api/?name=${access.user.username}&background=3B82F6&color=fff`"
                                                alt="">
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-5 flex gap-3">
                                    <button @click="addItem(todo.id)"
                                        class="bg-stone-600 text-white text-sm px-3 py-1 rounded hover:bg-stone-700">
                                        + Add Item
                                    </button>
                                    <button @click="inviteUser(todo.id)"
                                        class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700">
                                        + Invite User
                                    </button>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-5 py-3 border-t">
                                <div class="flex justify-end">
                                    <a :href="`/todos/${todo.id}`" class="text-stone-600 text-sm font-medium">
                                        View Details <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            </section>

            <!-- Invitations Section -->
            <section id="invitations" class="mb-12" x-data="invitationList()" x-init="loadInvitations()">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Invitations</h2>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="border-b">
                        <ul class="flex border-b">
                            <li class="mr-1">
                                <a class="bg-white inline-block py-4 px-6 text-stone-600 font-semibold border-b-2 border-stone-600">
                                    Pending (<span x-text="pendingCount"></span>)
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="p-6 space-y-4">
                        <template x-for="invite in invitations" :key="invite.id">
                            <div class="flex items-center justify-between py-4 border-b">
                                <div class="flex items-center">
                                    <img class="w-10 h-10 rounded-full object-cover mr-4"
                                        :src="`https://ui-avatars.com/api/?name=${invite.todo.user.name}&background=3B82F6&color=fff`"
                                        :alt="invite.todo.user.name">
                                    <div>
                                        <h4 class="font-medium text-gray-800" x-text="invite.todo.user.name"></h4>
                                        <p class="text-sm text-gray-600">
                                            Invited to collaborate on
                                            <span class="font-medium" x-text="invite.todo.title"></span>
                                        </p>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-500" x-text="timeAgo(invite.created_at)"></div>

                                <template x-if="invite.status == '0'">
                                    <div class="flex space-x-2">
                                        <button @click="respond(invite, '1')"
                                            class="bg-green-100 text-green-800 px-4 py-2 rounded-lg flex items-center">
                                            <i class="fas fa-check mr-2"></i> Accept
                                        </button>
                                        <button @click="respond(invite, '2')"
                                            class="bg-red-100 text-red-800 px-4 py-2 rounded-lg flex items-center">
                                            <i class="fas fa-times mr-2"></i> Reject
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="invitations.length === 0">
                            <p class="text-sm text-gray-500 text-center py-6">No pending invitations.</p>
                        </template>
                    </div>
                </div>
            </section>

        </div>
    </div>

</div>
@endsection