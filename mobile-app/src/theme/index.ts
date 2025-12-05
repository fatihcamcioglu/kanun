/**
 * Kanun-i Mobile App - Theme Export
 * Centralized theme configuration
 */

import {colors, Colors} from './colors';
import {typography, Typography} from './typography';
import {spacing, borderRadius, iconSizes, Spacing, BorderRadius, IconSizes} from './spacing';

export const theme = {
  colors,
  typography,
  spacing,
  borderRadius,
  iconSizes,
};

export type Theme = typeof theme;

export type {Colors, Typography, Spacing, BorderRadius, IconSizes};

// Default export for easy access
export default theme;

