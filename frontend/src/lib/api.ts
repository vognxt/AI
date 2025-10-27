import axios from 'axios';
import { Property, User, Lead, Project, ApiResponse, PaginatedResponse, SearchFilters } from '@/types';

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Add auth token to requests
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Properties API
export const propertiesApi = {
  getAll: async (filters?: SearchFilters, page = 1, pageSize = 12) => {
    const response = await api.get<PaginatedResponse<Property>>('/properties', {
      params: { ...filters, page, pageSize },
    });
    return response.data;
  },
  
  getById: async (id: string) => {
    const response = await api.get<ApiResponse<Property>>(`/properties/${id}`);
    return response.data;
  },
  
  create: async (property: Partial<Property>) => {
    const response = await api.post<ApiResponse<Property>>('/properties', property);
    return response.data;
  },
  
  update: async (id: string, property: Partial<Property>) => {
    const response = await api.put<ApiResponse<Property>>(`/properties/${id}`, property);
    return response.data;
  },
  
  delete: async (id: string) => {
    const response = await api.delete<ApiResponse<void>>(`/properties/${id}`);
    return response.data;
  },
  
  getFeatured: async () => {
    const response = await api.get<ApiResponse<Property[]>>('/properties/featured');
    return response.data;
  },
};

// Users API
export const usersApi = {
  login: async (email: string, password: string) => {
    const response = await api.post<ApiResponse<{ user: User; token: string }>>('/auth/login', {
      email,
      password,
    });
    return response.data;
  },
  
  register: async (userData: Partial<User> & { password: string }) => {
    const response = await api.post<ApiResponse<{ user: User; token: string }>>('/auth/register', userData);
    return response.data;
  },
  
  getProfile: async () => {
    const response = await api.get<ApiResponse<User>>('/auth/profile');
    return response.data;
  },
  
  updateProfile: async (userData: Partial<User>) => {
    const response = await api.put<ApiResponse<User>>('/auth/profile', userData);
    return response.data;
  },
};

// Leads API
export const leadsApi = {
  create: async (lead: Partial<Lead>) => {
    const response = await api.post<ApiResponse<Lead>>('/leads', lead);
    return response.data;
  },
  
  getAll: async (page = 1, pageSize = 20) => {
    const response = await api.get<PaginatedResponse<Lead>>('/leads', {
      params: { page, pageSize },
    });
    return response.data;
  },
  
  updateStatus: async (id: string, status: Lead['status']) => {
    const response = await api.patch<ApiResponse<Lead>>(`/leads/${id}/status`, { status });
    return response.data;
  },
};

// Projects API
export const projectsApi = {
  getAll: async (page = 1, pageSize = 12) => {
    const response = await api.get<PaginatedResponse<Project>>('/projects', {
      params: { page, pageSize },
    });
    return response.data;
  },
  
  getById: async (id: string) => {
    const response = await api.get<ApiResponse<Project>>(`/projects/${id}`);
    return response.data;
  },
  
  create: async (project: Partial<Project>) => {
    const response = await api.post<ApiResponse<Project>>('/projects', project);
    return response.data;
  },
};

// Geolocation API
export const geoApi = {
  getLocation: async () => {
    const response = await api.get('/geo/location');
    return response.data;
  },
};

// Analytics API
export const analyticsApi = {
  getDashboardStats: async (role: string) => {
    const response = await api.get(`/analytics/dashboard/${role}`);
    return response.data;
  },
  
  trackView: async (propertyId: string) => {
    await api.post(`/analytics/view/${propertyId}`);
  },
};

export default api;
