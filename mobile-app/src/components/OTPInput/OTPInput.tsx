import React, {useRef, useState} from 'react';
import {View, TextInput, StyleSheet, Text} from 'react-native';
import {theme} from '@theme';

interface OTPInputProps {
  length?: number;
  onComplete: (otp: string) => void;
  error?: string;
}

export const OTPInput: React.FC<OTPInputProps> = ({
  length = 6,
  onComplete,
  error,
}) => {
  const [otp, setOtp] = useState<string[]>(Array(length).fill(''));
  const inputRefs = useRef<TextInput[]>([]);

  const handleChange = (text: string, index: number) => {
    const newOtp = [...otp];
    newOtp[index] = text;
    setOtp(newOtp);

    if (text && index < length - 1) {
      inputRefs.current[index + 1]?.focus();
    }

    const otpString = newOtp.join('');
    if (otpString.length === length) {
      onComplete(otpString);
    }
  };

  const handleKeyPress = (key: string, index: number) => {
    if (key === 'Backspace' && !otp[index] && index > 0) {
      inputRefs.current[index - 1]?.focus();
    }
  };

  return (
    <View style={styles.container}>
      <View style={styles.inputContainer}>
        {otp.map((digit, index) => (
          <TextInput
            key={index}
            ref={ref => {
              if (ref) {
                inputRefs.current[index] = ref;
              }
            }}
            style={[
              styles.input,
              otp[index] && styles.inputFilled,
              error && styles.inputError,
            ]}
            value={digit}
            onChangeText={text => handleChange(text.replace(/[^0-9]/g, ''), index)}
            onKeyPress={({nativeEvent}) => handleKeyPress(nativeEvent.key, index)}
            keyboardType="number-pad"
            maxLength={1}
            selectTextOnFocus
          />
        ))}
      </View>
      {error && <Text style={styles.errorText}>{error}</Text>}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    marginVertical: theme.spacing.md,
  },
  inputContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    gap: theme.spacing.sm,
  },
  input: {
    ...theme.typography.input,
    width: 50,
    height: 50,
    borderRadius: theme.borderRadius.sm,
    borderWidth: 1,
    borderColor: theme.colors.input.border,
    backgroundColor: theme.colors.input.background,
    textAlign: 'center',
    fontSize: 24,
    fontWeight: '600',
  },
  inputFilled: {
    borderColor: theme.colors.input.borderFocus,
    backgroundColor: theme.colors.background,
  },
  inputError: {
    borderColor: theme.colors.input.error,
  },
  errorText: {
    ...theme.typography.caption,
    color: theme.colors.input.error,
    marginTop: theme.spacing.sm,
    textAlign: 'center',
  },
});

