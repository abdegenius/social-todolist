@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="hidden md:block w-64 bg-white h-screen border-r pt-5">
        <div class="px-4">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">MAIN NAVIGATION</h3>
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-stone-600 hover:bg-gray-50">
                    <i class="fas fa-chart-pie mr-3 text-gray-500"></i>
                    Dashboard
                </a>
                <a href="{{ route('dashboard') }}#todos" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-stone-600 bg-blue-50">
                    <i class="fas fa-list-check mr-3 text-stone-600"></i>
                    My Todo Lists
                </a>
                <a href="{{ route('dashboard') }}#invitations" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-stone-600 hover:bg-gray-50">
                    <i class="fas fa-envelope mr-3 text-gray-500"></i>
                    Invitations
                </a>
            </nav>
        </div>
    </div>

    <!-- Content Area -->
    <div class="flex-1 p-6">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}#todos" class="inline-flex items-center text-stone-600 hover:text-stone-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to My Todos
            </a>
        </div>

        <!-- Todo Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800" id="todo-title">{{ $todo->title }}</h1>
                    <p class="text-gray-600 mt-1">Created: {{ $todo->created_at->format('M d, Y') }}</p>
                </div>
                
            </div>
            
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Collaborators</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($todo->accesses as $access)
                    <div class="flex items-center bg-gray-100 rounded-full px-3 py-1">
                        <img class="w-8 h-8 rounded-full mr-2" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($access->user->name) }}&background=3B82F6&color=fff" 
                             alt="{{ $access->user->name }}">
                        <span class="text-sm text-gray-700">{{ $access->user->name }}</span>
                        @if($access->status == '1')
                            <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Accepted</span>
                        @else
                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Pending</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Todo Items Section -->
        <div class="bg-white rounded-xl shadow-md p-6" x-data="todoItems()" x-init="init({{ $todo->id }})">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Todo Items</h2>
                <button @click="showAddItemModal = true" class="bg-stone-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Item
                </button>
            </div>
            
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-600">Progress</span>
                    <span class="text-sm font-medium text-gray-600" x-text="`${progress}%`"></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-stone-600 h-3 rounded-full" :style="`width: ${progress}%`"></div>
                </div>
            </div>
            
            <!-- Items List -->
            <div class="space-y-4">
                <template x-for="item in items" :key="item.id">
                    <div class="flex items-start p-4 border rounded-lg hover:bg-gray-50">
                        <div class="mr-4 mt-1">
                            <input 
                                type="checkbox" 
                                class="h-5 w-5 text-stone-600 rounded focus:ring-stone-500"
                                :checked="item.status == '1'"
                                @change="toggleStatus(item)"
                            >
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-800" x-text="item.content"></h3>
                                    <div class="flex items-center mt-1 text-sm text-gray-500">
                                        <img class="w-6 h-6 rounded-full mr-2" 
                                             :src="`https://ui-avatars.com/api/?name=${item.user.name}&background=3B82F6&color=fff`" 
                                             :alt="item.user.name">
                                        <span x-text="item.user.name"></span>
                                        <span class="mx-2">•</span>
                                        <span x-text="new Date(item.created_at).toLocaleDateString()"></span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button @click="openEditItemModal(item)" class="text-gray-500 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteItem(item.id)" class="text-gray-500 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                
                <template x-if="items.length === 0">
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">No items yet. Add your first todo item!</p>
                    </div>
                </template>
            </div>
            
            <!-- Add Item Modal -->
            <div x-show="showAddItemModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="showAddItemModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Add New Item</h3>
                        <button @click="showAddItemModal = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form @submit.prevent="addItem">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="item-content">Content</label>
                            <textarea 
                                id="item-content" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-stone-600 focus:border-transparent" 
                                rows="3"
                                placeholder="What needs to be done?"
                                x-model="newItem.content"
                                required
                            ></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                type="button" 
                                @click="showAddItemModal = false" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="bg-stone-600 text-white px-4 py-2 rounded-lg hover:bg-stone-700 transition"
                                :disabled="isAdding"
                            >
                                <template x-if="isAdding">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                </template>
                                Add Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Edit Item Modal -->
            <div x-show="showEditItemModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="showEditItemModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Edit Item</h3>
                        <button @click="showEditItemModal = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form @submit.prevent="updateItem">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="edit-item-content">Content</label>
                            <textarea 
                                id="edit-item-content" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-stone-600 focus:border-transparent" 
                                rows="3"
                                x-model="editingItem.content"
                                required
                            ></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="edit-item-status">Status</label>
                            <select 
                                id="edit-item-status" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-stone-600 focus:border-transparent" 
                                x-model="editingItem.status"
                            >
                                <option value="0">Pending</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                type="button" 
                                @click="showEditItemModal = false" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="bg-stone-600 text-white px-4 py-2 rounded-lg hover:bg-stone-700 transition"
                                :disabled="isUpdating"
                            >
                                <template x-if="isUpdating">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                </template>
                                Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
    </div>
</div>

<script>
    const todoItems = () => {
        return {
            todo_id: '{{ $todo->id }}',
            items: @json($todo->items),
            showAddItemModal: false,
            showEditItemModal: false,
            newItem: {
                content: '',
                todo_id: '{{ $todo->id }}',
            },
            editingItem: {
                id: null,
                content: '',
                status: '0'
            },
            isAdding: false,
            isUpdating: false,
            
            get progress() {
                const completed = this.items.filter(item => item.status == '1').length;
                return this.items.length ? Math.round((completed / this.items.length) * 100) : 0;
            },
            
            init(todoId) {
                // Initialize any necessary data
            },
            
            async addItem() {
                this.isAdding = true;
                
                console.log(this.todo_id)
                try {
                    const response = await axios.post(`/todos/${this.todo_id}/items`, {
                        content: this.newItem.content
                    });
                    
                    this.items.push(response.data);
                    this.showAddItemModal = false;
                    this.newItem.content = '';
                    
                    // Show success message
                    showToast('Item added successfully!', 'success');
                } catch (error) {
                    console.error('Failed to add item:', error);
                    showToast('Failed to add item. Please try again.', 'error');
                } finally {
                    this.isAdding = false;
                }
            },
            
            openEditItemModal(item) {
                this.editingItem = {...item};
                this.showEditItemModal = true;
            },
            
            async updateItem() {
                this.isUpdating = true;
                
                try {
                    const response = await axios.put(`/items/${this.editingItem.id}`, {
                        content: this.editingItem.content,
                        status: this.editingItem.status
                    });
                    
                    // Update the item in the list
                    const index = this.items.findIndex(i => i.id === this.editingItem.id);
                    if (index !== -1) {
                        this.items[index] = response.data;
                    }
                    
                    this.showEditItemModal = false;
                    
                    // Show success message
                    showToast('Item updated successfully!', 'success');
                } catch (error) {
                    console.error('Failed to update item:', error);
                    showToast('Failed to update item. Please try again.', 'error');
                } finally {
                    this.isUpdating = false;
                }
            },
            
            async toggleStatus(item) {
                try {
                    const newStatus = item.status == '1' ? '0' : '1';
                    const response = await axios.put(`/items/${item.id}`, {
                        status: newStatus,
                        content: item.content
                    });
                    
                    // Update the item in the list
                    const index = this.items.findIndex(i => i.id === item.id);
                    if (index !== -1) {
                        this.items[index] = response.data;
                    }
                    
                    // Show success message
                    showToast('Status updated!', 'success');
                } catch (error) {
                    console.error('Failed to toggle status:', error);
                    showToast('Failed to update status. Please try again.', 'error');
                    // Revert the checkbox state
                    item.status = item.status == '1' ? '0' : '1';
                }
            },
            
            async deleteItem(itemId) {
                if (!confirm('Are you sure you want to delete this item?')) return;
                
                try {
                    await axios.delete(`/items/${itemId}`);
                    
                    // Remove the item from the list
                    this.items = this.items.filter(item => item.id !== itemId);
                    
                    // Show success message
                    showToast('Item deleted successfully!', 'success');
                } catch (error) {
                    console.error('Failed to delete item:', error);
                    showToast('Failed to delete item. Please try again.', 'error');
                }
            }
        }
    }
    
    function showToast(message, type = 'success') {
        alert(`${type === 'success' ? '✓' : '⚠'} ${message}`);
    }
</script>
@endsection