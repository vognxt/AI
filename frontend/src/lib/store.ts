import { create } from 'zustand';
import { User, Property, SearchFilters, GeoLocation } from '@/types';

interface AppState {
  // User state
  user: User | null;
  setUser: (user: User | null) => void;
  
  // Location state
  userLocation: GeoLocation | null;
  setUserLocation: (location: GeoLocation | null) => void;
  
  // Search state
  searchFilters: SearchFilters;
  setSearchFilters: (filters: SearchFilters) => void;
  resetSearchFilters: () => void;
  
  // Saved properties
  savedProperties: string[];
  toggleSavedProperty: (propertyId: string) => void;
  
  // Comparison
  compareProperties: Property[];
  addToCompare: (property: Property) => void;
  removeFromCompare: (propertyId: string) => void;
  clearCompare: () => void;
}

const defaultFilters: SearchFilters = {
  query: '',
  type: [],
  priceRange: { min: 0, max: 100000000 },
  bedrooms: [],
  sortBy: 'date-desc',
};

export const useAppStore = create<AppState>((set) => ({
  // User
  user: null,
  setUser: (user) => set({ user }),
  
  // Location
  userLocation: null,
  setUserLocation: (location) => set({ userLocation: location }),
  
  // Search
  searchFilters: defaultFilters,
  setSearchFilters: (filters) => set({ searchFilters: filters }),
  resetSearchFilters: () => set({ searchFilters: defaultFilters }),
  
  // Saved properties
  savedProperties: [],
  toggleSavedProperty: (propertyId) =>
    set((state) => ({
      savedProperties: state.savedProperties.includes(propertyId)
        ? state.savedProperties.filter((id) => id !== propertyId)
        : [...state.savedProperties, propertyId],
    })),
  
  // Comparison
  compareProperties: [],
  addToCompare: (property) =>
    set((state) => {
      if (state.compareProperties.length >= 3) {
        return state; // Max 3 properties
      }
      if (state.compareProperties.find((p) => p.id === property.id)) {
        return state; // Already in compare
      }
      return { compareProperties: [...state.compareProperties, property] };
    }),
  removeFromCompare: (propertyId) =>
    set((state) => ({
      compareProperties: state.compareProperties.filter((p) => p.id !== propertyId),
    })),
  clearCompare: () => set({ compareProperties: [] }),
}));
