/**
 * Kanun-i Mobile App - Typography
 * Based on Figma design analysis
 */

export const typography = {
  // Logo Font (Serif)
  logo: {
    fontFamily: 'PlayfairDisplay-Bold', // Will need to add this font
    fontSize: 32,
    fontWeight: '700' as const,
    lineHeight: 40,
    letterSpacing: 0,
    color: '#0A4D68',
  },

  // Headings
  h1: {
    fontFamily: 'Poppins-Bold',
    fontSize: 32,
    fontWeight: '700' as const,
    lineHeight: 40,
    letterSpacing: 0,
    color: '#1F2937',
  },
  h2: {
    fontFamily: 'Poppins-Bold',
    fontSize: 24,
    fontWeight: '700' as const,
    lineHeight: 32,
    letterSpacing: 0,
    color: '#1F2937',
  },
  h3: {
    fontFamily: 'Poppins-SemiBold',
    fontSize: 20,
    fontWeight: '600' as const,
    lineHeight: 28,
    letterSpacing: 0,
    color: '#1F2937',
  },
  h4: {
    fontFamily: 'Poppins-SemiBold',
    fontSize: 18,
    fontWeight: '600' as const,
    lineHeight: 24,
    letterSpacing: 0,
    color: '#1F2937',
  },

  // Body Text
  body: {
    fontFamily: 'Poppins-Regular',
    fontSize: 16,
    fontWeight: '400' as const,
    lineHeight: 24,
    letterSpacing: 0,
    color: '#1F2937',
  },
  bodySmall: {
    fontFamily: 'Poppins-Regular',
    fontSize: 14,
    fontWeight: '400' as const,
    lineHeight: 20,
    letterSpacing: 0,
    color: '#4B5563',
  },
  bodyTiny: {
    fontFamily: 'Poppins-Regular',
    fontSize: 12,
    fontWeight: '400' as const,
    lineHeight: 16,
    letterSpacing: 0,
    color: '#6B7280',
  },

  // Subtitle
  subtitle: {
    fontFamily: 'Poppins-Regular',
    fontSize: 16,
    fontWeight: '400' as const,
    lineHeight: 24,
    letterSpacing: 0,
    color: '#4B5563',
  },

  // Button Text
  button: {
    fontFamily: 'Poppins-SemiBold',
    fontSize: 16,
    fontWeight: '600' as const,
    lineHeight: 24,
    letterSpacing: 0,
  },
  buttonLarge: {
    fontFamily: 'Poppins-SemiBold',
    fontSize: 18,
    fontWeight: '600' as const,
    lineHeight: 24,
    letterSpacing: 0,
  },

  // Input Text
  input: {
    fontFamily: 'Poppins-Regular',
    fontSize: 16,
    fontWeight: '400' as const,
    lineHeight: 24,
    letterSpacing: 0,
    color: '#1F2937',
  },
  inputPlaceholder: {
    fontFamily: 'Poppins-Regular',
    fontSize: 16,
    fontWeight: '400' as const,
    lineHeight: 24,
    letterSpacing: 0,
    color: '#6B7280',
  },

  // Link Text
  link: {
    fontFamily: 'Poppins-Regular',
    fontSize: 14,
    fontWeight: '400' as const,
    lineHeight: 20,
    letterSpacing: 0,
    color: '#D4A574',
  },

  // Caption
  caption: {
    fontFamily: 'Poppins-Regular',
    fontSize: 12,
    fontWeight: '400' as const,
    lineHeight: 16,
    letterSpacing: 0,
    color: '#6B7280',
  },
};

export type Typography = typeof typography;

