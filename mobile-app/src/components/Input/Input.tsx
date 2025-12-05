import React, {useState} from 'react';
import {
  View,
  TextInput,
  Text,
  StyleSheet,
  TextInputProps,
  TouchableOpacity,
} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {theme} from '@theme';

interface InputProps extends TextInputProps {
  label?: string;
  error?: string;
  helperText?: string;
  rightIcon?: string;
  onRightIconPress?: () => void;
  showPasswordToggle?: boolean;
}

export const Input: React.FC<InputProps> = ({
  label,
  error,
  helperText,
  rightIcon,
  onRightIconPress,
  showPasswordToggle = false,
  secureTextEntry,
  style,
  ...props
}) => {
  const [isPasswordVisible, setIsPasswordVisible] = useState(false);
  const [isFocused, setIsFocused] = useState(false);

  const inputStyles = [
    styles.input,
    isFocused && styles.inputFocused,
    error && styles.inputError,
    style,
  ];

  const togglePasswordVisibility = () => {
    setIsPasswordVisible(!isPasswordVisible);
  };

  return (
    <View style={styles.container}>
      {label && <Text style={styles.label}>{label}</Text>}
      <View style={styles.inputContainer}>
        <TextInput
          style={inputStyles}
          placeholderTextColor={theme.colors.input.placeholder}
          secureTextEntry={showPasswordToggle ? !isPasswordVisible : secureTextEntry}
          onFocus={() => setIsFocused(true)}
          onBlur={() => setIsFocused(false)}
          {...props}
        />
        {(rightIcon || showPasswordToggle) && (
          <TouchableOpacity
            style={styles.rightIconContainer}
            onPress={showPasswordToggle ? togglePasswordVisibility : onRightIconPress}>
            <MaterialIcons
              name={showPasswordToggle ? (isPasswordVisible ? 'visibility' : 'visibility-off') : (rightIcon as any) || 'help'}
              size={theme.iconSizes.md}
              color={theme.colors.text.tertiary}
            />
          </TouchableOpacity>
        )}
      </View>
      {error && <Text style={styles.errorText}>{error}</Text>}
      {helperText && !error && <Text style={styles.helperText}>{helperText}</Text>}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    marginBottom: theme.spacing.md,
  },
  label: {
    ...theme.typography.bodySmall,
    marginBottom: theme.spacing.xs,
    color: theme.colors.text.primary,
  },
  inputContainer: {
    position: 'relative',
    flexDirection: 'row',
    alignItems: 'center',
  },
  input: {
    ...theme.typography.input,
    backgroundColor: theme.colors.input.background,
    borderRadius: theme.borderRadius.sm,
    borderWidth: 1,
    borderColor: theme.colors.input.border,
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.md,
    flex: 1,
    minHeight: 50,
  },
  inputFocused: {
    borderColor: theme.colors.input.borderFocus,
  },
  inputError: {
    borderColor: theme.colors.input.error,
  },
  rightIconContainer: {
    position: 'absolute',
    right: theme.spacing.md,
    padding: theme.spacing.xs,
  },
  errorText: {
    ...theme.typography.caption,
    color: theme.colors.input.error,
    marginTop: theme.spacing.xs,
  },
  helperText: {
    ...theme.typography.caption,
    color: theme.colors.text.tertiary,
    marginTop: theme.spacing.xs,
  },
});

