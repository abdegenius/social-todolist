import axios from "axios";
import Alpine from "alpinejs";

import toastr from "toastr";
import "toastr/build/toastr.min.css";
// ---------------------------
// Axios API Client Setup
// ---------------------------
const api = axios.create({
    baseURL: "/api",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

api.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// ---------------------------
// Auth Module
// ---------------------------
const auth = {
    token: null,
    user: {},

    init() {
        this.token = localStorage.getItem("token");
        this.user = JSON.parse(localStorage.getItem("user")) || {};
        this.setupAxios();
    },

    setupAxios() {
        axios.defaults.baseURL = "/api";
        axios.interceptors.request.use((config) => {
            if (this.token) {
                config.headers.Authorization = `Bearer ${this.token}`;
            }
            return config;
        });
    },

    async login(email, password) {
        try {
            const response = await api.post("/login", { email, password });
            localStorage.setItem("token", response.data.token);
            localStorage.setItem("user", JSON.stringify(response.data.user));
            this.token = response.data.token;
            this.user = response.data.user;
            return response.data.user;
        } catch (error) {
            throw error.response?.data?.error || "Login failed";
        }
    },

    async register(payload) {
        try {
            const response = await api.post("/register", payload);
            localStorage.setItem("token", response.data.token);
            localStorage.setItem("user", JSON.stringify(response.data.user));
            this.token = response.data.token;
            this.user = response.data.user;
            return response.data.user;
        } catch (error) {
            throw error.response?.data?.errors || "Registration failed";
        }
    },

    logout() {
        this.token = null;
        this.user = {};
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        window.location.href = "/login";
    },

    getCurrentUser() {
        return this.user;
    },

    isAuthenticated() {
        return this.token !== null;
    },
};

// ---------------------------
// User Module (API Calls)
// ---------------------------
const user = {
    async getTodoLists() {
        try {
            const response = await api.get("/todos");
            return response.data;
        } catch (error) {
            console.error("Failed to fetch todo lists:", error);
            return [];
        }
    },

    async createTodoList(title) {
        try {
            const response = await api.post("/todos", { title });
            return response.data;
        } catch (error) {
            console.error("Failed to create todo list:", error);
            throw error;
        }
    },

    async getTodoList(id) {
        try {
            const response = await api.get(`/todos/${id}`);
            return response.data;
        } catch (error) {
            console.error("Failed to fetch todo list:", error);
            return null;
        }
    },

    async updateTodoList(id, data) {
        try {
            const response = await api.put(`/todos/${id}`, data);
            return response.data;
        } catch (error) {
            console.error("Failed to update todo list:", error);
            throw error;
        }
    },

    async deleteTodoList(id) {
        try {
            await api.delete(`/todos/${id}`);
            return true;
        } catch (error) {
            console.error("Failed to delete todo list:", error);
            return false;
        }
    },

    async createTodoItem(todoId, content) {
        try {
            const response = await api.post(`/todos/${todoId}/items`, {
                content,
            });
            return response.data;
        } catch (error) {
            console.error("Failed to create todo item:", error);
            throw error;
        }
    },

    async updateTodoItem(id, data) {
        try {
            const response = await api.put(`/items/${id}`, data);
            return response.data;
        } catch (error) {
            console.error("Failed to update todo item:", error);
            throw error;
        }
    },

    async deleteTodoItem(id) {
        try {
            await api.delete(`/items/${id}`);
            return true;
        } catch (error) {
            console.error("Failed to delete todo item:", error);
            return false;
        }
    },

    async getInvitations() {
        try {
            const response = await api.get("/invitations");
            return response.data;
        } catch (error) {
            console.error("Failed to fetch invitations:", error);
            return [];
        }
    },

    async sendInvitation(todoId, username) {
        try {
            const response = await api.post(`/todos/${todoId}/invite`, {
                username,
            });
            return response.data;
        } catch (error) {
            console.error("Failed to send invitation:", error);
            throw error;
        }
    },

    async respondToInvitation(invitationId, status) {
        try {
            const response = await api.put(`/invitations/${invitationId}`, {
                status,
            });
            return response.data;
        } catch (error) {
            console.error("Failed to respond to invitation:", error);
            throw error;
        }
    },

    async getDashboardSummary() {
        try {
            const response = await api.get("/dashboard-summary");
            return response.data;
        } catch (error) {
            console.error("Failed to fetch dashboard summary:", error);
            return [];
        }
    },
};

// ---------------------------
// Alpine Components
// ---------------------------
window.dashboardSummary = () => {
    return {
        loading: true,
        data: {
            total_accessible_todos: 0,
            completed_items: 0,
            pending_items: 0,
        },
        async loadSummary() {
            try {
                this.data = await user.getDashboardSummary();
            } catch (error) {
                console.error("Error loading dashboard summary:", error);
            } finally {
                this.loading = false;
            }
        },
    };
};

window.todoList = () => {
    return {
        loading: true,
        todos: [],

        async loadTodos() {
            try {
                const response = await api.get("/todos");
                this.todos = response.data;
            } catch (error) {
                console.error("Failed to load todos:", error);
            } finally {
                this.loading = false;
            }
        },

        async addItem(todoId) {
            const content = prompt("Enter new item content:");
            if (!content) return;
            try {
                const response = await api.post(`/todos/${todoId}/items`, {
                    content,
                });
                const todo = this.todos.find((t) => t.id === todoId);
                todo.items.push(response.data);
            } catch (error) {
                toastr.error("Failed to add item.");
                console.error(error);
            }
        },

        async inviteUser(todoId) {
            const username = prompt("Enter username to invite:");
            if (!username) return;
            try {
                await api.post(`/todos/${todoId}/invite`, { username });
                toastr.success("User invited successfully.");
            } catch (error) {
                toastr.error("Failed to invite user.");
                console.error(error);
            }
        },

        async deleteTodo(todoId) {
            if (!confirm("Are you sure you want to delete this todo?")) return;
            try {
                await api.delete(`/todos/${todoId}`);
                this.todos = this.todos.filter((t) => t.id !== todoId);
            } catch (error) {
                toastr.error("Failed to delete todo.");
                console.error(error);
            }
        },
    };
};

window.newTodo = () => {
    return {
        title: "",
        loading: false,
        async create() {
            if (!this.title.trim()) {
                return toastr.info("Please enter a title");
            }

            try {
                this.loading = true;
                const response = await api.post("/todos", {
                    title: this.title,
                });

                this.title = "";
                toastr.success("Todo list created!");
            } catch (error) {
                console.error(error);
                toastr.error(
                    error?.response?.data?.message ||
                        "Failed to create todo list."
                );
            } finally {
                this.loading = false;
            }
        },
    };
};

window.invitationList = () => {
    return {
        invitations: [],
        pendingCount: 0,

        async loadInvitations() {
            try {
                const res = await api.get("/invitations");
                this.invitations = res.data;
                this.updatePendingCount();
            } catch (error) {
                toastr.error("Failed to load invitations.");
                console.error(error);
            }
        },

        async respond(invite, status) {
            const action = status === 1 ? "accept" : "reject";
            if (!confirm(`Are you sure you want to ${action} this invitation?`))
                return;

            try {
                await api.put(`/accesses/${invite.id}`, {
                    status: status,
                });
                invite.status = String(status);
                this.updatePendingCount();
                toastr.success(`Invitation ${action}ed successfully.`);
            } catch (error) {
                console.error(error);
                toastr.error("Something went wrong.");
            }
        },

        updatePendingCount() {
            this.pendingCount = this.invitations.filter(
                (i) => i.status === "0"
            ).length;
        },

        timeAgo(dateString) {
            const date = new Date(dateString);
            const seconds = Math.floor((new Date() - date) / 1000);

            const intervals = {
                year: 31536000,
                month: 2592000,
                week: 604800,
                day: 86400,
                hour: 3600,
                minute: 60,
                second: 1,
            };

            for (const [unit, secondsInUnit] of Object.entries(intervals)) {
                const interval = Math.floor(seconds / secondsInUnit);
                if (interval > 1) return `${interval} ${unit}s ago`;
                if (interval === 1) return `1 ${unit} ago`;
            }

            return "just now";
        },
    };
};

// ---------------------------
// DOM Ready Bootstrap
// ---------------------------
document.addEventListener("DOMContentLoaded", () => {
    auth.init();

    const userMenu = document.getElementById("user-menu");
    const userDropdown = document.getElementById("user-dropdown");

    if (userMenu && userDropdown) {
        userMenu.addEventListener("click", () => {
            userDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", (event) => {
            if (
                !userMenu.contains(event.target) &&
                !userDropdown.contains(event.target)
            ) {
                userDropdown.classList.add("hidden");
            }
        });
    }

    console.log("App initialized");
});

// ---------------------------
// Alpine & Globals
// ---------------------------
window.Alpine = Alpine;
Alpine.start();
window.axios = axios;
window.auth = auth;
window.user = user;
window.toastr = toastr;
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "3000",
    showDuration: "300",
    hideDuration: "1000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
};
