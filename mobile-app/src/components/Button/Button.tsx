import React from 'react';
import {
  TouchableOpacity,
  Text,
  StyleSheet,
  ActivityIndicator,
  ViewStyle,
  TextStyle,
} from 'react-native';
import {theme} from '@theme';

type ButtonVariant = 'primary' | 'secondary' | 'accent';
type ButtonSize = 'small' | 'medium' | 'large';

interface ButtonProps {
  title: string;
  onPress: () => void;
  variant?: ButtonVariant;
  size?: ButtonSize;
  disabled?: boolean;
  loading?: boolean;
  fullWidth?: boolean;
  style?: ViewStyle;
  textStyle?: TextStyle;
}

export const Button: React.FC<ButtonProps> = ({
  title,
  onPress,
  variant = 'primary',
  size = 'medium',
  disabled = false,
  loading = false,
  fullWidth = false,
  style,
  textStyle,
}) => {
  const buttonStyles = [
    styles.button,
    styles[`button_${variant}`],
    styles[`button_${size}`],
    fullWidth && styles.fullWidth,
    disabled && styles.buttonDisabled,
    style,
  ];

  const textStyles = [
    styles.text,
    styles[`text_${variant}`],
    styles[`text_${size}`],
    disabled && styles.textDisabled,
    textStyle,
  ];

  return (
    <TouchableOpacity
      style={buttonStyles}
      onPress={onPress}
      disabled={disabled || loading}
      activeOpacity={0.8}>
      {loading ? (
        <ActivityIndicator
          color={variant === 'primary' || variant === 'accent' ? '#FFFFFF' : theme.colors.text.primary}
          size="small"
        />
      ) : (
        <Text style={textStyles}>{title}</Text>
      )}
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  button: {
    borderRadius: theme.borderRadius.md,
    alignItems: 'center',
    justifyContent: 'center',
    flexDirection: 'row',
  },
  button_primary: {
    backgroundColor: theme.colors.button.primary,
  },
  button_secondary: {
    backgroundColor: theme.colors.button.secondary,
  },
  button_accent: {
    backgroundColor: theme.colors.button.accent,
  },
  button_small: {
    paddingVertical: theme.spacing.sm,
    paddingHorizontal: theme.spacing.md,
    minHeight: 40,
  },
  button_medium: {
    paddingVertical: theme.spacing.md,
    paddingHorizontal: theme.spacing.lg,
    minHeight: 50,
  },
  button_large: {
    paddingVertical: theme.spacing.lg,
    paddingHorizontal: theme.spacing.xl,
    minHeight: 56,
  },
  fullWidth: {
    width: '100%',
  },
  buttonDisabled: {
    backgroundColor: theme.colors.button.disabled,
    opacity: 0.6,
  },
  text: {
    ...theme.typography.button,
    textAlign: 'center',
  },
  text_primary: {
    color: theme.colors.text.inverse,
  },
  text_secondary: {
    color: theme.colors.text.primary,
  },
  text_accent: {
    color: theme.colors.text.inverse,
  },
  text_small: {
    fontSize: 14,
  },
  text_medium: {
    fontSize: 16,
  },
  text_large: {
    fontSize: 18,
  },
  textDisabled: {
    opacity: 0.6,
  },
});

