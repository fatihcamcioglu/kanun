/**
 * Kanun-i Mobile App - Color Palette
 * Based on Figma design analysis
 */

export const colors = {
  // Primary Colors
  primary: '#0A4D68', // Deep Teal - Ana renk
  primaryDark: '#052E42',
  primaryLight: '#0F5F80',

  // Secondary Colors
  secondary: '#2563EB', // Royal Blue
  secondaryDark: '#1D4ED8',
  secondaryLight: '#3B82F6',

  // Accent Colors
  accent: '#D4A574', // Mustard Gold - Aksan rengi
  accentDark: '#B8935F',
  accentLight: '#E8B88A',

  // Background Colors
  background: '#FFFFFF', // Pure White
  backgroundSecondary: '#F5F5F0', // Creamy Off-White
  surface: '#F3F4F6', // Very Light Grey

  // Text Colors
  text: {
    primary: '#1F2937', // Almost Black Blue-Grey
    secondary: '#4B5563', // Medium Grey
    tertiary: '#6B7280', // Light Grey
    inverse: '#FFFFFF', // White
    link: '#D4A574', // Accent color for links
  },

  // Input Colors
  input: {
    background: '#F3F4F6',
    border: '#E5E7EB',
    borderFocus: '#0A4D68',
    placeholder: '#6B7280',
    error: '#EF4444',
    success: '#10B981',
  },

  // Status Colors
  status: {
    success: '#10B981',
    error: '#EF4444',
    warning: '#F59E0B',
    info: '#3B82F6',
    pending: '#6B7280',
  },

  // Button Colors
  button: {
    primary: '#0A4D68',
    primaryPressed: '#052E42',
    secondary: '#F3F4F6',
    secondaryPressed: '#E5E7EB',
    accent: '#D4A574',
    accentPressed: '#B8935F',
    disabled: '#D1D5DB',
  },

  // Border Colors
  border: {
    light: '#E5E7EB',
    medium: '#D1D5DB',
    dark: '#9CA3AF',
  },

  // Shadow Colors
  shadow: {
    light: 'rgba(0, 0, 0, 0.1)',
    medium: 'rgba(0, 0, 0, 0.15)',
    dark: 'rgba(0, 0, 0, 0.25)',
  },

  // Navigation Colors
  navigation: {
    background: '#0A4D68',
    active: '#D4A574', // Gold for active tab
    inactive: '#FFFFFF',
    highlight: '#FFFFFF',
  },
};

export type Colors = typeof colors;

