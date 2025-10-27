// User Types
export type UserRole = 'buyer' | 'vendor' | 'developer' | 'admin';

export interface User {
  id: string;
  email: string;
  name: string;
  phone: string;
  role: UserRole;
  avatar?: string;
  location?: {
    city: string;
    state: string;
    pincode: string;
    country: string;
  };
  createdAt: string;
  verified: boolean;
}

// Property Types
export type PropertyType = 'apartment' | 'villa' | 'plot' | 'commercial' | 'penthouse' | 'studio';
export type PropertyStatus = 'available' | 'sold' | 'rented' | 'under-construction';
export type ListingType = 'sale' | 'rent';

export interface Property {
  id: string;
  title: string;
  description: string;
  type: PropertyType;
  listingType: ListingType;
  status: PropertyStatus;
  price: number;
  area: number; // in sq ft
  bedrooms: number;
  bathrooms: number;
  location: {
    address: string;
    city: string;
    state: string;
    pincode: string;
    latitude?: number;
    longitude?: number;
  };
  amenities: string[];
  images: string[];
  features: {
    parking: boolean;
    furnished: boolean;
    powerBackup: boolean;
    lift: boolean;
    security: boolean;
    gym: boolean;
    swimmingPool: boolean;
    garden: boolean;
    clubhouse: boolean;
  };
  developer?: {
    id: string;
    name: string;
    logo?: string;
  };
  vendor?: {
    id: string;
    name: string;
    phone: string;
  };
  views: number;
  inquiries: number;
  createdAt: string;
  updatedAt: string;
  featured: boolean;
  verified: boolean;
  source?: 'magicbricks' | '99acres' | 'direct';
}

// Project Types (for Developers)
export interface Project {
  id: string;
  name: string;
  description: string;
  developer: {
    id: string;
    name: string;
    logo?: string;
  };
  location: {
    address: string;
    city: string;
    state: string;
    pincode: string;
  };
  totalUnits: number;
  availableUnits: number;
  priceRange: {
    min: number;
    max: number;
  };
  possession: string;
  status: 'upcoming' | 'ongoing' | 'completed';
  amenities: string[];
  images: string[];
  reraNumber?: string;
  createdAt: string;
  featured: boolean;
}

// Lead Types
export interface Lead {
  id: string;
  propertyId: string;
  userId: string;
  userName: string;
  userEmail: string;
  userPhone: string;
  message: string;
  status: 'new' | 'contacted' | 'qualified' | 'converted' | 'lost';
  createdAt: string;
  assignedTo?: string;
}

// Analytics Types
export interface Analytics {
  views: number;
  inquiries: number;
  conversions: number;
  revenue: number;
  period: 'today' | 'week' | 'month' | 'year';
}

// Dashboard Stats
export interface DashboardStats {
  totalProperties?: number;
  totalLeads?: number;
  totalRevenue?: number;
  activeListings?: number;
  savedProperties?: number;
  recentViews?: number;
  conversionRate?: number;
  avgResponseTime?: string;
}

// Search Filters
export interface SearchFilters {
  query?: string;
  type?: PropertyType[];
  listingType?: ListingType;
  priceRange?: {
    min: number;
    max: number;
  };
  bedrooms?: number[];
  location?: string;
  pincode?: string;
  amenities?: string[];
  featured?: boolean;
  sortBy?: 'price-asc' | 'price-desc' | 'date-desc' | 'date-asc' | 'popular';
}

// API Response Types
export interface ApiResponse<T> {
  success: boolean;
  data?: T;
  error?: string;
  message?: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  total: number;
  page: number;
  pageSize: number;
  totalPages: number;
}

// Geolocation Types
export interface GeoLocation {
  ip: string;
  city: string;
  state: string;
  country: string;
  pincode: string;
  latitude: number;
  longitude: number;
}
