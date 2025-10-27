import { Property } from '@/types';

export function formatPrice(price: number): string {
  if (price >= 10000000) {
    return `₹${(price / 10000000).toFixed(2)} Cr`;
  } else if (price >= 100000) {
    return `₹${(price / 100000).toFixed(2)} Lac`;
  } else if (price >= 1000) {
    return `₹${(price / 1000).toFixed(2)} K`;
  }
  return `₹${price}`;
}

export function formatArea(area: number): string {
  return `${area.toLocaleString()} sq ft`;
}

export function calculateEMI(principal: number, ratePercent: number, tenureYears: number): number {
  const monthlyRate = ratePercent / 12 / 100;
  const tenureMonths = tenureYears * 12;
  
  if (monthlyRate === 0) return principal / tenureMonths;
  
  const emi = (principal * monthlyRate * Math.pow(1 + monthlyRate, tenureMonths)) /
    (Math.pow(1 + monthlyRate, tenureMonths) - 1);
  
  return Math.round(emi);
}

export function getPropertyTypeLabel(type: Property['type']): string {
  const labels: Record<Property['type'], string> = {
    apartment: 'Apartment',
    villa: 'Villa',
    plot: 'Plot',
    commercial: 'Commercial',
    penthouse: 'Penthouse',
    studio: 'Studio',
  };
  return labels[type] || type;
}

export function getPropertyStatusBadge(status: Property['status']): {
  label: string;
  color: string;
} {
  const badges: Record<Property['status'], { label: string; color: string }> = {
    available: { label: 'Available', color: 'bg-green-100 text-green-800' },
    sold: { label: 'Sold', color: 'bg-red-100 text-red-800' },
    rented: { label: 'Rented', color: 'bg-blue-100 text-blue-800' },
    'under-construction': { label: 'Under Construction', color: 'bg-yellow-100 text-yellow-800' },
  };
  return badges[status] || { label: status, color: 'bg-gray-100 text-gray-800' };
}

export function truncateText(text: string, maxLength: number): string {
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + '...';
}

export function getTimeAgo(dateString: string): string {
  const date = new Date(dateString);
  const now = new Date();
  const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);
  
  const intervals = {
    year: 31536000,
    month: 2592000,
    week: 604800,
    day: 86400,
    hour: 3600,
    minute: 60,
  };
  
  for (const [unit, secondsInUnit] of Object.entries(intervals)) {
    const interval = Math.floor(seconds / secondsInUnit);
    if (interval >= 1) {
      return `${interval} ${unit}${interval > 1 ? 's' : ''} ago`;
    }
  }
  
  return 'Just now';
}

export function cn(...classes: (string | undefined | null | false)[]): string {
  return classes.filter(Boolean).join(' ');
}

export function debounce<T extends (...args: any[]) => any>(
  func: T,
  wait: number
): (...args: Parameters<T>) => void {
  let timeout: NodeJS.Timeout;
  return (...args: Parameters<T>) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => func(...args), wait);
  };
}
