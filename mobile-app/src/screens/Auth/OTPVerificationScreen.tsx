import React, {useState} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  SafeAreaView,
  TouchableOpacity,
} from 'react-native';
import {Header} from '@components/Header';
import {OTPInput} from '@components/OTPInput';
import {Button} from '@components/Button';
import {theme} from '@theme';

interface OTPVerificationScreenProps {
  navigation: any;
  route: any;
}

export const OTPVerificationScreen: React.FC<OTPVerificationScreenProps> = ({
  navigation,
  route,
}) => {
  const {email} = route.params;
  const [otp, setOtp] = useState('');
  const [loading, setLoading] = useState(false);

  const handleOTPComplete = (code: string) => {
    setOtp(code);
  };

  const handleVerify = () => {
    setLoading(true);
    // TODO: Verify OTP
    setTimeout(() => {
      setLoading(false);
      navigation.navigate('NewPassword', {email, otp});
    }, 1000);
  };

  const handleResend = () => {
    // TODO: Resend OTP
  };

  return (
    <SafeAreaView style={styles.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.keyboardView}>
        <Header
          showLogo
          showBack
          onBackPress={() => navigation.goBack()}
          backgroundColor={theme.colors.background}
        />
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled">
          <View style={styles.content}>
            <Text style={styles.title}>Şifremi Unuttum</Text>
            <Text style={styles.subtitle}>
              6 haneli doğrulama kodunu e-posta adresinize gönderdik. Lütfen kodu yazınız
            </Text>
            <OTPInput
              length={6}
              onComplete={handleOTPComplete}
            />
            <TouchableOpacity onPress={handleResend}>
              <Text style={styles.resendText}>Tekrar gönder</Text>
            </TouchableOpacity>
            <Button
              title="İleri"
              onPress={handleVerify}
              loading={loading}
              fullWidth
              variant="primary"
              disabled={otp.length !== 6}
            />
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.background,
  },
  keyboardView: {
    flex: 1,
  },
  scrollContent: {
    flexGrow: 1,
    padding: theme.spacing.lg,
  },
  content: {
    flex: 1,
    paddingTop: theme.spacing.xl,
  },
  title: {
    ...theme.typography.h1,
    marginBottom: theme.spacing.md,
  },
  subtitle: {
    ...theme.typography.subtitle,
    marginBottom: theme.spacing.xl,
  },
  resendText: {
    ...theme.typography.link,
    marginBottom: theme.spacing.lg,
    textAlign: 'left',
  },
});

